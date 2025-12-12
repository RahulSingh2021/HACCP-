<script>

document.addEventListener('DOMContentLoaded', () => {

    // --- DATA & STATE ---
    
    // Helper to generate recent, dynamic dates for sample data
    const formatDate = (date) => {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    };

    const today = new Date();
    const yesterday = new Date(today); yesterday.setDate(today.getDate() - 1);
    const lastWeek = new Date(today); lastWeek.setDate(today.getDate() - 7);
    const lastMonth = new Date(today); lastMonth.setMonth(today.getMonth() - 1);
    const twoMonthsAgo = new Date(today); twoMonthsAgo.setMonth(today.getMonth() - 2);
    const threeMonthsAgo = new Date(today); threeMonthsAgo.setMonth(today.getMonth() - 3);
    
let masterEmployeeList = [];     
  function loadMasterEmployeeList(filters = {}) {
    $.ajax({
      url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/trainer/get-user-unit',
      method: 'GET',
        data: filters,
      dataType: 'json',
      async: false,
      success: function (data) { 
          console.log('check111111',data);
        masterEmployeeList = data.map(emp => ({
          ...emp,
          initials: emp.initials ?? '',
          lastTrainedDate: formatDate(new Date(emp.lastTrainedDate || new Date())),
          avgHoursPerParticipant: emp.avgHoursPerParticipant || 1.5,
          rating: emp.rating || 0,
          departmentalReach: emp.departmentalReach || 0,
          certifications: emp.certifications || [],
        }));

      },
      error: function (xhr, status, error) {
      }
    });
  }


    loadMasterEmployeeList();

    $(document).on('change', '.status-filter-checkbox', function () {
        $('.status-filter-checkbox').not(this).prop('checked', false);
        requestAnimationFrame(() => {
            setTimeout(() => {
                const selectedStatuses = [];
                $('.status-filter-checkbox:checked').each(function () {
                    selectedStatuses.push($(this).val());
                });
    
                console.log("Selected Statuses:", selectedStatuses);
    
                loadMasterEmployeeList({
                    status: selectedStatuses.join(',')
                });
            }, 10); 
        });
    });


$(document).ready(function () {
    $(document).on('change', '.filter-checkbox-employee', function () {
        alert("Checkbox changed!");

        requestAnimationFrame(() => {
            setTimeout(() => {
                const selectedEmployeeIds = [];
                $('.filter-checkbox-employee:checked').each(function () {
                    selectedEmployeeIds.push($(this).val());
                });

                console.log("Selected Employee IDs:", selectedEmployeeIds);

                loadMasterEmployeeList({
                    employee: selectedEmployeeIds.join(',')
                });
            }, 10);
        });
    });
});

    

    let rosterEmployeeIds = [];
    let selectedForAddition = [];
    let selectedInTableIds = [];
    let currentFilteredRoster = [];
    let chartGranularity = 'monthly';
    const statusCycle = ['active', 'inactive', 'neutral'];
    let currentPage = 1;
    let rowsPerPage = 5;
    let lastOpenedDropdownKey = null;
    let lineGraphVisibility = { hours: true, sessions: true, avgHours: true };
    let lastLineChartData = {};
    
    const initialEmployeeFilters = { corporate: [], regional: [], unit: [], department: [], employee: [], certification: [], trainerLevel: [] };
    let activeEmployeeFilters = JSON.parse(JSON.stringify(initialEmployeeFilters));
    let tempEmployeeFilters = JSON.parse(JSON.stringify(initialEmployeeFilters));

    const initialMetricsFilters = { performanceLevel: [], sessions: { from: '', to: '' }, hrsDelivered: { from: '', to: '' }, avgDelivery: { from: '', to: '' }, deptReach: { from: '', to: '' }, selfLearning: { from: '', to: '' }, lastTrained: { from: '', to: '' } };
    let activeMetricsFilters = JSON.parse(JSON.stringify(initialMetricsFilters));
    let tempMetricsFilters = JSON.parse(JSON.stringify(initialMetricsFilters));

    let activeStatusFilters = [];

    // DOM Elements
    const tableBody = document.getElementById('employee-table-body');
    const selectAllTableCheckbox = document.getElementById('select-all-table-checkbox');
    const markActiveBtn = document.getElementById('mark-active-btn');
    const markInactiveBtn = document.getElementById('mark-inactive-btn');
    const searchInput = document.getElementById('employee-search-input');
    const resultsContainer = document.getElementById('search-results-container');
    const searchActionsContainer = document.getElementById('search-actions-container');
    const resultsList = document.getElementById('search-results-list');
    const selectionPreviewContainer = document.getElementById('selected-for-addition-preview');
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const bulkAddBtn = document.getElementById('bulk-add-btn');
    const paginationFooter = document.getElementById('pagination-footer');
    const refreshTableBtn = document.getElementById('refresh-table-btn');
    const refreshToast = document.getElementById('refresh-toast');
    const downloadExcelBtn = document.getElementById('download-excel-btn');
    const filterTagsContainer = document.getElementById('filter-tags-container');

    // Filter Elements
    const employeeFilterBtn = document.getElementById('employee-filter-btn');
    const employeeFilterModalOverlay = document.getElementById('employee-filter-modal-overlay');
    const closeEmployeeFilterModalBtn = document.getElementById('close-employee-filter-modal');
    const resetEmployeeFiltersBtn = document.getElementById('reset-employee-filters-btn');
    const applyEmployeeFiltersBtn = document.getElementById('apply-employee-filters-btn');
    const cascadingFilterContainer = document.getElementById('cascading-filter-container');
    const metricsFilterBtn = document.getElementById('metrics-filter-btn');
    const metricsFilterModalOverlay = document.getElementById('metrics-filter-modal-overlay');
    const metricsFilterBody = document.getElementById('metrics-filter-body');
    const closeMetricsFilterModalBtn = document.getElementById('close-metrics-filter-modal');
    const applyMetricsFilterBtn = document.getElementById('apply-metrics-filter-btn');
    const resetMetricsFilterBtn = document.getElementById('reset-metrics-filter-btn');
    const statusFilterBtn = document.getElementById('status-filter-btn');
    const statusFilterDropdown = document.getElementById('status-filter-dropdown');
    const chartGranularitySelector = document.getElementById('chart-granularity-selector');
    const chartLegend = document.getElementById('chart-legend');
    const downloadChartPngBtn = document.getElementById('download-chart-png');
    const downloadChartPdfBtn = document.getElementById('download-chart-pdf');


    function getStatusInfo(status) {
        return {
            'active': { text: 'Active', icon: 'fa-check-circle' },
            'inactive': { text: 'Inactive', icon: 'fa-times-circle' },
            'neutral': { text: 'Neutral', icon: 'fa-circle-notch' }
        }[status];
    }
    
    function calculateTrainerPerformanceScores() {
        const trainers = masterEmployeeList.filter(emp => emp.isTrainer);
        if (trainers.length === 0) return;
        
        const weights = { versatility: 0.2, reach: 0.2, volume: 0.2, efficiency: 0.2, compliance: 0.2 };
        const maxValues = { uniqueCourses: 0, participants: 0, hours: 0, efficiency: 0, compliance: 0 };

        trainers.forEach(trainer => {
            trainer.efficiency = trainer.delivered_hours > 0 ? trainer.delivered_participants / trainer.delivered_hours : 0;
            trainer.complianceRatio = trainer.trainingUniqueTotal > 0 ? trainer.trainingUniqueCompleted / trainer.trainingUniqueTotal : 0;
            trainer.avgHoursPerParticipant = trainer.delivered_participants > 0 ? trainer.delivered_hours / trainer.delivered_participants : 0;
            const dept = trainer.department;
            const totalInDept = masterEmployeeList.filter(e => e.department === dept).length;
            trainer.departmentalReach = totalInDept > 0 ? Math.min(1, (trainer.delivered_participants / totalInDept)) : 0;
            maxValues.uniqueCourses = Math.max(maxValues.uniqueCourses, trainer.delivered_uniqueCourses);
            maxValues.participants = Math.max(maxValues.participants, trainer.delivered_participants);
            maxValues.hours = Math.max(maxValues.hours, trainer.delivered_hours);
            maxValues.efficiency = Math.max(maxValues.efficiency, trainer.efficiency);
            maxValues.compliance = Math.max(maxValues.compliance, trainer.complianceRatio);
        });

        trainers.forEach(trainer => {
            const normVersatility = maxValues.uniqueCourses > 0 ? (trainer.delivered_uniqueCourses / maxValues.uniqueCourses) : 0;
            const normReach = maxValues.participants > 0 ? (trainer.delivered_participants / maxValues.participants) : 0;
            const normVolume = maxValues.hours > 0 ? (trainer.delivered_hours / maxValues.hours) : 0;
            const normEfficiency = maxValues.efficiency > 0 ? (trainer.efficiency / maxValues.efficiency) : 0;
            const normCompliance = maxValues.compliance > 0 ? trainer.complianceRatio : 0;
            const score = (normVersatility * weights.versatility) + (normReach * weights.reach) + (normVolume * weights.volume) + (normEfficiency * weights.efficiency) + (normCompliance * weights.compliance);
            const masterRecord = masterEmployeeList.find(e => e.id === trainer.id);
            if (masterRecord) { 
                masterRecord.performanceScore = score;
                masterRecord.rating = Math.max(1, score * 4 + 1);
                if (masterRecord.rating >= 4.0) masterRecord.performanceLevel = 'High Performer';
                else if (masterRecord.rating >= 2.5) masterRecord.performanceLevel = 'Medium Performer';
                else masterRecord.performanceLevel = 'Low Performer';
            }
        });
    }

    // --- CHART LOGIC ---
    function getStartOfWeek(d) {
        const date = new Date(d);
        const day = date.getUTCDay();
        const diff = date.getUTCDate() - day + (day === 0 ? -6 : 1);
        return new Date(date.setUTCDate(diff));
    }

    function getPeriodKey(dateString, granularity) {
        if (!dateString) return null;
        const d = new Date(dateString + 'T00:00:00Z');
        if (isNaN(d.getTime())) return null;

        const year = d.getUTCFullYear();
        const month = String(d.getUTCMonth() + 1).padStart(2, '0');
        const day = String(d.getUTCDate()).padStart(2, '0');

        switch(granularity) {
            case 'daily': return `${year}-${month}-${day}`;
            case 'weekly':
                const startOfWeek = getStartOfWeek(d);
                const wYear = startOfWeek.getUTCFullYear();
                const wMonth = String(startOfWeek.getUTCMonth() + 1).padStart(2, '0');
                const wDay = String(startOfWeek.getUTCDate()).padStart(2, '0');
                return `${wYear}-${wMonth}-${wDay}`;
            case 'monthly': return `${year}-${month}`;
            case 'yearly': return `${year}`;
            default: return null;
        }
    }

    function getChartTimeline(granularity, dateFilters) {
        const keys = [];
        const today = new Date();
        today.setUTCHours(0, 0, 0, 0);

        if (dateFilters.from && dateFilters.to) {
            let current = new Date(dateFilters.from + 'T00:00:00Z');
            const end = new Date(dateFilters.to + 'T00:00:00Z');

            while (current <= end) {
                const key = getPeriodKey(current.toISOString().slice(0, 10), granularity);
                if (!keys.includes(key)) keys.push(key);
                switch (granularity) {
                    case 'daily': current.setUTCDate(current.getUTCDate() + 1); break;
                    case 'weekly': current.setUTCDate(current.getUTCDate() + 7); break;
                    case 'monthly': current.setUTCMonth(current.getUTCMonth() + 1); break;
                    case 'yearly': current.setUTCFullYear(current.getUTCFullYear() + 1); break;
                }
            }
        } else {
            let current = new Date(today);
            for (let i = 0; i < 6; i++) {
                const key = getPeriodKey(current.toISOString().slice(0, 10), granularity);
                keys.push(key);
                switch (granularity) {
                    case 'daily': current.setUTCDate(current.getUTCDate() - 1); break;
                    case 'weekly': current.setUTCDate(current.getUTCDate() - 7); break;
                    case 'monthly': current.setUTCMonth(current.getUTCMonth() - 1); break;
                    case 'yearly': current.setUTCFullYear(current.getUTCFullYear() - 1); break;
                }
            }
            keys.reverse();
        }

        const labels = keys.map(key => {
            if (granularity === 'daily') return new Date(key + 'T00:00:00Z').toLocaleDateString('en-US', { timeZone: 'UTC', month: 'short', day: 'numeric' });
            if (granularity === 'weekly') return `W/C ${new Date(key + 'T00:00:00Z').toLocaleDateString('en-US', { timeZone: 'UTC', month: 'short', day: 'numeric' })}`;
            if (granularity === 'monthly') { const [year, month] = key.split('-'); return new Date(Date.UTC(year, month - 1, 2)).toLocaleString('default', { timeZone: 'UTC', month: 'short', year: '2-digit' }); }
            if (granularity === 'yearly') return key;
            return key;
        });

        return { keys, labels };
    }

    function renderLineChart() {
        // console.log('lastLineChartData',lastLineChartData);
        const { lineDataSets, groupColors, timeline, maxLargeScaleValue, maxAvgScaleValue } = lastLineChartData;
        const canvas = document.getElementById('line-chart-canvas');
        const yAxisRight = document.getElementById('line-chart-yaxis-right');
        const yAxisAvg = document.getElementById('line-chart-yaxis-avg');
        
        yAxisRight.innerHTML = '';
        yAxisAvg.innerHTML = '';

        const ctx = canvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        canvas.width = canvas.clientWidth * dpr;
        canvas.height = canvas.clientHeight * dpr;
        ctx.scale(dpr, dpr);
        ctx.clearRect(0, 0, canvas.clientWidth, canvas.clientHeight);

        if (!canvas || !lineDataSets || lineDataSets.length === 0) return;
        
        console.log('lineDataSets',lineDataSets);
 
        const numGridLines = 5;
        const yAxisLargeCeiling = maxLargeScaleValue > 0 ? Math.ceil(maxLargeScaleValue / numGridLines) * numGridLines || numGridLines : numGridLines;
        const yAxisAvgCeiling = maxAvgScaleValue > 0 ? Math.ceil(maxAvgScaleValue / numGridLines) * numGridLines || numGridLines : numGridLines;
        
        const yAxisLargeStep = yAxisLargeCeiling / numGridLines;
        const yAxisAvgStep = yAxisAvgCeiling / numGridLines;
        
        for (let i = numGridLines; i >= 0; i--) {
            const largeLabelValue = i * yAxisLargeStep;
            yAxisRight.innerHTML += `<span>${Number.isInteger(largeLabelValue) ? largeLabelValue : largeLabelValue.toFixed(1)}</span>`;

            const avgLabelValue = i * yAxisAvgStep;
            yAxisAvg.innerHTML += `<span>${Number.isInteger(avgLabelValue) ? avgLabelValue : avgLabelValue.toFixed(1)}</span>`;
        }
        
        lineDataSets.forEach(dataSet => {
            if (!lineGraphVisibility[dataSet.key]) return;

            const isAvg = dataSet.scale === 'avg';
            const yAxisCeiling = isAvg ? yAxisAvgCeiling : yAxisLargeCeiling;
            if(yAxisCeiling === 0) return;

            groupColors.forEach((color, groupName) => {
                const groupData = dataSet.data[groupName];
                if (!groupData) return;

                ctx.beginPath();
                ctx.strokeStyle = color;
                ctx.lineWidth = 3;
                ctx.lineJoin = 'round';
                ctx.lineCap = 'round';
                
                if (dataSet.style === 'dashed') {
                    ctx.setLineDash([5, 5]);
                } else if (dataSet.style === 'dotted') {
                    ctx.setLineDash([2, 3]);
                } else {
                    ctx.setLineDash([]);
                }

                let firstPoint = true;
                timeline.keys.forEach((key, index) => {
                    const value = groupData[key] || 0;
                    const x = (index + 0.5) * (canvas.clientWidth / timeline.keys.length);
                    const y = canvas.clientHeight - (value / yAxisCeiling) * canvas.clientHeight;
                    if (firstPoint) { ctx.moveTo(x, y); firstPoint = false; } else { ctx.lineTo(x, y); }
                });
                ctx.stroke();

                ctx.font = 'bold 12px Inter, sans-serif';
                ctx.textAlign = 'center';
                timeline.keys.forEach((key, index) => {
                    const value = groupData[key] || 0;
                    if (value > 0) {
                        const x = (index + 0.5) * (canvas.clientWidth / timeline.keys.length);
                        const y = canvas.clientHeight - (value / yAxisCeiling) * canvas.clientHeight;
                        ctx.fillStyle = color;
                        ctx.beginPath(); ctx.arc(x, y, 5, 0, 2 * Math.PI); ctx.fill();
                        ctx.fillStyle = '#fff';
                        ctx.beginPath(); ctx.arc(x, y, 3, 0, 2 * Math.PI); ctx.fill();

                        ctx.fillStyle = color;
                        const formattedValue = Number.isInteger(value) ? value : value.toFixed(1);
                        ctx.fillText(formattedValue, x, y - 10);
                    }
                });
            });
        });
        ctx.setLineDash([]);
    }


    function render3DChart(filteredData, granularity, dateFilters) {
        // console.log('filteredData',filteredData);
        const barsContainer = document.getElementById('chart-bars-container');
        const barTotalsContainer = document.getElementById('chart-bar-totals-container');
        const labelsAxis = document.getElementById('chart-xaxis-labels');
        const yAxisLeft = document.getElementById('chart-yaxis');
        const gridLines = document.getElementById('chart-grid-lines');
        const noDataOverlay = document.getElementById('chart-no-data-overlay');
        const legendContainer = document.getElementById('chart-legend');
        const chartTitle = document.getElementById('chart-main-title');

        [barsContainer, barTotalsContainer, labelsAxis, yAxisLeft, gridLines, legendContainer].forEach(el => el.innerHTML = '');
        
        const timeline = getChartTimeline(granularity, dateFilters);

        const trainersInTimeline = filteredData.filter(emp => 
            emp.isTrainer && emp.lastTrainedDate && timeline.keys.includes(getPeriodKey(emp.lastTrainedDate, granularity))
        );
        
        if (trainersInTimeline.length === 0) {
            noDataOverlay.style.display = 'flex';
            yAxisLeft.innerHTML = `<span></span>`;
            document.getElementById('line-chart-yaxis-avg').innerHTML = `<span></span>`;
            gridLines.innerHTML = `<div class="grid-line"></div>`;
            lastLineChartData = {};
            renderLineChart();
            return;
        }
        noDataOverlay.style.display = 'none';
        
        let groupingKey = 'corporate';
        let chartTitleText = 'Corporate';
        if (activeEmployeeFilters.department.length > 0) {
            groupingKey = 'department';
            chartTitleText = 'Department';
        } else if (activeEmployeeFilters.unit.length > 0) {
            groupingKey = 'unit';
            chartTitleText = 'Unit';
        } else if (activeEmployeeFilters.regional.length > 0) {
            groupingKey = 'regional';
            chartTitleText = 'Regional';
        }
        chartTitle.textContent = `Trainer Performance & Sessions by ${chartTitleText}`;

        const groups = [...new Set(trainersInTimeline.map(emp => emp[groupingKey]))].sort();
        if (groups.length === 0) {
            noDataOverlay.style.display = 'flex';
            return;
        }

        const aggregatedData = {};
        const sessionsByGroupAndPeriod = {};
        const hoursByGroupAndPeriod = {};
        const avgHoursByGroupAndPeriod = {};
        let maxTotalInBar = 0;
        
        const lineColors = ['#8b5cf6', '#f97316', '#22c55e', '#ef4444', '#3b82f6', '#f59e0b', '#10b981', '#6366f1'];
        const groupColors = new Map();
        groups.forEach((group, i) => {
            groupColors.set(group, lineColors[i % lineColors.length]);
        });

        groups.forEach(groupName => {
            aggregatedData[groupName] = {};
            sessionsByGroupAndPeriod[groupName] = {};
            hoursByGroupAndPeriod[groupName] = {};
            avgHoursByGroupAndPeriod[groupName] = {};
            timeline.keys.forEach(key => {
                aggregatedData[groupName][key] = { high: 0, medium: 0, low: 0, total: 0, totalSessions: 0, totalHours: 0, totalParticipants: 0 };
            });
        });

        trainersInTimeline.forEach(emp => {
            const key = getPeriodKey(emp.lastTrainedDate, granularity);
            const groupName = emp[groupingKey];
            if (aggregatedData[groupName] && aggregatedData[groupName][key]) {
                if (emp.performanceLevel === 'High Performer') aggregatedData[groupName][key].high++;
                else if (emp.performanceLevel === 'Medium Performer') aggregatedData[groupName][key].medium++;
                else if (emp.performanceLevel === 'Low Performer') aggregatedData[groupName][key].low++;
                
                aggregatedData[groupName][key].total++;
                aggregatedData[groupName][key].totalSessions += (emp.delivered_uniqueCourses || 0);
                aggregatedData[groupName][key].totalHours += (emp.delivered_hours || 0);
                aggregatedData[groupName][key].totalParticipants += (emp.delivered_participants || 0);

                if (aggregatedData[groupName][key].total > maxTotalInBar) maxTotalInBar = aggregatedData[groupName][key].total;
            }
        });

        groups.forEach(groupName => {
            timeline.keys.forEach(key => {
                const data = aggregatedData[groupName][key];
                sessionsByGroupAndPeriod[groupName][key] = data.totalSessions;
                hoursByGroupAndPeriod[groupName][key] = data.totalHours;
                avgHoursByGroupAndPeriod[groupName][key] = data.totalParticipants > 0 ? (data.totalHours / data.totalParticipants) : 0;
            });
        });
        
        const yAxisCeiling = maxTotalInBar > 0 ? Math.ceil(maxTotalInBar / 5) * 5 || 5 : 5;
        const numGridLines = 10;
        const yAxisStep = yAxisCeiling / numGridLines;
        
        for (let i = numGridLines; i >= 0; i--) {
            const labelValue = i * yAxisStep;
            const labelText = Number.isInteger(labelValue) ? labelValue : labelValue.toFixed(1);
            yAxisLeft.innerHTML += `<span>${labelText}</span>`;
            gridLines.innerHTML += `<div class="grid-line"></div>`;
        }
        
        let allSessions = [];
        Object.values(sessionsByGroupAndPeriod).forEach(periodData => allSessions.push(...Object.values(periodData)));
        let allHours = [];
        Object.values(hoursByGroupAndPeriod).forEach(periodData => allHours.push(...Object.values(periodData)));
        let allAvgHours = [];
        Object.values(avgHoursByGroupAndPeriod).forEach(periodData => allAvgHours.push(...Object.values(periodData)));

        const maxLargeScaleValue = Math.max(0, ...allSessions, ...allHours);
        const maxAvgScaleValue = Math.max(0, ...allAvgHours);

        let labelsHTML = '';
        timeline.keys.forEach((key, index) => {
            groups.forEach(groupName => {
                const data = aggregatedData[groupName][key];
                const { high, medium, low, total, totalSessions, totalHours } = data;
                
                const highHeight = yAxisCeiling > 0 ? (high / yAxisCeiling) * 100 : 0;
                const mediumHeight = yAxisCeiling > 0 ? (medium / yAxisCeiling) * 100 : 0;
                const lowHeight = yAxisCeiling > 0 ? (low / yAxisCeiling) * 100 : 0;
                const totalHeight = (total / yAxisCeiling) * 100;
                const avgHoursForBar = data.totalParticipants > 0 ? (data.totalHours / data.totalParticipants).toFixed(1) : 0;
                const tooltip = `Avg. Hrs/Person: ${avgHoursForBar}\nTotal Hours: ${totalHours}\nTotal Sessions: ${totalSessions}\nTotal Trainers: ${total}\nHigh: ${high}\nMedium: ${medium}\nLow: ${low}`;
                
                let segmentsHTML = '';
                
                if (highHeight > 0) {
                    const topClass = (mediumHeight === 0 && lowHeight === 0) ? 'top-segment' : '';
                    const label = highHeight > 5 ? `<span class="segment-label">${high}</span>` : '';
                    segmentsHTML += `<div class="segment high ${topClass}" style="height: ${highHeight}%;" data-tooltip="${tooltip}">${label}</div>`;
                }
                if (mediumHeight > 0) {
                    const topClass = (lowHeight === 0) ? 'top-segment' : '';
                    const label = mediumHeight > 5 ? `<span class="segment-label">${medium}</span>` : '';
                    segmentsHTML += `<div class="segment medium ${topClass}" style="height: ${mediumHeight}%;" data-tooltip="${tooltip}">${label}</div>`;
                }
                if (lowHeight > 0) {
                    const label = lowHeight > 5 ? `<span class="segment-label">${low}</span>` : '';
                    segmentsHTML += `<div class="segment low top-segment" style="height: ${lowHeight}%;" data-tooltip="${tooltip}">${label}</div>`;
                }

                barsContainer.innerHTML += `<div class="bar">${segmentsHTML}</div>`;
                if(total > 0) {
                    barTotalsContainer.innerHTML += `<div class="bar-total-label"><span style="bottom: ${totalHeight}%;">${total}</span></div>`;
                } else {
                    barTotalsContainer.innerHTML += `<div class="bar-total-label"></div>`;
                }
                
                labelsHTML += `
                    <div class="x-axis-label">
                        <div>
                            <span class="label-group">${groupName}</span>
                            <span class="label-period">${timeline.labels[index]}</span>
                        </div>
                    </div>
                `;
            });
        });
        labelsAxis.innerHTML = labelsHTML;

        groupColors.forEach((color, groupName) => {
            legendContainer.innerHTML += `<div class="legend-item ${lineGraphVisibility.hours ? '' : 'inactive'}" data-metric="hours"><div class="legend-key-line" style="border-color: ${color};"></div><span>${groupName} Hours</span></div>`;
            legendContainer.innerHTML += `<div class="legend-item ${lineGraphVisibility.sessions ? '' : 'inactive'}" data-metric="sessions"><div class="legend-key-line dashed" style="border-color: ${color};"></div><span>${groupName} Sessions</span></div>`;
            legendContainer.innerHTML += `<div class="legend-item ${lineGraphVisibility.avgHours ? '' : 'inactive'}" data-metric="avgHours"><div class="legend-key-line dotted" style="border-color: ${color};"></div><span>${groupName} Avg. Hrs</span></div>`;
        });
        legendContainer.innerHTML += `
            <hr style="width:100%; border:none; border-top:1px solid var(--border-color); margin: 0.5rem 0;">
            <div class="legend-item"><div class="legend-key" style="background-color: var(--chart-color-high);"></div><span>High Perf.</span></div>
            <div class="legend-item"><div class="legend-key" style="background-color: var(--chart-color-medium);"></div><span>Medium Perf.</span></div>
            <div class="legend-item"><div class="legend-key" style="background-color: var(--chart-color-low);"></div><span>Low Perf.</span></div>
        `;
        
        lastLineChartData = {
            lineDataSets: [
                { key: 'hours', data: hoursByGroupAndPeriod, style: 'solid', scale: 'large' },
                { key: 'sessions', data: sessionsByGroupAndPeriod, style: 'dashed', scale: 'large' },
                { key: 'avgHours', data: avgHoursByGroupAndPeriod, style: 'dotted', scale: 'avg' }
            ],
            groupColors,
            timeline,
            maxLargeScaleValue,
            maxAvgScaleValue
        };
        renderLineChart();
    }

    function createTableRowHTML(employeeData) {
        console.log('employeeDataemployeeDataemployeeData',employeeData);
        const isSelected = selectedInTableIds.includes(employeeData.id);
        
        let trainerSpecificInfo = '';
        if (employeeData.isTrainer) {
            const categoryClass = employeeData.trainerCategory.toLowerCase().replace(' ', '-');
            trainerSpecificInfo = `<div class="trainer-info-in-cell"><div class="trainer-qual">
            ${employeeData.trainerQualification}</div><div><span class="trainer-category-badge cat-${categoryClass}">${employeeData.trainerCategory}</span></div></div>`;
        }
        
        const employeeInfoCell = `<div class="employee-info"><span class="name">${employeeData.name}</span>
            
            <div class="corporate-details"><span>${employeeData.corporate || 'N/A'}</span>
                <span>${employeeData.regional || 'N/A'}</span><span>${employeeData.unit || 'N/A'}</span>
                </div>
        
        <div class="employee-details"><span>
        <i class="fa-solid fa-id-badge"></i> IDs: ${employeeData.employe_id}</span><span>Born : ${employeeData.dob ?? "N/A"}</span>
        <span>Joining : ${employeeData.dog ?? "N/A"}</span> <span>Gender : ${employeeData.gender ?? "N/A"}</span></div>${trainerSpecificInfo}</div></div>`;
        
        const roleCell = `<div class="cell-stack"><div class="sub-label">${employeeData.role}</div>
        <div class="sub-label">Department : ${employeeData.department_new}</div>
          <div class="sub-label">Responsibility : ${employeeData.responsibility_new}</div>
        </div>`;

        let certificationsCell = '<div class="cell-stack">';
        if (employeeData.certifications && employeeData.certifications.length > 0) {
            employeeData.certifications.forEach(cert => {
                const statusClass = cert.status.toLowerCase().replace(' ', '-');
                const viewLink = cert.status === 'Completed' ? `<a href="#" class="view-cert-link" onclick="alert('Viewing certificate for: ${cert.name.replace(/'/g, "\\'")}'); return false;"><i class="fas fa-eye"></i> View</a>` : '';
                certificationsCell += `<div class="cert-item"><div><span class="label">${cert.name}</span><span class="cert-status-badge cert-status-${statusClass}">${cert.status}</span></div><div class="cert-details"><span class="sub-label">${cert.date}</span>${viewLink}</div></div>`;
            });
        } else { certificationsCell += '<span class="sub-label">N/A</span>'; }
        certificationsCell += '</div>';

        let metricsCell = '';
        if (employeeData.isTrainer) {
            const perfClass = (employeeData.performanceLevel || 'low').split(' ')[0].toLowerCase();
            metricsCell = `<div class="cell-stack"><div class="trainer-badges-wrapper"><div class="trainer-badges-left">
            <span class="table-trainer-badge"><i class="fas fa-chalkboard-teacher"></i> Trainer</span><span class="performance-badge perf-${perfClass}">
            ${employeeData.performanceLevel}</span></div><span class="label" style="color: var(--primary-color);" title="Trainer Rating (out of 5.0)">
            <i class="fas fa-star" style="color: var(--yellow);"></i> ${(employeeData.rating || 0).toFixed(1)}</span></div>
            <div class="sub-label" title="Total unique training sessions delivered"><i class="fa-solid fa-person-chalkboard"></i> 
            Sessions: 0</div><div class="sub-label" title="Total training hours delivered"><i class="fa-solid fa-business-time"></i> Hours Delivered: 0 hrs</div><div class="sub-label" title="Average hours delivered per participant"><i class="fa-solid fa-clock"></i> Avg. Delivery: 0 hrs/person</div><div class="sub-label" title="Percentage of own department trained"><i class="fa-solid fa-users-viewfinder"></i> Dept. Reach: ${(employeeData.departmentalReach * 100).toFixed(0)}%</div><hr style="border: none; border-top: 1px dashed var(--border-color); margin: 4px 0;"><div class="sub-label" title="Personal training hours completed"><i class="fa-solid fa-user-graduate"></i> Self-Learning: 0 hrs</div></div>`;
        } else {
            metricsCell = `<div class="cell-stack"><div class="label">${employeeData.trainingTotalHours} hrs Learned</div><div class="sub-label" title="Courses Completed / Assigned">${employeeData.trainingUniqueCompleted} / ${employeeData.trainingUniqueTotal} courses</div></div>`;
        }

        const statusInfo = getStatusInfo(employeeData.status);
        // return `<tr data-employee-id="${employeeData.id}"><td><input type="checkbox" class="row-checkbox" ${isSelected ? 'checked' : ''}><br/>${employeeData.sno}</td><td>${employeeInfoCell}</td><td>${roleCell}</td><td>${certificationsCell}</td><td>${metricsCell}</td><td><div class="status-indicator status-${employeeData.status}" data-status="${employeeData.status}"><i class="fas ${statusInfo.icon}"></i><span>${statusInfo.text}</span></div></td><td class="action-cell">
        // <i class="fas fa-trash-alt icon" title="Delete"></i></td></tr>`;
        
        console.log("employeeData.status",employeeData)
        const statusDropdown = `
             <div class="status-dropdown-wrapper">
                <select class="status-dropdown" data-id="${employeeData.id}" style="
              border-radius: 6px;
              font-size: 14px;
              border: 1px solid #bbb;
              background-color: #fff;
              color: #333;
              min-width: 120px;
              cursor: pointer;
            ">
                  <option value="1" ${employeeData.status1 === "1" ? 'selected' : ''}>🟢 Active</option>
                  <option value="2" ${employeeData.status1 === "2" ? 'selected' : ''}>🔴 Inactive</option>
                  <option value="3" ${employeeData.status1 === "3" ? 'selected' : ''}>🟡 Neutral</option>
                </select>
              </div>
            `;


        return `
        <tr data-employee-id="${employeeData.id}">
          <td><input type="checkbox" class="row-checkbox" ${isSelected ? 'checked' : ''}><br/>${employeeData.sno}</td>
          <td>${employeeInfoCell}</td>
          <td>${roleCell}</td>
          <td>${certificationsCell}</td>
          <td>${metricsCell}</td>
         <td>${statusDropdown}</td>

          <td class="action-cell">
            <i class="fas fa-trash-alt icon delete-icon" title="Delete" data-id="${employeeData.id}"></i>
          </td>
        </tr>`;
    }
    

    $(document).on('change', '.status-dropdown', function () {
        const $select = $(this);
        const newStatus = $select.val();
        const employeeId = $select.data('id');
        alert(employeeId);
    
        $.ajax({
            url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/trainer/update-trainer-employee-status', 
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: employeeId,
                status: newStatus
            },
            
            success: function (response) {
                 toastr.success("Status updated successfully!");
                //  sessionStorage.setItem('activateTab', '#trainer');
                //  window.location.reload();
            },
            error: function (xhr, status, error) {
    }
        });
    });

    
    $(document).on('click', '.delete-icon', function () {
    const employeeId = $(this).data('id');
        // if (confirm('Are you sure you want to delete this employee?')) {
        // }
        $.ajax({
            url: `https://efsm.safefoodmitra.com/admin/public/index.php/training/trainer/delete/${employeeId}`,
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (response) {
                $(`tr[data-employee-id="${employeeId}"]`).remove();
                 toastr.success("Deleted successfully!");
                 sessionStorage.setItem('activateTab', '#trainer');
                  window.location.reload();
            },
            error: function (xhr) {
                alert('Failed to delete employee.');
            }
        });
    });



    function renderTable() {
        calculateTrainerPerformanceScores();
        console.log("masterEmployeeListmasterEmployeeList",masterEmployeeList);
        currentFilteredRoster =masterEmployeeList ;
        // currentFilteredRoster = rosterEmployeeIds
        //     .map(id => masterEmployeeList.find(emp => emp.id === id)).filter(Boolean)
        //     .filter(emp => {
        //          if (activeStatusFilters.length > 0 && !activeStatusFilters.includes(emp.status)) return false;
        //          return true;
        //     })
        //     .filter(emp => {
        //         const { corporate, regional, unit, department, employee, certification, trainerLevel } = activeEmployeeFilters;

        //         if (corporate.length > 0 && !corporate.includes(emp.corporate)) return false;
        //         if (regional.length > 0 && !regional.includes(emp.regional)) return false;
        //         if (unit.length > 0 && !unit.includes(emp.unit)) return false;
        //         if (department.length > 0 && !department.includes(emp.department)) return false;
                
        //         if (employee.length > 0 && !employee.includes(emp.id)) return false;
        //         if (certification.length > 0 && !certification.some(certName => emp.certifications.some(c => c.name === certName))) return false;
        //         if (trainerLevel.length > 0 && (!emp.isTrainer || !trainerLevel.includes(emp.trainerQualification))) return false;
        //         return true;
        //     })
        //     .filter(emp => {
        //         const { performanceLevel, sessions, hrsDelivered, avgDelivery, deptReach, selfLearning, lastTrained } = activeMetricsFilters;
        //         if (performanceLevel.length > 0 && (!emp.isTrainer || !performanceLevel.includes(emp.performanceLevel))) return false;
        //         if (sessions.from && (!emp.isTrainer || emp.delivered_uniqueCourses < parseFloat(sessions.from))) return false;
        //         if (sessions.to && (!emp.isTrainer || emp.delivered_uniqueCourses > parseFloat(sessions.to))) return false;
        //         if (hrsDelivered.from && (!emp.isTrainer || emp.delivered_hours < parseFloat(hrsDelivered.from))) return false;
        //         if (hrsDelivered.to && (!emp.isTrainer || emp.delivered_hours > parseFloat(hrsDelivered.to))) return false;
        //         if (avgDelivery.from && (!emp.isTrainer || emp.avgHoursPerParticipant < parseFloat(avgDelivery.from))) return false;
        //         if (avgDelivery.to && (!emp.isTrainer || emp.avgHoursPerParticipant > parseFloat(avgDelivery.to))) return false;
        //         if (deptReach.from && (!emp.isTrainer || emp.departmentalReach * 100 < parseFloat(deptReach.from))) return false;
        //         if (deptReach.to && (!emp.isTrainer || emp.departmentalReach * 100 > parseFloat(deptReach.to))) return false;
        //         if (selfLearning.from && emp.trainingTotalHours < parseFloat(selfLearning.from)) return false;
        //         if (selfLearning.to && emp.trainingTotalHours > parseFloat(selfLearning.to)) return false;
        //         if (lastTrained.from && (!emp.lastTrainedDate || emp.lastTrainedDate < lastTrained.from)) return false;
        //         if (lastTrained.to && (!emp.lastTrainedDate || emp.lastTrainedDate > lastTrained.to)) return false;
                
        //         return true;
        //     })
        //     .sort((a, b) => {
        //         const statusOrder = { active: 0, neutral: 0, inactive: 1 };
        //         return (statusOrder[a.status] - statusOrder[b.status]) || (b.isTrainer - a.isTrainer) || ((b.rating || 0) - (a.rating || 0));
        //     });
            
        console.log("currentFilteredRoster",currentFilteredRoster);
        
        const chartDataRoster = currentFilteredRoster.filter(emp => {
            const {from, to} = activeMetricsFilters.lastTrained;
            if(from && to) return true;
            return true;
        });
        
        //  console.log("chartDataRoster",chartDataRoster);
        

        render3DChart(chartDataRoster, chartGranularity, activeMetricsFilters.lastTrained);
            //  console.log("111111111");
    
                // console.log("chartGranularity",chartGranularity);
                
                //   console.log("activeMetricsFilters.lastTrained",activeMetricsFilters.lastTrained);
           
        populateExternalDropdowns(currentFilteredRoster);

        console.log("currentFilteredRoster.length",currentFilteredRoster.length);
           console.log("rowsPerPage",rowsPerPage);
           
        const totalPages = Math.ceil(currentFilteredRoster.length / rowsPerPage);
     
           
        console.log("totalPages",totalPages);

        currentPage = Math.min(currentPage, totalPages || 1);
         console.log("currentPage",currentPage);
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        console.log("startIndex",startIndex);
        console.log("endIndex",endIndex);
        const paginatedItems = currentFilteredRoster.slice(startIndex, endIndex);
                console.log("paginatedItems",paginatedItems);

        const isLocationFilterActive = ['corporate', 'regional', 'unit', 'department'].some(k => activeEmployeeFilters[k].length > 0);
        employeeFilterBtn.classList.toggle('filter-active', isLocationFilterActive);
        employeeFilterBtn.querySelector('i').classList.toggle('active', isLocationFilterActive);
        
        const isMetricsFilterActive = Object.values(activeMetricsFilters).some(v => Array.isArray(v) ? v.length > 0 : (v.from || v.to));
        metricsFilterBtn.classList.toggle('filter-active', isMetricsFilterActive);
        metricsFilterBtn.querySelector('i').classList.toggle('active', isMetricsFilterActive);
        
        tableBody.innerHTML = '';
        
        
        paginatedItems.forEach(emp => { tableBody.innerHTML += createTableRowHTML(emp); });
        
        updateBulkActionButtons();
        updateSelectAllTableCheckboxState();
        renderPagination(currentFilteredRoster.length);
        renderFilterTags();

        if (lastOpenedDropdownKey) {
            const wrapper = document.querySelector(`.custom-select-wrapper[data-filter-key="${lastOpenedDropdownKey}"]`);
            if (wrapper) {
                wrapper.classList.add('open');
            }
            lastOpenedDropdownKey = null;
        }
    }
    

    
    
    function renderPagination(totalRows) {
        paginationFooter.innerHTML = '';
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const leftControls = document.createElement('div');
        leftControls.className = 'footer-left-controls';
        const startItem = totalRows > 0 ? (currentPage - 1) * rowsPerPage + 1 : 0;
        const endItem = Math.min(currentPage * rowsPerPage, totalRows);
        const info = document.createElement('div');
        info.className = 'pagination-info';
        info.innerHTML = `Showing <b>${startItem}</b>-<b>${endItem}</b> of <b>${totalRows}</b>`;
        leftControls.appendChild(info);
        const rowsControl = document.createElement('div');
        rowsControl.className = 'rows-per-page-controls';
        const rowsLabel = document.createElement('label');
        rowsLabel.setAttribute('for', 'rows-per-page-select');
        rowsLabel.textContent = 'Rows per page:';
        const rowsSelect = document.createElement('select');
        rowsSelect.id = 'rows-per-page-select';
        [5, 10, 25].forEach(num => {
            const option = document.createElement('option');
            option.value = num;
            option.textContent = num;
            rowsSelect.appendChild(option);
        });
        rowsSelect.value = rowsPerPage;
        rowsControl.appendChild(rowsLabel);
        rowsControl.appendChild(rowsSelect);
        leftControls.appendChild(rowsControl);
        paginationFooter.appendChild(leftControls);
        if (totalPages <= 1) return;
        const rightControls = document.createElement('div');
        rightControls.className = 'pagination-controls';
        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.id = 'prev-page';
        prevBtn.innerHTML = `<i class="fas fa-chevron-left"></i> Previous`;
        if (currentPage === 1) prevBtn.disabled = true;
        rightControls.appendChild(prevBtn);
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = 'page-btn';
            pageBtn.textContent = i;
            pageBtn.dataset.page = i;
            if (i === currentPage) { pageBtn.classList.add('active'); }
            rightControls.appendChild(pageBtn);
        }
        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.id = 'next-page';
        nextBtn.innerHTML = `Next <i class="fas fa-chevron-right"></i>`;
        if (currentPage === totalPages) nextBtn.disabled = true;
        rightControls.appendChild(nextBtn);
        paginationFooter.appendChild(rightControls);
    }
    
    function renderSelectionPreview() {
        selectionPreviewContainer.innerHTML = '';
        if (selectedForAddition.length === 0) return;
        selectedForAddition.forEach(id => {
            const employee = masterEmployeeList.find(e => e.id === id);
            if (employee) { selectionPreviewContainer.innerHTML += `<div class="selected-preview-tag">${employee.name}<span class="remove-tag-btn" data-employee-id="${id}">×</span></div>`; }
        });
    }

    function updateAddSelectionUI() {
        console.log('aaaa');
        const selectionCount = selectedForAddition.length;
        console.log('aaaa11111',selectionCount);
        bulkAddBtn.disabled = selectionCount === 0;
        bulkAddBtn.textContent = selectionCount > 0 ? `Add Selected (${selectionCount})` : 'Add Selected';
        if (selectionCount > 0) { searchActionsContainer.classList.add('visible'); renderSelectionPreview(); } else { searchActionsContainer.classList.remove('visible'); selectionPreviewContainer.innerHTML = ''; }
    }
    
    function updateBulkActionButtons() {
        console.log('bbbbbb');
        const hasSelection = selectedInTableIds.length > 0; markActiveBtn.disabled = !hasSelection; markInactiveBtn.disabled = !hasSelection;
        console.log('bbbbb11_hasSelection',hasSelection);
        
    }
    function updateSelectAllTableCheckboxState() { 
          console.log('ccccc');
        const individualRows = tableBody.querySelectorAll('tr'); if (individualRows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const visibleIdsOnPage = Array.from(individualRows).map(row => row.dataset.employeeId); const selectedOnPage = visibleIdsOnPage.filter(id => selectedInTableIds.includes(id));
        const allSelectedOnPage = visibleIdsOnPage.length > 0 && selectedOnPage.length === visibleIdsOnPage.length; selectAllTableCheckbox.checked = allSelectedOnPage; 
        selectAllTableCheckbox.indeterminate = selectedOnPage.length > 0 && !allSelectedOnPage;
        
         console.log('ccccc111111_individualRows',individualRows);
         console.log('ccccc111111_allSelectedOnPage',allSelectedOnPage);
    }
    
      bulkAddBtn.addEventListener('click', function () {
        if (selectedForAddition.length === 0) return;
        $.ajax({
            url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/trainer/add-trainer-employee', 
            method: 'POST',
            data: {
                employee_ids: selectedForAddition, 
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (response) {
                selectedForAddition = [];
                updateAddSelectionUI();
                     toastr.success("Added successfully!");
                      sessionStorage.setItem('activateTab', '#trainer');
                      window.location.reload();
            },
            error: function () {
                 toastr.error("Failed to add employees");
            }
        });
    });

    $(document).ready(function () {
        const tabToActivate = sessionStorage.getItem('activateTab');
        if (tabToActivate) {
            $('.tab-content').removeClass('active').addClass('hidden-tab');
            $('.tab-button').removeClass('active').attr('aria-selected', false);
            $('.tab-pane').removeClass('active');
            $(tabToActivate).addClass('active');
            $(`.tab-button[data-tab-target="${tabToActivate}"]`).addClass('active').attr('aria-selected', true);
            sessionStorage.removeItem('activateTab');
        }
    });


    function renderSearchResults(searchTerm = '') {

    resultsList.innerHTML = '';

    if (!searchTerm.trim()) {
        resultsList.innerHTML = '<li class="no-results">Please enter a search term.</li>';
        return;
    }

    fetch(`https://efsm.safefoodmitra.com/admin/public/index.php/training/trainer/search-employees-trainer?search=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            const filtered = data;
            if (filtered.length === 0) {
                resultsList.innerHTML = '<li class="no-results">No available employees found.</li>';
            } else {
                filtered.forEach(emp => {
                    const isSelected = selectedForAddition.includes(emp.id);
                    const li = document.createElement('li');
                    li.dataset.employeeId = emp.id;
                    li.innerHTML = `
                        <input type="checkbox" ${isSelected ? 'checked' : ''}>
                        <div class="result-info">
                            <span class="result-name">${emp.employer_fullname}</span>
                            <span class="result-details">ID: ${emp.employe_id} • Dept: ${emp.department}</span>
                        </div>`;
                    li.addEventListener('click', (e) => {
                        e.stopPropagation();
                        toggleSelection(emp.id);
                    });
                    resultsList.appendChild(li);
                });
            }

            const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId);
            selectAllCheckbox.checked = visibleIds.length > 0 && visibleIds.every(id => selectedForAddition.includes(id));
            resultsContainer.classList.add('visible');
        })
        .catch(error => {
            console.error('Search AJAX error:', error);
            resultsList.innerHTML = '<li class="no-results">Error fetching results. Try again.</li>';
        });
    }


    function toggleSelection(employeeId) {
        const index = selectedForAddition.indexOf(employeeId);
        if (index > -1) { selectedForAddition.splice(index, 1); } else { selectedForAddition.push(employeeId); }
        renderSearchResults(searchInput.value); updateAddSelectionUI();
    }
    
    function renderFilterTags() {
        filterTagsContainer.innerHTML = '';
        Object.entries(activeEmployeeFilters).forEach(([type, values]) => {
            if (!['corporate', 'regional', 'unit', 'department'].includes(type)) {
                values.forEach(value => {
                    let text = value;
                    if (type === 'employee') {
                        const emp = masterEmployeeList.find(e => e.id === value);
                        text = emp ? emp.name : value;
                    }
                    const tag = document.createElement('div');
                    tag.className = `filter-tag filter-tag-${type}`;
                    tag.innerHTML = `<span>${text}</span><span class="remove-filter-tag" data-type="${type}" data-value="${value}">&times;</span>`;
                    filterTagsContainer.appendChild(tag);
                });
            }
        });
    }
    
    // function createCustomDropdown(filterKey, label, options, targetContainer, tempFilterState, updateTriggerFn, isModal = true) {
    //     const wrapper = document.createElement('div');
    //     wrapper.className = 'custom-select-wrapper';
    //     wrapper.dataset.filterKey = filterKey;
    //     wrapper.innerHTML = `
    //         <div class="custom-select-trigger">
    //             <span class="trigger-text">${label}</span>
    //             <i class="fas fa-chevron-down"></i>
    //         </div>
    //         <div class="custom-select-options">
    //             <input type="text" class="custom-select-search" placeholder="Search...">
    //             <ul></ul>
    //         </div>
    //     `;

    //     const ul = wrapper.querySelector('ul');
    //     const filterState = isModal ? tempFilterState : activeEmployeeFilters;
    //     options.forEach(option => {
    //         const li = document.createElement('li');
    //         const isChecked = filterState[filterKey].includes(option.value);
    //         const sanitizedValue = String(option.value).replace(/[\s"'`\W]/g, '-');
    //         li.innerHTML = `
    //             <input type="checkbox" id="filter-opt-${filterKey}-${sanitizedValue}" value="${option.value}" ${isChecked ? 'checked' : ''}>
    //             <label for="filter-opt-${filterKey}-${sanitizedValue}" >${option.text}</label>
    //         `;
    //         ul.appendChild(li);
    //     });
        
    //     if (isModal) {
    //         targetContainer.innerHTML = '';
    //         targetContainer.appendChild(wrapper);
    //     } else {
    //         targetContainer.innerHTML = '';
    //         targetContainer.appendChild(wrapper);
    //     }
    //     updateTriggerFn(wrapper, label);
    // }
    
    function createCustomDropdown(filterKey, label, options, targetContainer, tempFilterStateRef, updateTriggerFn, isModal = true) {
    const wrapper = document.createElement('div');
    wrapper.className = 'custom-select-wrapper';
    wrapper.dataset.filterKey = filterKey;

    wrapper.innerHTML = `
        <div class="custom-select-trigger">
            <span class="trigger-text">${label}</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="custom-select-options">
            <input type="text" class="custom-select-search" placeholder="Search...">
            <ul></ul>
        </div>
    `;

    const ul = wrapper.querySelector('ul');
    const filterState = isModal ? tempFilterStateRef : activeEmployeeFilters;

    // Ensure filterKey array is initialized
    if (!filterState[filterKey]) {
        filterState[filterKey] = [];
    }

    options.forEach(option => {
        const sanitizedValue = String(option.value).replace(/[\s"'`\W]/g, '-');
        const isChecked = filterState[filterKey].includes(String(option.value));
        const li = document.createElement('li');

        li.innerHTML = `
            <input type="checkbox" class="filter-checkbox filter-checkbox-employee" id="filter-opt-${filterKey}-${sanitizedValue}" value="${option.value}" ${isChecked ? 'checked' : ''}>
            <label for="filter-opt-${filterKey}-${sanitizedValue}">${option.text}</label>
        `;
        ul.appendChild(li);
    });

    targetContainer.innerHTML = '';
    targetContainer.appendChild(wrapper);

    if (updateTriggerFn) {
        updateTriggerFn(wrapper, label);
    }
}




    
    function updateCustomSelectTriggerText(wrapper, defaultText) {
        if (!wrapper) return;
        const key = wrapper.dataset.filterKey;
        const triggerText = wrapper.querySelector('.trigger-text');
        const filterState = wrapper.closest('.filter-modal-body') ? tempMetricsFilters : activeEmployeeFilters;
        const selections = filterState[key];

        const selectedCount = selections.length;
        if (selectedCount === 0) {
            triggerText.textContent = defaultText;
        } else if (selectedCount === 1) {
            const val = selections[0];
            const sanitizedVal = String(val).replace(/[\s"'`\W]/g, '-');
            const selectedOption = wrapper.querySelector(`#filter-opt-${key}-${sanitizedVal}`);
            triggerText.textContent = selectedOption ? selectedOption.nextElementSibling.textContent : `1 selected`;
        } else {
            triggerText.textContent = `${selectedCount} selected`;
        }
    }
    
    function populateExternalDropdowns(source) {
        console.log("sourcesource",source);
        const createOptions = (src, key, textField = null, valueField = null) => {
            if (textField && valueField) {
                 return src.map(e => ({ value: e[valueField], text: e[textField] })).sort((a,b) => a.text.localeCompare(b.text));
            }
            return [...new Set(src.map(e => e[key]).filter(Boolean))].sort().map(item => ({value: item, text: item}));
        };

        console.log("createOptions",createOptions);
  
        const employeeOptions = createOptions(source, null, 'name', 'id');
        console.log("employeeOptions",employeeOptions);
  
        // const trainerLevelOptions = createOptions(source.filter(e => e.isTrainer), 'trainerQualification');
        // console.log("trainerLevelOptions",trainerLevelOptions);
        // const certificationOptions = [...new Set(source.flatMap(e => e.certifications.map(c => c.name)))].sort().map(item => ({ value: item, text: item }));
        // console.log("certificationOptions",certificationOptions);
        
        
        console.log("check1", createCustomDropdown('employee', 'Employee', employeeOptions, document.getElementById('employee-select-wrapper'), null, updateCustomSelectTriggerText, false));
        // console.log("check2", createCustomDropdown('trainerLevel', 'Trainer Level', trainerLevelOptions, document.getElementById('trainer-level-select-wrapper'), null, updateCustomSelectTriggerText, false));
        // console.log("check3", createCustomDropdown('certification', 'Certification', certificationOptions, document.getElementById('certification-select-wrapper'), null, updateCustomSelectTriggerText, false));
 
        createCustomDropdown('employee', 'Employee', employeeOptions, document.getElementById('employee-select-wrapper'), null, updateCustomSelectTriggerText, false);
        // createCustomDropdown('trainerLevel', 'Trainer Level', trainerLevelOptions, document.getElementById('trainer-level-select-wrapper'), null, updateCustomSelectTriggerText, false);
        // createCustomDropdown('certification', 'Certification', certificationOptions, document.getElementById('certification-select-wrapper'), null, updateCustomSelectTriggerText, false);
    }




$(document).on('change', '#employee-select-wrapper input[type="checkbox"]', function () {
    const val = $(this).val();
alert(val);
    if ($(this).is(':checked')) {
        if (!selectedEmployeeIds.includes(val)) {
            selectedEmployeeIds.push(val);
        }
    } else {
        selectedEmployeeIds = selectedEmployeeIds.filter(id => id !== val);
    }

    console.log("Selected Employees:", selectedEmployeeIds);

    // Optional: Run filter/search
    runSearchOrFilter({ employee: selectedEmployeeIds });
});



    function populateEmployeeFilterModal() {
        cascadingFilterContainer.innerHTML = '';
        const hierarchy = ['corporate', 'regional', 'unit', 'department'];
        const labels = { corporate: 'Corporates', regional: 'Regions', unit: 'Units', department: 'Departments' };
        
        let sourceData = [...masterEmployeeList];
        
        hierarchy.forEach((key, index) => {
            const parentKey = index > 0 ? hierarchy[index-1] : null;
            const selectedParents = parentKey ? tempEmployeeFilters[parentKey] : [];
            const isEnabled = !parentKey || selectedParents.length > 0;

            if (parentKey && selectedParents.length > 0) {
                sourceData = sourceData.filter(item => selectedParents.includes(item[parentKey]));
            }
            
            let options = [];
            if (isEnabled) {
                if (key === 'department') {
                    const uniqueOptions = new Map();
                    sourceData.forEach(item => {
                        if(item.department && item.unit) {
                          const uniqueKey = `${item.department}-${item.unit}`;
                          if(!uniqueOptions.has(uniqueKey)) {
                              uniqueOptions.set(uniqueKey, { value: item.department, text: `${item.department} (${item.unit})` });
                          }
                        }
                    });
                    options = [...uniqueOptions.values()].sort((a, b) => a.text.localeCompare(b.text));
                } else {
                    options = [...new Set(sourceData.map(item => item[key]).filter(Boolean))].sort().map(val => ({ value: val, text: val }));
                }
            }

            const column = document.createElement('div');
            column.className = `filter-column ${isEnabled ? '' : 'disabled'}`;
            
            const allSelected = isEnabled && options.length > 0 && options.every(opt => tempEmployeeFilters[key].includes(opt.value));

            column.innerHTML = `
                <div class="filter-column-header">
                    <input type="checkbox" id="select-all-${key}" data-key="${key}" ${allSelected ? 'checked' : ''} ${!isEnabled ? 'disabled' : ''}>
                    <label for="select-all-${key}">${labels[key]}</label>
                </div>
                <ul class="filter-column-body">
                    ${options.map(opt => `
                        <li class="filter-item">
                            <input type="checkbox" id="filter-${key}-${opt.value.replace(/[\s+&()]/g, '-')}" data-key="${key}" value="${opt.value}" ${tempEmployeeFilters[key].includes(opt.value) ? 'checked' : ''}>
                            <label for="filter-${key}-${opt.value.replace(/[\s+&()]/g, '-')}">${opt.text}</label>
                        </li>
                    `).join('')}
                </ul>
            `;
            cascadingFilterContainer.appendChild(column);
        });
    }
    
    function populateMetricsFilterModal() {
        metricsFilterBody.innerHTML = `
            <div class="metrics-filter-group">
                <label>PERFORMANCE LEVEL</label>
                <div id="performance-level-filter-container" style="grid-column: 1 / -1;"></div>
            </div>
            <div class="metrics-filter-group">
                <label>SESSIONS</label>
                <div class="metrics-range-inputs">
                    <input type="text" id="filter-sessions-from-modal" placeholder="From" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    <span>-</span>
                    <input type="text" id="filter-sessions-to-modal" placeholder="To" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>
            </div>
             <div class="metrics-filter-group">
                <label>HRS DELIVERED</label>
                <div class="metrics-range-inputs">
                    <input type="text" id="filter-hrsDelivered-from-modal" placeholder="From" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    <span>-</span>
                    <input type="text" id="filter-hrsDelivered-to-modal" placeholder="To" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>
            </div>
             <div class="metrics-filter-group">
                <label>AVERAGE DELIVERY</label>
                <div class="metrics-range-inputs">
                    <input type="text" id="filter-avgDelivery-from-modal" placeholder="From" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                    <span>-</span>
                    <input type="text" id="filter-avgDelivery-to-modal" placeholder="To" oninput="this.value=this.value.replace(/[^0-9.]/g,'')">
                </div>
            </div>
            <div class="metrics-filter-group">
                <label>DEPARTMENT REACH</label>
                <div class="metrics-range-inputs">
                    <div class="input-with-adornment"><input type="text" id="filter-deptReach-from-modal" placeholder="From" oninput="this.value=this.value.replace(/[^0-9]/g,'')"><span class="input-adornment">%</span></div>
                    <span>-</span>
                    <div class="input-with-adornment"><input type="text" id="filter-deptReach-to-modal" placeholder="To" oninput="this.value=this.value.replace(/[^0-9]/g,'')"><span class="input-adornment">%</span></div>
                </div>
            </div>
            <div class="metrics-filter-group">
                <label>SELF LEARNING</label>
                 <div class="metrics-range-inputs">
                    <input type="text" id="filter-selfLearning-from-modal" placeholder="From" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    <span>-</span>
                    <input type="text" id="filter-selfLearning-to-modal" placeholder="To" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>
            </div>
            <div class="metrics-filter-group">
                <label>LAST TRAINED</label>
                <div class="metrics-range-inputs">
                    <input type="date" id="filter-lastTrained-from-modal">
                    <span>-</span>
                    <input type="date" id="filter-lastTrained-to-modal">
                </div>
            </div>
        `;
        
        for(const key in tempMetricsFilters) {
            if (key !== 'performanceLevel') {
                document.getElementById(`filter-${key}-from-modal`).value = tempMetricsFilters[key].from || '';
                document.getElementById(`filter-${key}-to-modal`).value = tempMetricsFilters[key].to || '';
            }
        }

        const perfContainer = document.getElementById('performance-level-filter-container');
        const perfOptions = [ { value: 'High Performer', text: 'High Performer' }, { value: 'Medium Performer', text: 'Medium Performer' }, { value: 'Low Performer', text: 'Low Performer' }];
        createCustomDropdown('performanceLevel', 'Select Performance Level', perfOptions, perfContainer, tempMetricsFilters, updateCustomSelectTriggerText, true);
    }
    
    // function populateStatusFilter() {
    //     const ul = statusFilterDropdown.querySelector('ul');
    //     ul.innerHTML = '';
    //     const statuses = ['Active', 'Inactive', 'Neutral'];
    //     statuses.forEach(status => {
    //         const statusVal = status.toLowerCase();
    //         const li = document.createElement('li');
    //         li.innerHTML = `<input type="checkbox"  class="status-filter-checkbox" id="status-filter-${statusVal}" value="${statusVal}" ${activeStatusFilters.includes(statusVal) ? 'checked' : ''}><label for="status-filter-${statusVal}">${status}</label>`;
    //         ul.appendChild(li);
    //     });
    // }

    function populateStatusFilter() {
        const ul = statusFilterDropdown.querySelector('ul');
        ul.innerHTML = '';
    
        const statuses = ['Active', 'Inactive', 'Neutral'];
        const statusMapping = {
            active: 1,
            inactive: 2,
            neutral: 3
        };
    
        statuses.forEach(status => {
            const statusVal = status.toLowerCase();
            const mappedValue = statusMapping[statusVal]; 
            const li = document.createElement('li');
            li.innerHTML = `
                <input type="checkbox" class="status-filter-checkbox" id="status-filter-${statusVal}" value="${mappedValue}" ${activeStatusFilters.includes(statusVal) ? 'checked' : ''}>
                <label for="status-filter-${statusVal}">${status}</label>
            `;
            ul.appendChild(li);
        });
    }


    function setupEventListeners() {
        document.addEventListener('click', (e) => { 
            if (!e.target.closest('.search-add-wrapper')) { resultsContainer.classList.remove('visible'); }
            if (!e.target.closest('.custom-select-wrapper')) { 
                document.querySelectorAll('.custom-select-wrapper.open').forEach(w => w.classList.remove('open'));
            }
        });

        refreshTableBtn.addEventListener('click', () => {
            const icon = refreshTableBtn.querySelector('.fa-sync-alt');
            icon.classList.add('spinning');
            activeEmployeeFilters = JSON.parse(JSON.stringify(initialEmployeeFilters));
            tempEmployeeFilters = JSON.parse(JSON.stringify(initialEmployeeFilters));
            activeMetricsFilters = JSON.parse(JSON.stringify(initialMetricsFilters));
            activeStatusFilters = [];
            chartGranularity = 'monthly';
            lineGraphVisibility = { hours: true, sessions: true, avgHours: true };
            document.querySelectorAll('#chart-granularity-selector button').forEach(b => b.classList.remove('active'));
            document.querySelector('#chart-granularity-selector button[data-granularity="monthly"]').classList.add('active');
            statusFilterBtn.querySelector('i').classList.remove('active');
            currentPage = 1;
            renderTable();
            refreshToast.innerHTML = '<i class="fas fa-check-circle"></i> Table refreshed and filters cleared.';
            refreshToast.classList.add('show');
            setTimeout(() => { icon.classList.remove('spinning'); }, 500);
            setTimeout(() => { refreshToast.classList.remove('show'); }, 3000);
        });
        
        chartGranularitySelector.addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON') {
                const newGranularity = e.target.dataset.granularity;
                if (newGranularity !== chartGranularity) {
                    chartGranularity = newGranularity;
                    chartGranularitySelector.querySelector('.active').classList.remove('active');
                    e.target.classList.add('active');
                    renderTable();
                }
            }
        });

        chartLegend.addEventListener('click', (e) => {
            const legendItem = e.target.closest('.legend-item');
            if (!legendItem || !legendItem.dataset.metric) return;
            
            const metricKey = legendItem.dataset.metric;
            lineGraphVisibility[metricKey] = !lineGraphVisibility[metricKey];
            
            document.querySelectorAll(`.legend-item[data-metric="${metricKey}"]`).forEach(item => {
                item.classList.toggle('inactive');
            });

            renderLineChart();
        });

        searchInput.addEventListener('input', () => renderSearchResults(searchInput.value));
        searchInput.addEventListener('focus', () => renderSearchResults(searchInput.value));
        selectionPreviewContainer.addEventListener('click', (e) => { if(e.target.classList.contains('remove-tag-btn')) { e.stopPropagation(); toggleSelection(e.target.dataset.employeeId); } });
        selectAllCheckbox.addEventListener('change', () => { const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId); if (selectAllCheckbox.checked) { visibleIds.forEach(id => !selectedForAddition.includes(id) && selectedForAddition.push(id)); } else { selectedForAddition = selectedForAddition.filter(id => !visibleIds.includes(id)); } renderSearchResults(searchInput.value); updateAddSelectionUI(); });
        bulkAddBtn.addEventListener('click', () => { rosterEmployeeIds.push(...selectedForAddition); selectedForAddition = []; searchInput.value = ''; resultsContainer.classList.remove('visible'); updateAddSelectionUI(); currentPage = 1; renderTable(); });
        
        filterTagsContainer.addEventListener('click', e => {
            if (e.target.classList.contains('remove-filter-tag')) {
                const {type, value} = e.target.dataset;
                activeEmployeeFilters[type] = activeEmployeeFilters[type].filter(v => v !== value);
                renderTable();
            }
        });

        employeeFilterBtn.addEventListener('click', () => { tempEmployeeFilters = JSON.parse(JSON.stringify(activeEmployeeFilters)); populateEmployeeFilterModal(); employeeFilterModalOverlay.classList.add('visible'); document.body.classList.add('modal-open'); });
        closeEmployeeFilterModalBtn.addEventListener('click', () => { employeeFilterModalOverlay.classList.remove('visible'); document.body.classList.remove('modal-open'); });
        applyEmployeeFiltersBtn.addEventListener('click', () => { activeEmployeeFilters = JSON.parse(JSON.stringify(tempEmployeeFilters)); currentPage = 1; renderTable(); closeEmployeeFilterModalBtn.click(); });
        resetEmployeeFiltersBtn.addEventListener('click', () => { tempEmployeeFilters = JSON.parse(JSON.stringify(initialEmployeeFilters)); populateEmployeeFilterModal(); });
        
        cascadingFilterContainer.addEventListener('click', (e) => {
            if (e.target.tagName === 'INPUT' && e.target.type === 'checkbox') {
                const key = e.target.dataset.key;
                const hierarchy = ['corporate', 'regional', 'unit', 'department'];
                const currentKeyIndex = hierarchy.indexOf(key);

                if (e.target.id.startsWith('select-all-')) {
                    const allValues = [...e.target.closest('.filter-column').querySelectorAll('.filter-item input')].map(input => input.value);
                    if (e.target.checked) {
                        tempEmployeeFilters[key] = [...new Set([...tempEmployeeFilters[key], ...allValues])];
                    } else {
                        tempEmployeeFilters[key] = tempEmployeeFilters[key].filter(val => !allValues.includes(val));
                    }
                } else {
                    const value = e.target.value;
                    if (e.target.checked) {
                        tempEmployeeFilters[key].push(value);
                    } else {
                        tempEmployeeFilters[key] = tempEmployeeFilters[key].filter(v => v !== value);
                    }
                }
                
                for (let i = currentKeyIndex + 1; i < hierarchy.length; i++) {
                    const childKey = hierarchy[i];
                    tempEmployeeFilters[childKey] = [];
                }

                populateEmployeeFilterModal();
            }
        });

        const externalFilterWrappers = ['employee-select-wrapper', 'trainer-level-select-wrapper', 'certification-select-wrapper'];
        externalFilterWrappers.forEach(id => {
            const container = document.getElementById(id);
            container.addEventListener('click', e => {
                 const wrapper = e.target.closest('.custom-select-wrapper');
                 if (!wrapper) return;
                 const key = wrapper.dataset.filterKey;

                 if (e.target.closest('.custom-select-trigger')) {
                    const wasOpen = wrapper.classList.contains('open');
                    document.querySelectorAll('.dashboard-filter-bar .custom-select-wrapper.open').forEach(w => w.classList.remove('open'));
                    if(!wasOpen) wrapper.classList.add('open');
                 }

                 if(e.target.type === 'checkbox') {
                    lastOpenedDropdownKey = key;
                    const value = e.target.value;
                    if (e.target.checked) { activeEmployeeFilters[key].push(value); } 
                    else { activeEmployeeFilters[key] = activeEmployeeFilters[key].filter(item => item !== value); }
                    renderTable();
                 }
            });
            container.addEventListener('input', e => { if (e.target.classList.contains('custom-select-search')) { const searchTerm = e.target.value.toLowerCase(); const items = e.target.nextElementSibling.querySelectorAll('li'); items.forEach(li => { const label = li.querySelector('label').textContent.toLowerCase(); li.classList.toggle('hidden', !label.includes(searchTerm)); }); } });
        });
        
        selectAllTableCheckbox.addEventListener('change', (e) => { const isChecked = e.target.checked; const visibleRows = tableBody.querySelectorAll('tr'); visibleRows.forEach(row => { const checkbox = row.querySelector('.row-checkbox'); const employeeId = row.dataset.employeeId; checkbox.checked = isChecked; if (isChecked) { if (!selectedInTableIds.includes(employeeId)) { selectedInTableIds.push(employeeId); } } else { selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); } }); updateBulkActionButtons(); updateSelectAllTableCheckboxState(); });
        function bulkUpdateStatus(newStatus) { selectedInTableIds.forEach(id => { const employee = masterEmployeeList.find(e => e.id === id); if (employee) employee.status = newStatus; }); selectedInTableIds = []; renderTable(); }
        markActiveBtn.addEventListener('click', () => bulkUpdateStatus('active'));
        markInactiveBtn.addEventListener('click', () => bulkUpdateStatus('inactive'));
        tableBody.addEventListener('click', (e) => {
            const row = e.target.closest('tr'); if (!row) return; const employeeId = row.dataset.employeeId;
            if (e.target.classList.contains('row-checkbox')) { if (e.target.checked) { if (!selectedInTableIds.includes(employeeId)) selectedInTableIds.push(employeeId); } else { selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); } updateBulkActionButtons(); updateSelectAllTableCheckboxState(); }
            else if (e.target.closest('.status-indicator')) { const indicator = e.target.closest('.status-indicator'); const currentStatus = indicator.dataset.status; const currentIndex = statusCycle.indexOf(currentStatus); const newStatus = statusCycle[(currentIndex + 1) % statusCycle.length]; const employee = masterEmployeeList.find(emp => emp.id === employeeId); if (employee) employee.status = newStatus; renderTable(); }
            else if (e.target.closest('.fa-trash-alt')) { const employeeName = row.querySelector('.name').textContent.trim(); if (confirm(`Are you sure you want to remove ${employeeName} from the roster?`)) { rosterEmployeeIds = rosterEmployeeIds.filter(id => id !== employeeId); selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); renderTable(); } }
        });
        
        paginationFooter.addEventListener('change', (e) => { if (e.target.id === 'rows-per-page-select') { rowsPerPage = parseInt(e.target.value, 10); currentPage = 1; renderTable(); } });
        paginationFooter.addEventListener('click', (e) => { const btn = e.target.closest('.page-btn'); if (btn && !btn.disabled) { if (btn.id === 'prev-page') { currentPage--; } else if (btn.id === 'next-page') { currentPage++; } else if (btn.dataset.page) { currentPage = parseInt(btn.dataset.page, 10); } renderTable(); } });

        metricsFilterBtn.addEventListener('click', () => { tempMetricsFilters = JSON.parse(JSON.stringify(activeMetricsFilters)); populateMetricsFilterModal(); metricsFilterModalOverlay.classList.add('visible'); document.body.classList.add('modal-open'); });
        closeMetricsFilterModalBtn.addEventListener('click', () => { metricsFilterModalOverlay.classList.remove('visible'); document.body.classList.remove('modal-open'); });
        applyMetricsFilterBtn.addEventListener('click', () => {
            for(const key in tempMetricsFilters) {
                if(key !== 'performanceLevel') {
                    tempMetricsFilters[key].from = document.getElementById(`filter-${key}-from-modal`).value;
                    tempMetricsFilters[key].to = document.getElementById(`filter-${key}-to-modal`).value;
                }
            }
            activeMetricsFilters = JSON.parse(JSON.stringify(tempMetricsFilters));
            currentPage = 1; 
            renderTable();
            closeMetricsFilterModalBtn.click();
        });
        resetMetricsFilterBtn.addEventListener('click', () => { 
            tempMetricsFilters = JSON.parse(JSON.stringify(initialMetricsFilters)); 
            populateMetricsFilterModal();
        });
        metricsFilterBody.addEventListener('click', e => { const wrapper = e.target.closest('.custom-select-wrapper'); if (!wrapper) return; if (e.target.closest('.custom-select-trigger')) { wrapper.classList.toggle('open'); } if (e.target.type === 'checkbox') { const key = wrapper.dataset.filterKey; const value = e.target.value; if (e.target.checked) tempMetricsFilters[key].push(value); else tempMetricsFilters[key] = tempMetricsFilters[key].filter(item => item !== value); updateCustomSelectTriggerText(wrapper, 'Select Performance Level');  } });
        
        statusFilterBtn.addEventListener('click', (e) => { 
            e.stopPropagation();
            const wrapper = e.target.closest('.custom-select-wrapper');
            lastOpenedDropdownKey = 'status';
            const wasOpen = wrapper.classList.contains('open');
            document.querySelectorAll('.dashboard-filter-bar .custom-select-wrapper.open').forEach(w => w.classList.remove('open'));
            if(!wasOpen) wrapper.classList.add('open');
        });
        statusFilterDropdown.addEventListener('input', e => { if(e.target.classList.contains('custom-select-search')) { const searchTerm = e.target.value.toLowerCase(); const items = statusFilterDropdown.querySelectorAll('li'); items.forEach(li => { const label = li.querySelector('label').textContent.toLowerCase(); li.classList.toggle('hidden', !label.includes(searchTerm)); }); } });
        statusFilterDropdown.addEventListener('change', e => { if (e.target.type === 'checkbox') { lastOpenedDropdownKey = 'status'; const value = e.target.value; if (e.target.checked) { activeStatusFilters.push(value); } else { activeStatusFilters = activeStatusFilters.filter(status => status !== value); } statusFilterBtn.querySelector('i').classList.toggle('active', activeStatusFilters.length > 0); currentPage = 1; renderTable(); } });

        downloadChartPngBtn.addEventListener('click', () => {
            html2canvas(document.querySelector("#chart-container"), {
                backgroundColor: null,
                scale: 2
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'chart-export.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        });

        downloadChartPdfBtn.addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const chartElement = document.querySelector("#chart-container");

            html2canvas(chartElement, {
                backgroundColor: null,
                scale: 2
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'pt',
                    format: 'a4'
                });
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                const imgX = (pdfWidth - imgWidth * ratio) / 2;
                const imgY = 30;
                
                pdf.addImage(imgData, 'PNG', imgX, imgY, imgWidth * ratio, imgHeight * ratio);
                pdf.save('chart-export.pdf');
            });
        });

        downloadExcelBtn.addEventListener('click', () => {
            const dataToExport = currentFilteredRoster.map(e => ({ "Employee ID": e.id, "Name": e.name, "Corporate": e.corporate, "Regional": e.regional, "Unit": e.unit, "Department": e.department, "Role": e.role, "Status": e.status, "Is Trainer": e.isTrainer ? "Yes" : "No", "Trainer Rating": e.isTrainer ? (e.rating || 0).toFixed(1) : "N/A", "Performance Level": e.isTrainer ? e.performanceLevel : "N/A", "Sessions Delivered": e.isTrainer ? e.delivered_uniqueCourses : "N/A", "Hours Delivered": e.isTrainer ? e.delivered_hours : "N/A", "Self-Learning Hours": e.trainingTotalHours }));
            const worksheet = XLSX.utils.json_to_sheet(dataToExport);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Employees");
            XLSX.writeFile(workbook, `Employee_Roster_Export_${new Date().toISOString().slice(0,10)}.xlsx`);
        });
    }

    function init() {
        rosterEmployeeIds = masterEmployeeList.map(e => e.id);
        masterEmployeeList.forEach(emp => { emp.status = 'active'; });
        
        const statusDropdownContainer = statusFilterBtn.parentElement;
        statusDropdownContainer.classList.add('custom-select-wrapper');
        statusDropdownContainer.dataset.filterKey = 'status';
        statusDropdownContainer.replaceChild(statusFilterDropdown, statusFilterBtn.nextSibling);
        
        setupEventListeners();
        populateStatusFilter();
        renderTable(); 
        updateAddSelectionUI();
    }
    
    init();
});
</script>
