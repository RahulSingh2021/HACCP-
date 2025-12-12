 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('#training_topic').on('change', function () {
            var sopId = $(this).val();
            if (sopId) {
                $.ajax({
                    url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/get-sub-sop-by-sop',
                    type: 'GET',
                    data: { sop_id: sopId },
                    success: function (response) {
                        var options = '<option value="">Select Sub-Topic</option>';
                        
                        $.each(response, function (key, subSop) {
                            options += '<option value="' + subSop.id + '">' + subSop.name + '</option>';
                        });
                        
                        $('#sub_topic').html(options);
                    },
                    error: function () {
                        alert('Something went wrong!');
                    }
                });
            } else {
                $('#sub_topic').html('<option value="">Select Sub-Topic</option>');
            }
        });
        
        
     $(document).ready(function () {
        $('#trainerScopeSelectDropdown').on('change', function () {
            let selectedScope = $(this).val();
            if (selectedScope !== "") {
                $.ajax({
                    url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/get-dynamic-employee-training-scope?scope=' + selectedScope,
                    method: 'GET',
                    success: function (response) {
                        console.log('response_ee', response);
                        $('#trainer_name_scope').empty().append('<option disabled selected>--Select--</option>');
                        if (response.status === 'success' && Array.isArray(response.data)) {
                            response.data.forEach(function (item, index) {
                                console.log('Processing item:', item);
                                const emp = item.employee_info;
                                if (emp && emp.employe_id && emp.employer_fullname) {
                                    $('#trainer_name_scope').append(
                                        $('<option>', {
                                            value: emp.employer_fullname,
                                            text: `${emp.employer_fullname}`
                                        })
                                    );
                                }
                            });
                        } else {
                            $('#trainer_name_scope').append('<option disabled>No employees found</option>');
                        }
                    },
                    error: function (xhr) {
                        console.error('AJAX error:', xhr.responseText);
                        // alert("Something went wrong!");
                    }
                });
            }
        });
    });
    
    
            $(document).ready(function () {

 $('#employee-search-input').on('keyup', function(e) {
         e.preventDefault();

        const query = $(this).val().trim();
        // alert("Searching for: " + query);

        if (query.length > 2) {
            $.ajax({
                url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/search-employee',
                type: 'GET',
                data: { query: query },
           success: function (response) {
                let results = response;
                let ul = document.getElementById('employee-search-results');
                ul.innerHTML = ''; // clear old
                results.forEach(employee => {
                    console.log("employee",employee);
                    console.log("employeeid",employee.id);
                    ul.innerHTML += `<li class="list-group-item">
                        <input type="checkbox" class="employee-checkbox" value="${employee.id}">
                        ${employee.employer_fullname} (${employee.email})
                    </li>`;
                     console.log("ul.innerHTML", ul.innerHTML);
                });
                console.log("ul",ul);
                $('#search-results-container1').empty().append(ul.innerHTML);
                // $('#search-results-container1').append(ul);
            },
            error: function () {
                $('#employee-search-results').html('<li class="list-group-item text-danger">Error loading results</li>');
                $('#search-results-container1').show();
            }
            });
        } else {
            $('#search-results-container1').hide();
        }
    });
 });
    
   
   
    $(document).on('change', '#select-all-employees', function () {
    const checked = $(this).is(':checked');
    $('.employee-checkbox').prop('checked', checked);
    toggleAddButton(); // update add button state
});


    $(document).ready(function () {
        let allTrainers = [];
        // Fetch trainers dynamically on scope change
        $('#trainerScopeSelect').on('change', function () {
            let selectedScope = $(this).val();

            if (selectedScope !== "") {
                $('#trainer_name').html('<option disabled selected>Loading...</option>').trigger('change');

                $.ajax({
                    url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/get-dynamic-employee-training-scope?scope=' + selectedScope,
                    method: 'GET',
                    success: function (response) {
                        allTrainers = [];

                        $('#trainer_name').empty().append('<option></option>'); // Clear & keep placeholder

                        if (response.status === 'success' && Array.isArray(response.data)) {
                            response.data.forEach(function (item) {
                                const emp = item.employee_info;
                                if (emp && emp.employe_id && emp.employer_fullname) {
                                    allTrainers.push({
                                        id: emp.employe_id,
                                        text: emp.employer_fullname
                                    });

                                    // Add each option
                                    $('#trainer_name').append(
                                        $('<option>', {
                                            value: emp.employe_id,
                                            text: emp.employer_fullname
                                        })
                                    );
                                }
                            });
                        } else {
                            alert("No trainers found for selected scope.");
                        }

                        $('#trainer_name').trigger('change'); // Refresh Select2
                    },
                    error: function (xhr) {
                        console.error('AJAX error:', xhr.responseText);
                        alert("Something went wrong!");
                    }
                });
            }
        });
        
        
         $('#trainer_name').select2({
        placeholder: "--Select Trainer--",
        allowClear: true,
        width: '100%' // Required to prevent layout issues
    });
    });






        $(document).on('hidden.bs.modal', '.modal', function () {
            $(this).find('.modal-dialog').removeAttr('style');
        });

    
    
    
        $('#training_topic1').on('change', function () {
            var sopId = $(this).val();
            if (sopId) {
                $.ajax({
                    url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/get-sub-sop-by-sop',
                    type: 'GET',
                    data: { sop_id: sopId },
                    success: function (response) {
                        var options = '<option value="">Select Sub-Topic</option>';
                        
                        $.each(response, function (key, subSop) {
                            options += '<option value="' + subSop.id + '">' + subSop.name + '</option>';
                        });
                        $('#sub_topic1').html(options);
                    },
                    error: function () {
                        alert('Something went wrong!');
                    }
                });
            } else {
                $('#sub_topic1').html('<option value="">Select Sub-Topic</option>');
            }
        });
    
        $(document).on('click', '.delete-training', function (e) {
        e.preventDefault();

        let btn = $(this);
        let trainingId = btn.data('id');

            $.ajax({
                url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/delete/' + trainingId,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                     toastr.success("Deleted successfully!");
                   sessionStorage.setItem('activateTab', '#calendar');
                      window.location.reload();
                },
                error: function (xhr) {
                    alert('Delete failed. Please try again.');
                }
            });
 
    });
    
        $(document).ready(function() {
    $('#addTrainingForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                  toastr.success('Training saved successfully!');
                $('#addTrainingModal').modal('hide');
                form[0].reset();
                 sessionStorage.setItem('activateTab', '#calendar');
                      window.location.reload();

            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMsg = '';
                    $.each(errors, function(key, val) {
                        errorMsg += `${val[0]}\n`;
                    });
                      toastr.error(errorMsg);
                } else {
                      toastr.error('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save Training');
            }
        });
    });
});
    
        $(document).on('click', '.openEditModal', function(e) {
    e.preventDefault();

    // Get the modal form
    let form = $('#editTrainingModal form');

    // Fill form fields
    $('#training_topic1').val($(this).data('topic')).trigger('change');
    $('#sub_topic1').val($(this).data('sub-topic'));
    $('#courseModeSelect').val($(this).data('course-mode'));
    $('[name="remark"]').val($(this).data('remark'));
    $('#trainerScopeSelect').val($(this).data('trainer-scope'));
    $('#trainer_name').val($(this).data('trainer-name'));
    $('#startTimeInput').val($(this).data('start-time'));
    $('#endTimeInput').val($(this).data('end-time'));
    $('[name="location"]').val($(this).data('location'));
    $('[name="description"]').val($(this).data('description'));

    // Update form action for editing
    let trainingId = $(this).data('id');
    form.attr('action', '/training/calendar/update/' + trainingId);

    // Open the modal
    $('#editTrainingModal').modal('show');
});

        $(document).on('submit', '#editTrainingForm', function (e) {
    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');
    var formData = form.serialize();

    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                sessionStorage.setItem('activateTab', '#calendar');
                window.location.reload();
            } else {
                toastr.error('Failed to update training');
            }
        },
        error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function (key, value) {
                    toastr.error(value[0]);
                });
            } else {
                toastr.error('Something went wrong. Please try again.');
            }
        }
    });
});

        $(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();

    if (!confirm('Are you sure you want to delete this item?')) {
        return;
    }

    let url = $(this).data('url');

    $.ajax({
        url: url,
        type: 'GET',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            toastr.success('Deleted successfully!');
            sessionStorage.setItem('activateTab', '#calendar');
            window.location.reload();
        },
        error: function (xhr) {
             toastr.error('Something went wrong. Try again!');
        }
    });
});

    
    
    
    
    



$(document).on('change', '.employee-checkbox', function () {
    const allChecked = $('.employee-checkbox').length === $('.employee-checkbox:checked').length;
    $('#select-all-employees').prop('checked', allChecked);
    toggleAddButton();
});

function toggleAddButton() {
    const anyChecked = $('.employee-checkbox:checked').length > 0;
    $('#add-selected-employees').prop('disabled', !anyChecked);
}


$(document).on('click', '#add-selected-employees', function () {
    const selectedIds = $('.employee-checkbox:checked').map(function () {
        return $(this).val();
    }).get();
    
    const save_id = $('#save_id').val();

    console.log("Selected Employee IDs:", selectedIds);

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
    
    
    </script>
    
      <!-- JavaScript for Participant Management Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let masterEmployeeList = [ { id: '151-002246', name: 'Ganesh Yadav', initials: 'GY', corporate: 'Global Tech Inc.', regional: 'North America', unit: 'Innovation Hub', gender: 'Male', email: 'e@gmail.com', phone: '982749832', department: 'Food Production', role: 'Top Management', category: 'Apprentice', foodHandler: 'Yes', joined: '2023-07-01', born: '1970-01-01' }, { id: '151-001122', name: 'Jatan Singh', initials: 'JS', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'jatan.s@example.com', phone: '9876543220', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-03-01', born: '1999-01-01' }, { id: '151-005767', name: 'Prateek Jain', initials: 'PJ', corporate: 'Global Hotels Inc.', regional: 'North America', unit: 'New York Central', gender: 'Male', email: 'prateek.j@example.com', phone: '9876543210', department: 'Engineering', role: 'Engineer', category: 'Executive', foodHandler: 'No', joined: '2022-12-15', born: '1988-03-10' }, { id: '151-008912', name: 'Priya Sharma', initials: 'PS', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Paris Charm', gender: 'Female', email: 'priya.s@example.com', phone: '9876543211', department: 'Front Office', role: 'Manager', category: 'Executive', foodHandler: 'No', joined: '2023-02-20', born: '1995-11-25' }, { id: '151-003456', name: 'Rohan Mehra', initials: 'RM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'rohan.m@example.com', phone: '9876543212', department: 'F&B Service', role: 'Captain', category: 'Staff', foodHandler: 'Yes', joined: '2021-08-01', born: '1992-07-14' }, { id: '151-009123', name: 'Anjali Verma', initials: 'AV', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Rome Boutique', gender: 'Female', email: 'anjali.v@example.com', phone: '9876543213', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-01-05', born: '1998-01-30' }, { id: '151-007788', name: 'Siddhi Mehta', initials: 'SM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Corporate HQ', gender: 'Female', email: 'siddhi@example.com', phone: '9876543214', department: 'Sales', role: 'Asst Manager', category: 'Executive', foodHandler: 'No', joined: '2020-05-18', born: '1990-09-03' }, ];
            let trainingParticipantData = { '489': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present' } }, '490': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'absent', '151-007788': 'absent', '151-001122': 'absent' } }, '492': { roster: Array(26).fill(0).map((_,i) => masterEmployeeList[i % masterEmployeeList.length].id), statuses: {'151-001122': 'absent'} } };
            const allDepartments = ["Food Production", "Engineering", "Sales", "Front Office", "Housekeeping", "F&B Service", "HR", "Kitchen"];
            const allRoles = ["Top Management", "Associate", "Engineer", "Manager", "Captain", "Supervisor", "Asst Manager", "Commis Chef", "Technician"];
            
            const orgData = {
                "Global Tech Inc.": {
                    "North America": {
                        "Innovation Hub": ["Food Production", "Engineering", "Sales"],
                        "New York Central": ["Front Office", "Engineering", "Sales"]
                    }
                },
                "Global Hotels Inc.": {
                    "Asia-Pacific": {
                        "Mumbai Grand": ["Housekeeping", "F&B Service", "Engineering", "Front Office"],
                        "Corporate HQ": ["Sales", "HR"]
                    }
                },
                "Boutique Stays LLC": {
                    "Europe": {
                        "Paris Charm": ["Front Office", "Housekeeping"],
                        "Rome Boutique": ["Housekeeping"]
                    }
                }
            };


            let currentTrainingId = null; let rosterEmployeeIds = []; let selectedForAddition = []; let selectedInTableIds = [];
            const tableBody = document.getElementById('employee-table-body'); const selectAllTableCheckbox = document.getElementById('select-all-table-checkbox'); const markPresentBtn = document.getElementById('mark-present-btn'); const markAbsentBtn = document.getElementById('mark-absent-btn'); const mainSubmitBtn = document.getElementById('main-submit-btn');
            const manageParticipantsModalBody = document.querySelector('.manage-participants-modal-body'); const rosterCountsEl = document.getElementById('roster-counts');
            
            const searchInput = document.getElementById('employee-search-input1');
            // alert(searchInput);
            const resultsContainer = document.getElementById('search-results-container');
            const resultsList = document.getElementById('search-results-list');
            const selectionPreviewContainer = document.getElementById('selected-for-addition-preview');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const bulkAddBtn = document.getElementById('bulk-add-btn');
            let currentSearchResults = [];
            
            // Add/Edit Employee Modal elements
            const addNewEmployeeBtn = document.getElementById('add-new-employee-btn');
            const addEmployeeModal = document.getElementById('add-employee-modal');
            const addEmployeeFormContainer = document.getElementById('add-employee-form-container');
            const addEmployeeForm = document.getElementById('add-employee-form');
            const modalCloseBtn = addEmployeeFormContainer.querySelector('.close-btn');
            const modalCancelBtn = document.getElementById('modal-cancel-btn');


            function jaroWinkler(s1, s2) { let m = 0; if (s1.length === 0 || s2.length === 0) return 0; if (s1 === s2) return 1; let range = Math.floor(Math.max(s1.length, s2.length) / 2) - 1, s1Matches = new Array(s1.length), s2Matches = new Array(s2.length); for (let i = 0; i < s1.length; i++) { let low = (i >= range) ? i - range : 0, high = (i + range <= s2.length - 1) ? i + range : s2.length - 1; for (let j = low; j <= high; j++) { if (!s2Matches[j] && s1[i] === s2[j]) { s1Matches[i] = true; s2Matches[j] = true; m++; break; } } } if (m === 0) return 0; let k = 0, t = 0; for (let i = 0; i < s1.length; i++) { if (s1Matches[i]) { while (!s2Matches[k]) k++; if (s1[i] !== s2[k]) t++; k++; } } t /= 2; let jaro = ((m / s1.length) + (m / s2.length) + ((m - t) / m)) / 3; let p = 0.1, l = 0; if (jaro > 0.7) { while (s1[l] === s2[l] && l < 4) l++; jaro = jaro + l * p * (1 - jaro); } return jaro; }

            function updateSearchUI() {
                selectionPreviewContainer.innerHTML = selectedForAddition.map(id => {
                    const emp = masterEmployeeList.find(e => e.id === id);
                    if (!emp) return '';
                    return `<span class="selected-preview-tag">${emp.name}<span class="remove-tag-btn" data-id="${id}" title="Remove">&times;</span></span>`;
                }).join('');
                bulkAddBtn.disabled = selectedForAddition.length === 0;
                bulkAddBtn.textContent = `Add Selected (${selectedForAddition.length})`;
                resultsList.innerHTML = currentSearchResults.map(emp => {
                    const isSelected = selectedForAddition.includes(emp.id);
                    return `<li data-id="${emp.id}">
                                <input type="checkbox" class="result-checkbox" data-id="${emp.id}" ${isSelected ? 'checked' : ''}>
                                <div class="w-100">
                                    <span class="result-name">${emp.name}</span>
                                    <span class="result-details">ID: ${emp.id} &bull; Dept: ${emp.department || 'N/A'}</span>
                                </div>
                            </li>`;
                }).join('');
                if (currentSearchResults.length > 0) {
                    const allVisibleSelected = currentSearchResults.every(emp => selectedForAddition.includes(emp.id));
                    selectAllCheckbox.checked = allVisibleSelected;
                } else {
                    selectAllCheckbox.checked = false;
                }
            }
            
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                if (searchTerm.length > 0) {
                    currentSearchResults = masterEmployeeList.filter(emp =>
                        !rosterEmployeeIds.includes(emp.id) &&
                        (emp.name.toLowerCase().includes(searchTerm) || emp.id.toLowerCase().includes(searchTerm))
                    );
                    if (currentSearchResults.length === 0) {
                        resultsList.innerHTML = `<li class="no-results">No employees found.</li>`;
                    }
                } else {
                    currentSearchResults = [];
                    resultsList.innerHTML = `<li class="no-results">Type to search for employees.</li>`;
                }
                updateSearchUI();
            }
            
            if (searchInput) {
                searchInput.addEventListener('input', performSearch);
                searchInput.addEventListener('focus', () => {
                    resultsContainer.classList.add('visible');
                    performSearch();
                });
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.search-add-wrapper')) {
                        resultsContainer.classList.remove('visible');
                    }
                });
                resultsContainer.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const empId = e.target.closest('li[data-id]')?.dataset.id;
                    if (empId) {
                        if (selectedForAddition.includes(empId)) {
                            selectedForAddition = selectedForAddition.filter(id => id !== empId);
                        } else {
                            selectedForAddition.push(empId);
                        }
                        updateSearchUI();
                    }
                    if(e.target.matches('.remove-tag-btn')){
                        const empIdToRemove = e.target.dataset.id;
                        selectedForAddition = selectedForAddition.filter(id => id !== empIdToRemove);
                        updateSearchUI();
                    }
                });
                 selectAllCheckbox.addEventListener('change', () => {
                    const visibleIds = currentSearchResults.map(emp => emp.id);
                    if (selectAllCheckbox.checked) {
                        visibleIds.forEach(id => {
                            if (!selectedForAddition.includes(id)) {
                                selectedForAddition.push(id);
                            }
                        });
                    } else {
                        selectedForAddition = selectedForAddition.filter(id => !visibleIds.includes(id));
                    }
                    updateSearchUI();
                });
                bulkAddBtn.addEventListener('click', () => {
                    selectedForAddition.forEach(id => {
                        if (!rosterEmployeeIds.includes(id)) {
                            rosterEmployeeIds.push(id);
                             if(trainingParticipantData[currentTrainingId]) {
                                trainingParticipantData[currentTrainingId].statuses[id] = 'neutral';
                            }
                        }
                    });
                    selectedForAddition = [];
                    searchInput.value = '';
                    resultsContainer.classList.remove('visible');
                    renderTable();
                });
            }

            function updateRosterCounts() { let present = 0, absent = 0, neutral = 0; rosterEmployeeIds.forEach(id => { const data = trainingParticipantData[currentTrainingId]; if (data && data.statuses) { switch (data.statuses[id]) { case 'present': present++; break; case 'absent': absent++; break; default: neutral++; } } }); rosterCountsEl.innerHTML = `<span class="badge bg-success">Present: ${present}</span><span class="badge bg-danger">Absent: ${absent}</span><span class="badge bg-secondary">Neutral: ${neutral}</span>`; }
            
            function renderTable() {
                if (!tableBody) return;
                const thead = document.querySelector('.table-wrapper thead');
                if (thead) thead.style.display = 'none';
                const currentData = trainingParticipantData[currentTrainingId];
                const sortedRoster = rosterEmployeeIds
                    .map(id => {
                        const emp = masterEmployeeList.find(e => e.id === id);
                        if (emp) {
                            return { ...emp, status: (currentData && currentData.statuses[id]) ? currentData.statuses[id] : 'neutral' };
                        }
                        return null;
                    })
                    .filter(Boolean)
                    .sort((a, b) => a.name.localeCompare(b.name));

                tableBody.innerHTML = sortedRoster.map(emp => {
                    if (!emp.updated) {
                       emp.updated = new Date(Date.now() - Math.random() * 1e10).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
                    }
                    const isSelected = selectedInTableIds.includes(emp.id);
                    const statusSliderHTML = `<div class="status-slider-container status-${emp.status || 'neutral'}" data-employee-id="${emp.id}"><div class="status-slider-track"><div class="status-slider-label" data-value="absent">Absent</div><div class="status-slider-label" data-value="neutral">Neutral</div><div class="status-slider-label" data-value="present">Present</div><div class="status-slider-thumb"></div></div></div>`;
                    const prefix = emp.gender === 'Male' ? 'Mr.' : 'Ms.';
                    const displayName = `${prefix} ${emp.name}`;
                    
                    return `
                    <tr class="employee-card-list-item" data-employee-id="${emp.id}">
                        <td class="p-0">
                            <div class="employee-card-row">
                                <div class="card-col-select">
                                    <input type="checkbox" class="row-checkbox" ${isSelected ? 'checked' : ''}>
                                </div>

                                <div class="card-col-org">
                                    <strong>${emp.corporate || 'N/A'}</strong>
                                    <span>${emp.regional || 'N/A'}</span>
                                    <span>${emp.unit || 'N/A'}</span>
                                </div>

                                <div class="card-col-main-info">
                                    <div class="avatar">${emp.initials}</div>
                                    <div>
                                        <strong>${displayName}</strong>
                                        <div class="details-grid">
                                            <span><i class="fas fa-id-card-clip"></i>ID: ${emp.id}</span>
                                            <span><i class="fas fa-user"></i>${emp.gender}</span>
                                            <span><i class="fas fa-birthday-cake"></i>Born: ${emp.born}</span>
                                            <span><i class="fas fa-calendar-alt"></i>Joined: ${emp.joined}</span>
                                            <span><i class="fas fa-clock"></i>Updated: ${emp.updated}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-col-contact">
                                    <span><i class="fas fa-envelope"></i>${emp.email}</span>
                                    <span><i class="fas fa-phone"></i>${emp.phone}</span>
                                </div>

                                <div class="card-col-role">
                                    <strong>${emp.department || 'N/A'}</strong>
                                    <span>${emp.role || 'N/A'}</span>
                                    <span>Responsibility: ${emp.department || 'N/A'}</span>
                                </div>

                                <div class="card-col-category">
                                    <strong>${emp.category || 'N/A'}</strong>
                                    <span>Food Handler: ${emp.foodHandler}</span>
                                </div>
                                
                                <div class="card-col-status">
                                     ${statusSliderHTML}
                                </div>

                                <div class="card-col-actions">
                                    <i class="fas fa-trash-alt icon" title="Remove from Roster"></i>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                }).join('');

                updateBulkActionButtons();
                updateSelectAllTableCheckboxState();
                updateRosterCounts();
            }

            function updateBulkActionButtons() { const hasSelection = selectedInTableIds.length > 0; markPresentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; markAbsentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; }
            function updateSelectAllTableCheckboxState() { if(!selectAllTableCheckbox || !tableBody) return; const rows = tableBody.querySelectorAll('tr'); if (rows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const allSelected = rows.length > 0 && rows.length === selectedInTableIds.length; selectAllTableCheckbox.checked = allSelected; selectAllTableCheckbox.indeterminate = selectedInTableIds.length > 0 && !allSelected; }
            function bulkUpdateStatus(newStatus) { selectedInTableIds.forEach(id => { trainingParticipantData[currentTrainingId].statuses[id] = newStatus; }); selectedInTableIds = []; renderTable(); }
            
            const manageParticipantsModalEl = document.getElementById('manageParticipantsModal');
            manageParticipantsModalEl.addEventListener('show.bs.modal', function(event) { currentTrainingId = event.relatedTarget.dataset.trainingId; if (!trainingParticipantData[currentTrainingId]) { trainingParticipantData[currentTrainingId] = { roster: [], statuses: {} }; } rosterEmployeeIds = [...trainingParticipantData[currentTrainingId].roster]; selectedInTableIds = []; selectedForAddition = []; renderTable(); });
            if(tableBody) tableBody.addEventListener('click', (e) => { const row = e.target.closest('tr[data-employee-id]'); if (!row) return; const employeeId = row.dataset.employeeId; if (e.target.classList.contains('row-checkbox')) { if (e.target.checked) { if (!selectedInTableIds.includes(employeeId)) selectedInTableIds.push(employeeId); } else { selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); } updateBulkActionButtons(); updateSelectAllTableCheckboxState(); } else if (e.target.closest('.fa-trash-alt')) { if (confirm(`Remove ${row.querySelector('.card-col-main-info strong').textContent.trim()} from this training?`)) { rosterEmployeeIds = rosterEmployeeIds.filter(id => id !== employeeId); delete trainingParticipantData[currentTrainingId].statuses[employeeId]; selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); renderTable(); } } const sliderLabel = e.target.closest('.status-slider-label'); if (sliderLabel) { const newStatus = sliderLabel.dataset.value; if (trainingParticipantData[currentTrainingId].statuses[employeeId] !== newStatus) { trainingParticipantData[currentTrainingId].statuses[employeeId] = newStatus; const sliderContainer = sliderLabel.closest('.status-slider-container'); sliderContainer.className = 'status-slider-container'; sliderContainer.classList.add(`status-${newStatus}`); updateRosterCounts(); } } });
            if(markPresentBtn) markPresentBtn.addEventListener('click', () => bulkUpdateStatus('present'));
            if(markAbsentBtn) markAbsentBtn.addEventListener('click', () => bulkUpdateStatus('absent'));
            if(mainSubmitBtn) mainSubmitBtn.addEventListener('click', () => { if (!currentTrainingId) return; trainingParticipantData[currentTrainingId].roster = rosterEmployeeIds; let presentCount = 0, absentCount = 0; Object.values(trainingParticipantData[currentTrainingId].statuses).forEach(status => { if (status === 'present') presentCount++; if (status === 'absent') absentCount++; }); const mainTableRow = document.querySelector(`button[data-training-id="${currentTrainingId}"]`)?.closest('tr'); if(mainTableRow) { mainTableRow.querySelector('.badge.bg-success').textContent = presentCount; mainTableRow.querySelector('.badge.bg-danger').textContent = absentCount; } window.tableManager.updateDashboardMetrics(); bootstrap.Modal.getInstance(manageParticipantsModalEl).hide(); });

            // File Upload and Review Logic 
            const uploadFileBtn = document.getElementById('upload-file-btn'); const uploadFileModalEl = document.getElementById('uploadFileModal'); const uploadFileModal = new bootstrap.Modal(uploadFileModalEl, { keyboard: false }); const fileUploadStep = document.getElementById('upload-file-step'); const pdfLoadingStep = document.getElementById('pdf-loading-step'); const pdfReviewStep = document.getElementById('pdf-review-step'); const fileUploadInput = document.getElementById('file-upload-input'); const handwritingOptionWrapper = document.getElementById('handwriting-option-wrapper'); const detectHandwritingCheckbox = document.getElementById('detect-handwriting-checkbox'); const extractTableBtn = document.getElementById('extract-table-btn'); const pdfBackBtn = document.getElementById('pdf-back-btn'); const importParticipantsBtn = document.getElementById('import-participants-btn'); const loadingText = document.getElementById('loading-text'); const mapIdSelect = document.getElementById('map-id-select'); const mapNameSelect = document.getElementById('map-name-select'); const mapDepartmentSelect = document.getElementById('map-department-select'); const reviewThead = document.getElementById('pdf-review-thead'); const reviewTbody = document.getElementById('reviewed-participants-tbody'); const downloadSampleCsvBtn = document.getElementById('download-sample-csv-btn'); let simulatedExtractedData = [];
            
            function triggerCsvDownload(csvString, filename) {
                const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                if (link.download !== undefined) {
                    const url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', filename);
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                }
            }

            if (downloadSampleCsvBtn) {
                downloadSampleCsvBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const csvHeaders = ['Sr. No', 'Participant Name', 'Department', 'Designation'];
                    const csvRows = [
                        ['151-001234', 'Amit Kumar', 'Housekeeping', 'Associate'],
                        ['151-005678', 'Sunita Sharma', 'F&B Service', 'Captain'],
                        ['151-009012', 'Rajesh Patel', 'Engineering', 'Technician']
                    ];
                    const csvContent = [
                        csvHeaders.join(','),
                        ...csvRows.map(row => row.join(','))
                    ].join('\n');
                    triggerCsvDownload(csvContent, 'sample_participants.csv');
                });
            }

            function showFileUploadStep(step) { fileUploadStep.style.display = 'none'; pdfLoadingStep.style.display = 'none'; pdfReviewStep.style.display = 'none'; if (step === 'upload') fileUploadStep.style.display = 'block'; if (step === 'loading') pdfLoadingStep.style.display = 'block'; if (step === 'review') pdfReviewStep.style.display = 'block'; }
            uploadFileModalEl.addEventListener('hidden.bs.modal', () => { showFileUploadStep('upload'); fileUploadInput.value = ''; handwritingOptionWrapper.style.display = 'none'; detectHandwritingCheckbox.checked = false; if(extractTableBtn) extractTableBtn.disabled = true; });
            if (uploadFileBtn) { uploadFileBtn.addEventListener('click', () => { showFileUploadStep('upload'); uploadFileModal.show(); }); }
            if (fileUploadInput) { fileUploadInput.addEventListener('change', () => { extractTableBtn.disabled = !fileUploadInput.files.length; if(fileUploadInput.files.length > 0) { const fileExtension = fileUploadInput.files[0].name.split('.').pop().toLowerCase(); handwritingOptionWrapper.style.display = fileExtension === 'pdf' ? 'block' : 'none'; } else { handwritingOptionWrapper.style.display = 'none'; } }); }
            if (extractTableBtn) { extractTableBtn.addEventListener('click', () => { const file = fileUploadInput.files[0]; if (!file) return; const fileExtension = file.name.split('.').pop().toLowerCase(); showFileUploadStep('loading'); if (fileExtension === 'csv') { loadingText.textContent = "Parsing CSV file..."; const reader = new FileReader(); reader.onload = (e) => { const text = e.target.result; const rows = text.split('\n').filter(row => row.trim() !== ''); const headers = rows.shift().split(',').map(h => h.trim().replace(/"/g, '')); const headerMap = { "Unit Name": "Department", "ID Number": "Sr. No", "Employee Name": "Participant Name" }; const internalHeaders = headers.map(h => headerMap[h] || h); simulatedExtractedData = rows.map(row => { const values = row.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g).map(v => v.trim().replace(/"/g, '')); let obj = {}; headers.forEach((header, index) => { obj[headerMap[header] || header] = values[index]; }); return obj; }); populateReviewUI(internalHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }; reader.readAsText(file); } else if (fileExtension === 'pdf') { const detectHandwriting = detectHandwritingCheckbox.checked; loadingText.textContent = detectHandwriting ? "Analyzing document layout and performing OCR/HCR..." : "Analyzing PDF..."; setTimeout(() => { const baseData = [ { "Sr. No": "151-001122", "Participant Name": "Jatan Singh", "Department": "Housekeeping", "Designation": "Associate" }, { "Sr. No": "151-002246", "Participant Name": "Ganesh Y.", "Department": "Engineering", "Designation": "Supervisor" }, { "Sr. No": "999-12345", "Participant Name": "Joy Guha Roy", "Department": "Kitchen", "Designation": "Commis Chef" } ]; const pdfHeaders = ["Sr. No", "Participant Name", "Department", "Designation"]; simulatedExtractedData = detectHandwriting ? JSON.parse(JSON.stringify(baseData)).map(row => { /* ... handwritten logic ... */ return row; }) : JSON.parse(JSON.stringify(baseData)); populateReviewUI(pdfHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }, detectHandwriting ? 2500 : 1000); } }); }
            function populateReviewUI(headers, autoSelect) { const optionsHtml = headers.map(h => `<option value="${h}">${h}</option>`).join(''); mapIdSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapNameSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapDepartmentSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapIdSelect.value = autoSelect.id; mapNameSelect.value = autoSelect.name; mapDepartmentSelect.value = autoSelect.dept; reviewThead.innerHTML = `<tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>`; reviewTbody.innerHTML = simulatedExtractedData.map(row => `<tr>${headers.map(h => `<td class="${row.handwritten && row.handwritten[h] ? 'handwritten-text' : ''}">${row[h] !== undefined ? row[h] : ''}</td>`).join('')}</tr>`).join(''); showFileUploadStep('review'); }
            if (pdfBackBtn) { pdfBackBtn.addEventListener('click', () => { showFileUploadStep('upload'); }); }
            if (importParticipantsBtn) { 
                importParticipantsBtn.addEventListener('click', () => { 
                    const idCol = mapIdSelect.value, nameCol = mapNameSelect.value, deptCol = mapDepartmentSelect.value, roleCol = 'Designation';
                    if (!nameCol) { alert('Please map the Full Name column.'); return; } 
                    const reviewSection = document.getElementById('pdf-review-section'); 
                    const reviewTbody = document.getElementById('reviewed-participants-tbody'); 
                    reviewTbody.innerHTML = ''; 

                    // Get a list of names currently in the roster for quick checking
                    const rosterNames = rosterEmployeeIds.map(id => masterEmployeeList.find(emp => emp.id === id)?.name.toLowerCase());

                    simulatedExtractedData.forEach(rowData => { 
                        const importedName = rowData[nameCol] || '', importedId = rowData[idCol] || '', importedDept = rowData[deptCol] || '', importedRole = rowData[roleCol] || ''; 
                        const initials = importedName.split(' ').map(n=>n[0]).join('').toUpperCase(); 
                        
                        // Check for duplicate names already in the roster
                        const isInRoster = rosterNames.some(rosterName => jaroWinkler(importedName.toLowerCase(), rosterName) > 0.9);
                        const rosterBadge = isInRoster ? `<span class="badge bg-warning ms-2">In Roster</span>` : '';

                        let matches = []; 
                        const idMatch = masterEmployeeList.find(e=>e.id===importedId); 
                        if (idMatch){ matches.push({employee:idMatch, score:1, isIdMatch:true}); } 
                        else if(importedName) { matches = masterEmployeeList.map(emp => ({employee:emp, score: jaroWinkler(importedName.toLowerCase(), emp.name.toLowerCase()), isIdMatch:false})).filter(m=>m.score > 0.8 && !rosterEmployeeIds.includes(m.employee.id)).sort((a,b)=>b.score - a.score).slice(0,3); } 
                        
                        const popoverContent = (emp) => `<strong>ID:</strong> ${emp.id}<br><strong>Unit:</strong> ${emp.unit || 'N/A'}`; 
                        let suggestionsHTML = matches.length > 0 ? matches.map(m => `<a href="#" class="suggestion-link" data-employee='${JSON.stringify(m.employee)}' data-bs-toggle="popover" data-bs-trigger="hover" title="DB Record: ${m.employee.name}" data-bs-content="${popoverContent(m.employee)}"><i class="fas ${m.isIdMatch ? 'fa-id-badge text-success' : 'fa-user text-primary'} me-2"></i> ${m.employee.name} <span class="badge ${m.isIdMatch ? 'bg-success' : 'bg-primary'} float-end">${m.isIdMatch ? 'ID Match' : (m.score * 100).toFixed(0) + '%'}</span></a>`).join('') : '<div class="no-suggestions">No matches in DB.</div>'; 
                        
                        const actionsHTML = `<button class="btn btn-sm btn-outline-success add-reviewed-participant-btn" title="Add to Roster"><i class="fas fa-check"></i></button> ${matches.length === 0 ? `<button class="btn btn-sm btn-outline-primary add-manual-btn" title="Add as new employee"><i class="fas fa-user-plus"></i></button>` : ''} <button class="btn btn-sm btn-outline-danger discard-reviewed-participant-btn" title="Discard row"><i class="fas fa-trash"></i></button>`; 
                        
                        const createSelect = (options, selectedValue) => {
                            let uniqueOptions = [...new Set([...options, selectedValue].filter(Boolean))].sort();
                            return `<select class="form-select form-select-sm">${uniqueOptions.map(opt => `<option value="${opt}" ${opt === selectedValue ? 'selected' : ''}>${opt}</option>`).join('')}</select>`;
                        };

                        const deptDropdown = createSelect(allDepartments, importedDept);
                        const roleDropdown = createSelect(allRoles, importedRole);

                        const tr = document.createElement('tr'); 
                        tr.innerHTML = `<td><div class="employee-cell imported-info"><div class="avatar">${initials}</div><div class="employee-info w-100"><div class="name"><span contenteditable="true" class="imported-name-cell">${importedName}</span><span class="badge bg-success ms-2 matched-indicator" style="display:none;">Matched</span>${rosterBadge}</div><div class="imported-details"><div><small>ID:</small><span contenteditable="true" class="editable-id">${importedId}</span></div><div><small>Dept:</small><span class="editable-dept">${deptDropdown}</span></div><div><small>Role:</small><span class="editable-role">${roleDropdown}</span></div></div></div></div></td><td><div class="suggestions-container"><h6>Potential Matches</h6>${suggestionsHTML}</div></td><td class="action-cell">${actionsHTML}</td>`; 
                        reviewTbody.appendChild(tr); 
                    }); 
                    new bootstrap.Popover(reviewTbody, { selector: '[data-bs-toggle="popover"]', container: 'body', trigger: 'hover focus', html: true }); 
                    reviewSection.style.display = 'block'; 
                    uploadFileModal.hide(); 
                }); 
            }
            function addParticipantToRoster(data) { if (!data.id && !data.name) return; if (!data.id) data.id = `NEW-${Date.now().toString().slice(-6)}`; if (rosterEmployeeIds.includes(data.id)) return; if (!masterEmployeeList.some(emp => emp.id === data.id)) { masterEmployeeList.push({ id: data.id, name: data.name, initials: data.name.split(' ').map(n => n[0]).join('').toUpperCase(), department: data.department, role: data.role, status: 'neutral' }); } rosterEmployeeIds.push(data.id); trainingParticipantData[currentTrainingId].statuses[data.id] = 'neutral'; renderTable(); }
            if(manageParticipantsModalBody) { manageParticipantsModalBody.addEventListener('click', e => { const targetBtn = e.target.closest('a, button'); if (!targetBtn) return; e.preventDefault(); const reviewTbody = document.getElementById('reviewed-participants-tbody'); if (targetBtn.matches('.suggestion-link')) { const tr = targetBtn.closest('tr'); const employeeData = JSON.parse(targetBtn.dataset.employee); tr.querySelector('.editable-id').textContent = employeeData.id; tr.querySelector('.imported-name-cell').textContent = employeeData.name; tr.querySelector('.editable-dept select').value = employeeData.department || ''; tr.querySelector('.editable-role select').value = employeeData.role || ''; tr.querySelector('.matched-indicator').style.display = 'inline-block'; } if (targetBtn.matches('.add-manual-btn')) { const tr = targetBtn.closest('tr'); addEmployeeModal.dataset.sourceRowIndex = Array.from(reviewTbody.children).indexOf(tr); addEmployeeForm.reset(); document.getElementById('add-employee-form-container').querySelector('h2').textContent = "Add New User from Import"; document.getElementById('full-name').value = tr.querySelector('.imported-name-cell').textContent.trim(); document.getElementById('employee-id').value = tr.querySelector('.editable-id').textContent.trim(); document.getElementById('department-select').value = tr.querySelector('.editable-dept select').value; document.getElementById('designation').value = tr.querySelector('.editable-role select').value; addEmployeeModal.classList.add('visible'); } if (targetBtn.matches('.add-reviewed-participant-btn')) { const tr = targetBtn.closest('tr'); const employeeName = tr.querySelector('.imported-name-cell').textContent.trim(); if (!employeeName) { alert('Participant Name cannot be empty.'); return; } addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: employeeName, department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); tr.remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.matches('.discard-reviewed-participant-btn')) { targetBtn.closest('tr').remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.id === 'add-all-reviewed-btn') { if (confirm(`Add all ${reviewTbody.rows.length} participants?`)) { [...reviewTbody.rows].forEach(tr => { addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: tr.querySelector('.imported-name-cell').textContent.trim(), department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); }); reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } if (targetBtn.id === 'discard-all-reviewed-btn') { if (confirm('Discard all imported participants?')) { reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } }); }
            
            function initAddEmployeeForm() {
                const corporateSelect = document.getElementById('corporate-select');
                const regionalSelect = document.getElementById('regional-select');
                const unitSelect = document.getElementById('unit-select');
                const departmentSelect = document.getElementById('department-select');

                function populateDropdown(selectElement, options, placeholder) {
                    selectElement.innerHTML = `<option value="">${placeholder}</option>`;
                    options.forEach(option => selectElement.add(new Option(option, option)));
                    selectElement.disabled = options.length === 0;
                }

                populateDropdown(corporateSelect, Object.keys(orgData), 'Select Corporate');

                corporateSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const regionals = selectedCorporate ? Object.keys(orgData[selectedCorporate]) : [];
                    populateDropdown(regionalSelect, regionals, 'Select Regional');
                    populateDropdown(unitSelect, [], 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                });
                
                regionalSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const selectedRegional = regionalSelect.value;
                    const units = selectedCorporate && selectedRegional ? Object.keys(orgData[selectedCorporate][selectedRegional]) : [];
                    populateDropdown(unitSelect, units, 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                });

                unitSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const selectedRegional = regionalSelect.value;
                    const selectedUnit = unitSelect.value;
                    const departments = selectedCorporate && selectedRegional && selectedUnit ? orgData[selectedCorporate][selectedRegional][selectedUnit] : [];
                    $(departmentSelect).empty().append('<option value="">Select Department</option>');
                    departments.forEach(dept => $(departmentSelect).append(new Option(dept, dept)));
                    $(departmentSelect).prop('disabled', departments.length === 0).selectpicker('refresh');
                });
                
                function hideAddEmployeeModal() {
                    addEmployeeModal.classList.remove('visible');
                    addEmployeeForm.reset();
                    populateDropdown(regionalSelect, [], 'Select Regional');
                    populateDropdown(unitSelect, [], 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                    delete addEmployeeModal.dataset.sourceRowIndex; 
                }

                if (modalCloseBtn) modalCloseBtn.addEventListener('click', hideAddEmployeeModal);
                if (modalCancelBtn) modalCancelBtn.addEventListener('click', hideAddEmployeeModal);

                if (addNewEmployeeBtn) {
                    addNewEmployeeBtn.addEventListener('click', () => {
                        addEmployeeForm.reset();
                        addEmployeeFormContainer.querySelector('h2').textContent = "Add New Employee";
                        delete addEmployeeModal.dataset.sourceRowIndex;
                        addEmployeeModal.classList.add('visible');
                    });
                }
                
                if (addEmployeeForm) {
                    addEmployeeForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        const newEmployee = {
                            id: document.getElementById('employee-id').value.trim(),
                            name: document.getElementById('full-name').value.trim(),
                            corporate: corporateSelect.value,
                            regional: regionalSelect.value,
                            unit: unitSelect.value,
                            department: $(departmentSelect).val(),
                            email: document.getElementById('email').value.trim(),
                            phone: document.getElementById('contact').value.trim(),
                            gender: document.getElementById('gender').value,
                            role: document.getElementById('designation').value.trim(),
                            joined: document.getElementById('date-joining').value,
                            born: document.getElementById('date-birth').value,
                            category: document.getElementById('staff-category').value,
                            foodHandler: document.getElementById('food-handlers-category').value
                        };
                        newEmployee.initials = newEmployee.name.split(' ').map(n => n[0]).join('').toUpperCase();
                        if (!newEmployee.id || !newEmployee.name) {
                            alert('Employee ID and Full Name are required.');
                            return;
                        }
                        if (masterEmployeeList.some(emp => emp.id === newEmployee.id)) {
                            alert(`An employee with ID ${newEmployee.id} already exists.`);
                            return;
                        }
                        masterEmployeeList.unshift(newEmployee);
                        addParticipantToRoster(newEmployee);
                        if (addEmployeeModal.dataset.sourceRowIndex) {
                            const reviewTbody = document.getElementById('reviewed-participants-tbody');
                            const rowIndex = parseInt(addEmployeeModal.dataset.sourceRowIndex, 10);
                            if (reviewTbody.rows[rowIndex]) { reviewTbody.rows[rowIndex].remove(); }
                             if (reviewTbody.rows.length === 0) { document.getElementById('pdf-review-section').style.display = 'none'; }
                        }
                        hideAddEmployeeModal();
                    });
                }
            }
            initAddEmployeeForm();
        });
    </script>
    <!-- Custom JavaScript for Training Calendar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const topicData = { "Food Safety Management": ["Introduction to Food Safety", "HACCP Level 1: Principles", "HACCP Level 2: Implementation", "Internal Auditing for Food Safety"], "Personal Hygiene": ["Handwashing Techniques", "Uniform and Personal Protective Equipment (PPE)", "Illness Reporting Policy"], "Allergen Management": ["Identifying Major Allergens", "Preventing Cross-Contamination", "Labeling and Communication"], "Diversey Training For Existing Employees": [], "Emergency Procedures": ["Fire Safety", "First Aid Basics"] };
            const allTrainers = [ { name: "Mr. Sanjay Verma", scope: "unit" }, { name: "Ms. Anjali Patil", scope: "unit" }, { name: "Mr. Raj Sharma", scope: "regional" }, { name: "Ms. Deepa Iyer", scope: "regional" }, { name: "Dr. Alok Nath", scope: "corporate" }, { name: "Mr. Kuldeep Kumar Sharma", scope: "external" }, { name: "Ms. Priya Sharma", scope: "external" } ];
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl); });
            flatpickr("#uploadDate", { dateFormat: "Y-m-d", defaultDate: "today" });
            const commonConfig = { enableTime: true, dateFormat: "Y-m-d H:i", altInput: true, altFormat: "M j, Y h:i K", allowInput: true };
            let endDatePicker = flatpickr("#endTimeInput", commonConfig);
            let startDatePicker = flatpickr("#startTimeInput", { ...commonConfig, onChange: function(selectedDates) { if (selectedDates[0]) { endDatePicker.set('minDate', selectedDates[0]); } } });
            const viewToggleButtons = document.querySelectorAll('.view-toggle-btn, .switch-view');
            const tableView = document.getElementById('tableView'); const calendarView = document.getElementById('calendarView');
            function switchView(viewName) { document.querySelectorAll('.view-toggle-btn').forEach(btn => btn.classList.toggle('active', btn.dataset.view === viewName)); tableView.style.display = viewName === 'table' ? 'block' : 'none'; calendarView.style.display = viewName === 'calendar' ? 'block' : 'none'; }
            viewToggleButtons.forEach(button => button.addEventListener('click', function() { switchView(this.dataset.view); }));
            const qrcodeModal = new bootstrap.Modal(document.getElementById('qrcodeModal'));
            document.body.addEventListener('click', function(event) { if (event.target.classList.contains('qrcode-img')) { document.getElementById('modalQrcode').src = event.target.src; document.getElementById('downloadQrcode').href = event.target.src; qrcodeModal.show(); }});
            
            const addTrainingModalEl = document.getElementById('addTrainingModal');
            const addTrainingModal = new bootstrap.Modal(addTrainingModalEl);
            const addTrainingForm = document.getElementById('addTrainingForm');
            if (addTrainingModalEl) {
                const courseTitlesSelect = document.getElementById('courseTitlesSelect'); const subTopicWrapper = document.getElementById('subTopicWrapper'); const subTopicSelect = document.getElementById('subTopicSelect'); const trainerScopeSelect = document.getElementById('trainerScopeSelect'); const trainerNameSelect = document.getElementById('trainerNameSelect'); const externalTrainerNameWrapper = document.getElementById('externalTrainerNameWrapper'); const externalCompanyNameWrapper = document.getElementById('externalCompanyNameWrapper');
                function populateMainTopics() { courseTitlesSelect.innerHTML = '<option value="">Select Training Topic</option>'; for (const topic in topicData) courseTitlesSelect.add(new Option(topic, topic)); }
                function updateSubTopics() { const selectedTopic = courseTitlesSelect.value; const subTopics = topicData[selectedTopic] || []; subTopicWrapper.style.display = subTopics.length > 0 ? 'block' : 'none'; subTopicSelect.required = subTopics.length > 0; if (subTopics.length > 0) { subTopicSelect.innerHTML = '<option value="">Select Sub Topic</option>'; subTopics.forEach(sub => subTopicSelect.add(new Option(sub, sub))); } }
                function updateTrainerNames() { const scope = trainerScopeSelect.value; const filteredTrainers = allTrainers.filter(t => t.scope === scope); $(trainerNameSelect).empty(); if (filteredTrainers.length > 0) filteredTrainers.forEach(t => $(trainerNameSelect).append(new Option(t.name, t.name))); if (scope === 'external') $(trainerNameSelect).append(new Option('Add New External Trainer...', 'add_new_external')); $(trainerNameSelect).selectpicker('refresh'); handleTrainerNameChange(); }
                function handleTrainerNameChange() { const isAddNew = trainerNameSelect.value === 'add_new_external'; externalTrainerNameWrapper.style.display = isAddNew ? 'block' : 'none'; externalCompanyNameWrapper.style.display = isAddNew ? 'block' : 'none'; externalTrainerNameWrapper.querySelector('input').required = isAddNew; }
                courseTitlesSelect.addEventListener('change', updateSubTopics); trainerScopeSelect.addEventListener('change', updateTrainerNames); trainerNameSelect.addEventListener('change', handleTrainerNameChange);
                addTrainingModalEl.addEventListener('show.bs.modal', function () { populateMainTopics(); updateSubTopics(); trainerScopeSelect.value = 'unit'; updateTrainerNames(); });
                
                addTrainingForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const mainTableBody = document.querySelector('#tableView tbody');
                    const newId = `T-${Date.now().toString().slice(-6)}`;
                    const formData = new FormData(addTrainingForm); const newTraining = Object.fromEntries(formData.entries());
                    let trainerName = newTraining.trainer; if (trainerName === 'add_new_external') trainerName = newTraining.external_trainer_name;
                    const startDate = new Date(newTraining.start_time); const endDate = new Date(newTraining.end_time); const dateString = startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); const timeString = `${startDate.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'})} - ${endDate.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'})}`;
                    let modeBadgeClass = 'bg-primary'; if(newTraining.course_mode === 'Online') modeBadgeClass = 'badge-online'; if(newTraining.course_mode === 'Recorded') modeBadgeClass = 'badge-recorded';
                    const newRowHTML = `<tr><td>${mainTableBody.rows.length + 1}</td><td><span class="training-status status-upcoming"></span>Upcoming</td><td><span class="badge ${modeBadgeClass}">${newTraining.course_mode}</span></td><td><strong>${newTraining.course_titles}</strong><div class="text-muted small mt-1">${newTraining.sub_topic || ''}</div></td><td>${trainerName}</td><td><div class="d-flex flex-column"><small class="text-muted">${dateString}</small><span>${timeString}</span></div></td><td><div class="attendance-stats"><button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#manageParticipantsModal" data-training-id="${newId}"><i class="fas fa-user-edit me-1"></i>Manage<span class="badge rounded-pill bg-success ms-2" title="Present">0</span><span class="badge rounded-pill bg-danger ms-1" title="Absent">0</span></button></div></td><td><img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F${newId}" alt="QR Code" class="qrcode-img" data-bs-toggle="tooltip" title="Click to enlarge"></td><td><div class="text-muted">Not available</div></td><td><div class="action-buttons"><a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a><a href="#" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>`;
                    mainTableBody.insertAdjacentHTML('afterbegin', newRowHTML);
                    addTrainingForm.reset(); $(trainerNameSelect).selectpicker('val', '');
                    addTrainingModal.hide();
                    window.tableManager.populateFilters(); window.tableManager.applyAllFilters();
                });
            }
        });
    </script>
    
    <!-- JavaScript for Table Filters, Pagination, Dashboard, and Export -->
    <!--<script>-->
    <!--    document.addEventListener('DOMContentLoaded', () => {-->
    <!--        const tableBody = document.querySelector('#tableView tbody');-->
    <!--        const filterableHeaders = document.querySelectorAll('thead th[data-column-index]');-->
    <!--        const paginationControls = document.getElementById('pagination-controls');-->
    <!--        const rowsPerPageSelect = document.getElementById('rows-per-page-select');-->
            
    <!--        let activeFilters = {}; let topicHierarchy = {}; let currentPage = 1; let rowsPerPage = parseInt(rowsPerPageSelect.value, 10);-->
    <!--        const totalCountEl = document.getElementById('total-trainings-count'); const upcomingCountEl = document.getElementById('upcoming-count'); const ongoingCountEl = document.getElementById('ongoing-count'); const completedCountEl = document.getElementById('completed-count'); const participantsCountEl = document.getElementById('total-participants-count');-->

    <!--        const tableManager = {-->
    <!--            updateDashboardMetrics() {-->
    <!--                let total = 0, upcoming = 0, ongoing = 0, completed = 0, participants = 0;-->
    <!--                tableBody.querySelectorAll('tr').forEach(row => {-->
    <!--                    if (row.dataset.filtered === 'true') return;-->
    <!--                    total++; const statusText = row.cells[1].textContent; if (statusText.includes('Upcoming')) upcoming++; if (statusText.includes('Ongoing')) ongoing++; if (statusText.includes('Completed')) completed++;-->
    <!--                    row.cells[6].querySelectorAll('.badge').forEach(badge => { const count = parseInt(badge.textContent, 10); if (!isNaN(count)) participants += count; });-->
    <!--                });-->
    <!--                totalCountEl.textContent = total; upcomingCountEl.textContent = upcoming; ongoingCountEl.textContent = ongoing; completedCountEl.textContent = completed; participantsCountEl.textContent = participants;-->
    <!--            },-->
               
               
    <!--            displayPage(page) { currentPage = page; const visibleRows = Array.from(tableBody.rows).filter(row => row.dataset.filtered !== 'true'); tableBody.querySelectorAll('tr').forEach(row => row.style.display = 'none'); const start = (page - 1) * rowsPerPage; const end = rowsPerPage === Infinity ? visibleRows.length : start + rowsPerPage; visibleRows.slice(start, end).forEach(row => row.style.display = ''); },-->
                
                
    <!--            setupPagination() { const visibleRows = Array.from(tableBody.rows).filter(row => row.dataset.filtered !== 'true'); const pageCount = rowsPerPage === Infinity ? 1 : Math.ceil(visibleRows.length / rowsPerPage); paginationControls.innerHTML = ''; if (pageCount <= 1) return; let html = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="prev"><i class="fas fa-angle-left"></i></a></li>`; for (let i = 1; i <= pageCount; i++) html += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`; html += `<li class="page-item ${currentPage === pageCount ? 'disabled' : ''}"><a class="page-link" href="#" data-page="next"><i class="fas fa-angle-right"></i></a></li>`; paginationControls.innerHTML = html; },-->
                
                
    <!--            getCellContent(row, index) { const cell = row.cells[index]; if (!cell) return ''; switch(index) { case 1: return cell.textContent.trim(); case 2: return cell.querySelector('.badge')?.textContent.trim() || ''; case 3: return { main: cell.querySelector('strong')?.textContent.trim() || '', sub: cell.querySelector('.text-muted')?.textContent.trim() || '' }; case 4: return cell.textContent.trim(); case 5: const dateText = cell.querySelector('small')?.textContent.trim(); try { return new Date(dateText).toISOString(); } catch (e) { return dateText; } default: return cell.textContent.trim(); }},-->
    <!--            updateSubTopicFilter() { const topicHeader = document.querySelector('th[data-column-index="3"]'); if (!topicHeader) return; const mainTopicWrapper = topicHeader.querySelector('#main-topic-wrapper'); const subTopicWrapper = topicHeader.querySelector('#sub-topic-wrapper'); const mainTopicCheckboxes = topicHeader.querySelectorAll('.filter-options-main .form-check-input:checked'); const subTopicContainer = topicHeader.querySelector('.filter-options-sub'); mainTopicWrapper.classList.toggle('col-6', mainTopicCheckboxes.length > 0); mainTopicWrapper.classList.toggle('col-12', mainTopicCheckboxes.length === 0); subTopicWrapper.style.display = mainTopicCheckboxes.length > 0 ? 'block' : 'none'; const relevantSubTopics = new Set(); if (mainTopicCheckboxes.length > 0) mainTopicCheckboxes.forEach(cb => { if (topicHierarchy[cb.value]) topicHierarchy[cb.value].forEach(sub => relevantSubTopics.add(sub)); }); const sortedSubTopics = Array.from(relevantSubTopics).sort(); subTopicContainer.innerHTML = sortedSubTopics.map(value => `<div class="form-check"><input class="form-check-input" type="checkbox" value="${value}" id="filter-sub-${value.replace(/\s+/g, '')}"><label class="form-check-label" for="filter-sub-${value.replace(/\s+/g, '')}">${value}</label></div>`).join(''); if (sortedSubTopics.length === 0 && mainTopicCheckboxes.length > 0) subTopicContainer.innerHTML = '<div class="text-muted small px-2">No sub-topics for selection.</div>'; },-->
    <!--            populateFilters() { const uniqueValues = {}; topicHierarchy = {}; filterableHeaders.forEach(th => { const index = parseInt(th.dataset.columnIndex, 10); if (index !== 3 && index !== 5) uniqueValues[index] = new Set(); }); for (const row of tableBody.rows) { for (const indexStr in uniqueValues) { const index = parseInt(indexStr, 10); const content = this.getCellContent(row, index); if (content) uniqueValues[index].add(content); } const topicContent = this.getCellContent(row, 3); if (topicContent.main) { if (!topicHierarchy[topicContent.main]) topicHierarchy[topicContent.main] = new Set(); if (topicContent.sub) topicHierarchy[topicContent.main].add(topicContent.sub); } } filterableHeaders.forEach(th => { const index = parseInt(th.dataset.columnIndex, 10); if (index === 3) { const mainTopicContainer = th.querySelector('.filter-options-main'); const sortedMainTopics = Object.keys(topicHierarchy).sort(); mainTopicContainer.innerHTML = sortedMainTopics.map(value => `<div class="form-check"><input class="form-check-input" type="checkbox" value="${value}" id="filter-main-${value.replace(/\s+/g, '')}"><label class="form-check-label" for="filter-main-${value.replace(/\s+/g, '')}">${value}</label></div>`).join(''); mainTopicContainer.addEventListener('change', this.updateSubTopicFilter); this.updateSubTopicFilter(); } else if (index !== 5) { const dropdown = th.querySelector('.filter-options'); if (dropdown) { const sortedValues = Array.from(uniqueValues[index]).sort(); dropdown.innerHTML = sortedValues.map(value => `<div class="form-check"><input class="form-check-input" type="checkbox" value="${value}" id="filter-${index}-${value.replace(/\s+/g, '')}"><label class="form-check-label" for="filter-${index}-${value.replace(/\s+/g, '')}">${value}</label></div>`).join(''); } } }); },-->
    <!--            applyAllFilters() { for (const row of tableBody.rows) { let isVisible = true; for (const key in activeFilters) { const index = parseInt(key, 10); const filter = activeFilters[key]; const content = this.getCellContent(row, index); if (index === 3) { const mainTopics = filter.main || []; const subTopics = filter.sub || []; const mainMatch = mainTopics.length === 0 || mainTopics.includes(content.main); const subMatch = subTopics.length === 0 || subTopics.includes(content.sub); if (!mainMatch || (mainTopics.length > 0 && !subMatch)) { isVisible = false; break; } } else if (index === 5) { const rowDate = new Date(content); if (isNaN(rowDate)) { isVisible = false; break; } const fromDate = filter.from ? new Date(filter.from) : null; const toDate = filter.to ? new Date(filter.to) : null; if (fromDate && rowDate < fromDate) { isVisible = false; break; } if (toDate) { toDate.setHours(23, 59, 59); if(rowDate > toDate) { isVisible = false; break; } } } else { if (filter.length > 0 && !filter.includes(content)) { isVisible = false; break; } } } row.dataset.filtered = isVisible ? 'false' : 'true'; } this.updateDashboardMetrics(); this.setupPagination(); this.displayPage(1); }-->
    <!--        };-->
    <!--        window.tableManager = tableManager;-->
    <!--        paginationControls.addEventListener('click', (e) => { e.preventDefault(); const target = e.target.closest('.page-link'); if (!target || target.parentElement.classList.contains('disabled')) return; const page = target.dataset.page; if (page === 'prev') { if (currentPage > 1) currentPage--; } else if (page === 'next') { const pageCount = Math.ceil(Array.from(tableBody.rows).filter(r=>r.dataset.filtered!=='true').length / rowsPerPage); if (currentPage < pageCount) currentPage++; } else { currentPage = parseInt(page, 10); } tableManager.setupPagination(); tableManager.displayPage(currentPage); });-->
    <!--        rowsPerPageSelect.addEventListener('change', (e) => { const value = e.target.value; rowsPerPage = value === 'all' ? Infinity : parseInt(value, 10); tableManager.setupPagination(); tableManager.displayPage(1); });-->
    <!--        filterableHeaders.forEach(th => { const index = th.dataset.columnIndex; const dropdownMenu = th.querySelector('.dropdown-menu'); const filterIcon = th.querySelector('.filter-icon'); dropdownMenu.querySelector('.apply-filter-btn').addEventListener('click', () => { if (index === '3') { const selectedMain = Array.from(dropdownMenu.querySelectorAll('.filter-options-main .form-check-input:checked')).map(cb => cb.value); const selectedSub = Array.from(dropdownMenu.querySelectorAll('.filter-options-sub .form-check-input:checked')).map(cb => cb.value); if (selectedMain.length > 0 || selectedSub.length > 0) { activeFilters[index] = { main: selectedMain, sub: selectedSub }; filterIcon.classList.add('filter-active'); } else { delete activeFilters[index]; filterIcon.classList.remove('filter-active'); } } else if (index === '5') { const from = dropdownMenu.querySelector('.date-range-from').value; const to = dropdownMenu.querySelector('.date-range-to').value; if(from || to) { activeFilters[index] = { from, to }; filterIcon.classList.add('filter-active'); } else { delete activeFilters[index]; filterIcon.classList.remove('filter-active'); } } else { const selected = Array.from(dropdownMenu.querySelectorAll('.filter-options .form-check-input:checked')).map(cb => cb.value); if (selected.length > 0) { activeFilters[index] = selected; filterIcon.classList.add('filter-active'); } else { delete activeFilters[index]; filterIcon.classList.remove('filter-active'); } } tableManager.applyAllFilters(); bootstrap.Dropdown.getInstance(filterIcon).hide(); }); dropdownMenu.querySelector('.reset-filter-btn').addEventListener('click', () => { delete activeFilters[index]; if (index === '3') { dropdownMenu.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false); dropdownMenu.querySelectorAll('input[type="search"]').forEach(input => input.value=''); tableManager.updateSubTopicFilter(); } else if (index === '5') { dropdownMenu.querySelector('.date-range-from')._flatpickr.clear(); dropdownMenu.querySelector('.date-range-to')._flatpickr.clear(); } else { dropdownMenu.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false); const searchInput = dropdownMenu.querySelector('.filter-search'); if(searchInput) searchInput.value = ''; } filterIcon.classList.remove('filter-active'); dropdownMenu.querySelectorAll('.filter-search').forEach(input => { input.dispatchEvent(new Event('input')); }); tableManager.applyAllFilters(); bootstrap.Dropdown.getInstance(filterIcon).hide(); }); dropdownMenu.querySelectorAll('.filter-search, .filter-search-main, .filter-search-sub').forEach(searchInput => { searchInput.addEventListener('input', (e) => { const searchTerm = e.target.value.toLowerCase(); let container = e.target.closest('div').nextElementSibling; container.querySelectorAll('.form-check').forEach(item => { item.style.display = item.querySelector('label').textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none'; }); }); }); });-->
    <!--        function getCleanCellText(cell) { if (!cell) return ''; return cell.textContent.trim().replace(/\s\s+/g, ' '); }-->
    <!--        function downloadAsCSV(filename, headers, data) { const csvString = [headers.join(','), ...data.map(row => row.map(val => `"${('' + val).replace(/"/g, '""')}"`).join(','))].join('\n'); const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' }); const link = document.createElement('a'); if (link.download !== undefined) { const url = URL.createObjectURL(blob); link.setAttribute('href', url); link.setAttribute('download', filename); link.style.visibility = 'hidden'; document.body.appendChild(link); link.click(); document.body.removeChild(link); } }-->
    <!--        document.getElementById('download-csv-btn').addEventListener('click', () => { const headers = ['#', 'Status', 'Mode', 'Training Topic', 'Sub Topic', 'Trainer', 'Date', 'Participants', 'Training Sheet Link']; const rows = []; tableBody.querySelectorAll('tr').forEach(row => { if (row.dataset.filtered !== 'true') { const rowData = []; rowData.push(getCleanCellText(row.cells[0]), getCleanCellText(row.cells[1]), getCleanCellText(row.cells[2]), getCleanCellText(row.cells[3].querySelector('strong')), getCleanCellText(row.cells[3].querySelector('div')), getCleanCellText(row.cells[4]), getCleanCellText(row.cells[5].querySelector('small'))); const present = row.cells[6].querySelector('.bg-success')?.textContent || '0'; const absent = row.cells[6].querySelector('.bg-danger')?.textContent || '0'; rowData.push(`Present: ${present}, Absent: ${absent}`); const viewLink = row.cells[8].querySelector('a.btn-outline-secondary'); rowData.push(viewLink ? viewLink.href : getCleanCellText(row.cells[8])); rows.push(rowData); } }); downloadAsCSV('training_data.csv', headers, rows); });-->
    <!--        document.getElementById('refresh-table-btn').addEventListener('click', (e) => { const btn = e.currentTarget; const icon = btn.querySelector('i'); icon.classList.add('fa-spin'); btn.disabled = true; setTimeout(() => { tableManager.populateFilters(); tableManager.applyAllFilters(); icon.classList.remove('fa-spin'); btn.disabled = false; }, 500); });-->
    <!--        flatpickr(".date-range-from", { dateFormat: "Y-m-d" }); flatpickr(".date-range-to", { dateFormat: "Y-m-d" });-->
    <!--        tableManager.populateFilters(); tableManager.applyAllFilters();-->
    <!--    });-->
    <!--</script>-->
    
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#tableView tbody');
    const filterableHeaders = document.querySelectorAll('thead th[data-column-index]');
    const paginationControls = document.getElementById('pagination-controls');
    const rowsPerPageSelect = document.getElementById('rows-per-page-select');

    let activeFilters = {};
    let topicHierarchy = {};
    let currentPage = 1;
    let rowsPerPage = rowsPerPageSelect ? (rowsPerPageSelect.value === 'all' ? Infinity : parseInt(rowsPerPageSelect.value, 10)) : 10;

    const totalCountEl = document.getElementById('total-trainings-count');
    const upcomingCountEl = document.getElementById('upcoming-count');
    const ongoingCountEl = document.getElementById('ongoing-count');
    const completedCountEl = document.getElementById('completed-count');
    const participantsCountEl = document.getElementById('total-participants-count');

    const tableManager = {
        // ===== Dashboard metrics =====
        updateDashboardMetrics() {
            let total = 0, upcoming = 0, ongoing = 0, completed = 0, participants = 0;
            tableBody.querySelectorAll('tr').forEach(row => {
                if (row.dataset.filtered === 'true') return;
                total++;
                const statusText = row.cells[1]?.textContent || '';
                if (statusText.includes('Upcoming')) upcoming++;
                if (statusText.includes('Ongoing')) ongoing++;
                if (statusText.includes('Completed')) completed++;
                row.cells[6]?.querySelectorAll('.badge')?.forEach(badge => {
                    const count = parseInt(badge.textContent, 10);
                    if (!isNaN(count)) participants += count;
                });
            });
            if (totalCountEl) totalCountEl.textContent = total;
            if (upcomingCountEl) upcomingCountEl.textContent = upcoming;
            if (ongoingCountEl) ongoingCountEl.textContent = ongoing;
            if (completedCountEl) completedCountEl.textContent = completed;
            if (participantsCountEl) participantsCountEl.textContent = participants;
        },

        // ===== Pagination helpers =====
        _visibleRows() {
            return Array.from(tableBody.rows).filter(r => r.dataset.filtered !== 'true');
        },
        _pageCount() {
            const len = this._visibleRows().length;
            return rowsPerPage === Infinity ? 1 : Math.max(1, Math.ceil(len / rowsPerPage));
        },
        _buildCondensedPages(pageCount, current, boundaryCount = 2, siblingCount = 1) {
            // Material-UI style algorithm (always show boundaryCount pages at both ends + siblings around current)
            if (pageCount <= boundaryCount * 2 + siblingCount * 2 + 3) {
                return Array.from({ length: pageCount }, (_, i) => i + 1);
            }

            const startPages = Array.from({ length: boundaryCount }, (_, i) => i + 1);
            const endPages = Array.from({ length: boundaryCount }, (_, i) => pageCount - boundaryCount + 1 + i);

            const start = Math.max(
                Math.min(current - siblingCount, pageCount - boundaryCount - siblingCount * 2 - 1),
                boundaryCount + 2
            );
            const end = Math.min(
                Math.max(current + siblingCount, boundaryCount + siblingCount * 2 + 2),
                endPages[0] - 2
            );

            const pages = [...startPages];

            if (start > startPages[startPages.length - 1] + 1) {
                pages.push('...');
            } else if (start === startPages[startPages.length - 1] + 1) {
                pages.push(start - 1);
            }

            for (let i = start; i <= end; i++) pages.push(i);

            if (end < endPages[0] - 1) {
                pages.push('...');
            } else if (end === endPages[0] - 1) {
                pages.push(end + 1);
            }

            pages.push(...endPages);
            return pages;
        },

        // ===== Render page =====
        displayPage(page) {
            const visibleRows = this._visibleRows();
            const pageCount = this._pageCount();

            if (page < 1) page = 1;
            if (page > pageCount) page = pageCount;

            currentPage = page;

            // hide all
            tableBody.querySelectorAll('tr').forEach(row => (row.style.display = 'none'));

            if (rowsPerPage === Infinity) {
                visibleRows.forEach(row => (row.style.display = ''));
                return;
            }

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            visibleRows.slice(start, end).forEach(row => (row.style.display = ''));
        },

        // ===== Ellipsis pagination =====
        setupPagination() {
            const pageCount = this._pageCount();
            paginationControls.innerHTML = '';
            if (pageCount <= 1) return;

            let html = `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="prev"><i class="fas fa-angle-left"></i></a>
                </li>
            `;

            const pages = this._buildCondensedPages(pageCount, currentPage, 2, 1);
            pages.forEach(p => {
                if (p === '...') {
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                } else {
                    html += `
                        <li class="page-item ${currentPage === p ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${p}">${p}</a>
                        </li>`;
                }
            });

            html += `
                <li class="page-item ${currentPage === pageCount ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="next"><i class="fas fa-angle-right"></i></a>
                </li>`;

            paginationControls.innerHTML = html;
        },

        // ===== Cell parsing & filters (unchanged) =====
        getCellContent(row, index) {
            const cell = row.cells[index];
            if (!cell) return '';
            switch (index) {
                case 1: return cell.textContent.trim();
                case 2: return cell.querySelector('.badge')?.textContent.trim() || '';
                case 3: return {
                    main: cell.querySelector('strong')?.textContent.trim() || '',
                    sub: cell.querySelector('.text-muted')?.textContent.trim() || ''
                };
                case 4: return cell.textContent.trim();
                case 5:
                    const dateText = cell.querySelector('small')?.textContent.trim();
                    try { return new Date(dateText).toISOString(); } catch { return dateText; }
                default: return cell.textContent.trim();
            }
        },

        updateSubTopicFilter() {
            const topicHeader = document.querySelector('th[data-column-index="3"]');
            if (!topicHeader) return;
            const mainTopicWrapper = topicHeader.querySelector('#main-topic-wrapper');
            const subTopicWrapper = topicHeader.querySelector('#sub-topic-wrapper');
            const mainTopicCheckboxes = topicHeader.querySelectorAll('.filter-options-main .form-check-input:checked');
            const subTopicContainer = topicHeader.querySelector('.filter-options-sub');

            mainTopicWrapper.classList.toggle('col-6', mainTopicCheckboxes.length > 0);
            mainTopicWrapper.classList.toggle('col-12', mainTopicCheckboxes.length === 0);
            subTopicWrapper.style.display = mainTopicCheckboxes.length > 0 ? 'block' : 'none';

            const relevantSubTopics = new Set();
            if (mainTopicCheckboxes.length > 0) {
                mainTopicCheckboxes.forEach(cb => {
                    if (topicHierarchy[cb.value]) topicHierarchy[cb.value].forEach(sub => relevantSubTopics.add(sub));
                });
            }
            const sortedSubTopics = Array.from(relevantSubTopics).sort();
            subTopicContainer.innerHTML = sortedSubTopics.map(value =>
                `<div class="form-check">
                    <input class="form-check-input" type="checkbox" value="${value}" id="filter-sub-${value.replace(/\s+/g, '')}">
                    <label class="form-check-label" for="filter-sub-${value.replace(/\s+/g, '')}">${value}</label>
                 </div>`).join('');
            if (sortedSubTopics.length === 0 && mainTopicCheckboxes.length > 0)
                subTopicContainer.innerHTML = '<div class="text-muted small px-2">No sub-topics for selection.</div>';
        },

        populateFilters() {
            const uniqueValues = {};
            topicHierarchy = {};
            filterableHeaders.forEach(th => {
                const index = parseInt(th.dataset.columnIndex, 10);
                if (index !== 3 && index !== 5) uniqueValues[index] = new Set();
            });

            for (const row of tableBody.rows) {
                for (const indexStr in uniqueValues) {
                    const index = parseInt(indexStr, 10);
                    const content = this.getCellContent(row, index);
                    if (content) uniqueValues[index].add(content);
                }
                const topicContent = this.getCellContent(row, 3);
                if (topicContent.main) {
                    if (!topicHierarchy[topicContent.main]) topicHierarchy[topicContent.main] = new Set();
                    if (topicContent.sub) topicHierarchy[topicContent.main].add(topicContent.sub);
                }
            }

            filterableHeaders.forEach(th => {
                const index = parseInt(th.dataset.columnIndex, 10);
                if (index === 3) {
                    const mainTopicContainer = th.querySelector('.filter-options-main');
                    const sortedMainTopics = Object.keys(topicHierarchy).sort();
                    mainTopicContainer.innerHTML = sortedMainTopics.map(value =>
                        `<div class="form-check">
                            <input class="form-check-input" type="checkbox" value="${value}" id="filter-main-${value.replace(/\s+/g, '')}">
                            <label class="form-check-label" for="filter-main-${value.replace(/\s+/g, '')}">${value}</label>
                         </div>`).join('');
                    mainTopicContainer.addEventListener('change', this.updateSubTopicFilter);
                    this.updateSubTopicFilter();
                } else if (index !== 5) {
                    const dropdown = th.querySelector('.filter-options');
                    if (dropdown) {
                        const sortedValues = Array.from(uniqueValues[index]).sort();
                        dropdown.innerHTML = sortedValues.map(value =>
                            `<div class="form-check">
                                <input class="form-check-input" type="checkbox" value="${value}" id="filter-${index}-${value.replace(/\s+/g, '')}">
                                <label class="form-check-label" for="filter-${index}-${value.replace(/\s+/g, '')}">${value}</label>
                             </div>`).join('');
                    }
                }
            });
        },

        applyAllFilters() {
            for (const row of tableBody.rows) {
                let isVisible = true;
                for (const key in activeFilters) {
                    const index = parseInt(key, 10);
                    const filter = activeFilters[key];
                    const content = this.getCellContent(row, index);

                    if (index === 3) {
                        const mainTopics = filter.main || [];
                        const subTopics = filter.sub || [];
                        const mainMatch = mainTopics.length === 0 || mainTopics.includes(content.main);
                        const subMatch = subTopics.length === 0 || subTopics.includes(content.sub);
                        if (!mainMatch || (mainTopics.length > 0 && !subMatch)) { isVisible = false; break; }
                    } else if (index === 5) {
                        const rowDate = new Date(content);
                        if (isNaN(rowDate)) { isVisible = false; break; }
                        const fromDate = filter.from ? new Date(filter.from) : null;
                        const toDate = filter.to ? new Date(filter.to) : null;
                        if (fromDate && rowDate < fromDate) { isVisible = false; break; }
                        if (toDate) { toDate.setHours(23, 59, 59); if (rowDate > toDate) { isVisible = false; break; } }
                    } else {
                        if (filter.length > 0 && !filter.includes(content)) { isVisible = false; break; }
                    }
                }
                row.dataset.filtered = isVisible ? 'false' : 'true';
            }
            this.updateDashboardMetrics();
            this.setupPagination();
            this.displayPage(1);
        }
    };

    window.tableManager = tableManager;

    // ===== Pagination click handling =====
    paginationControls.addEventListener('click', (e) => {
        e.preventDefault();
        const target = e.target.closest('.page-link');
        if (!target || target.parentElement.classList.contains('disabled')) return;

        const token = target.dataset.page;
        const pageCount = tableManager._pageCount();

        if (token === 'prev') {
            if (currentPage > 1) currentPage--;
        } else if (token === 'next') {
            if (currentPage < pageCount) currentPage++;
        } else {
            currentPage = parseInt(token, 10);
        }
        tableManager.setupPagination();
        tableManager.displayPage(currentPage);
    });

    // ===== Rows per page =====
    if (rowsPerPageSelect) {
        rowsPerPageSelect.addEventListener('change', (e) => {
            const value = e.target.value;
            rowsPerPage = (value === 'all') ? Infinity : parseInt(value, 10);
            tableManager.setupPagination();
            tableManager.displayPage(1);
        });
    }

    // ===== Filters UI listeners (unchanged) =====
    filterableHeaders.forEach(th => {
        const index = th.dataset.columnIndex;
        const dropdownMenu = th.querySelector('.dropdown-menu');
        const filterIcon = th.querySelector('.filter-icon');
        if (!dropdownMenu) return;

        dropdownMenu.querySelector('.apply-filter-btn')?.addEventListener('click', () => {
            if (index === '3') {
                const selectedMain = Array.from(dropdownMenu.querySelectorAll('.filter-options-main .form-check-input:checked')).map(cb => cb.value);
                const selectedSub = Array.from(dropdownMenu.querySelectorAll('.filter-options-sub .form-check-input:checked')).map(cb => cb.value);
                if (selectedMain.length > 0 || selectedSub.length > 0) {
                    activeFilters[index] = { main: selectedMain, sub: selectedSub };
                    filterIcon?.classList.add('filter-active');
                } else {
                    delete activeFilters[index];
                    filterIcon?.classList.remove('filter-active');
                }
            } else if (index === '5') {
                const from = dropdownMenu.querySelector('.date-range-from')?.value;
                const to = dropdownMenu.querySelector('.date-range-to')?.value;
                if (from || to) {
                    activeFilters[index] = { from, to };
                    filterIcon?.classList.add('filter-active');
                } else {
                    delete activeFilters[index];
                    filterIcon?.classList.remove('filter-active');
                }
            } else {
                const selected = Array.from(dropdownMenu.querySelectorAll('.filter-options .form-check-input:checked')).map(cb => cb.value);
                if (selected.length > 0) {
                    activeFilters[index] = selected;
                    filterIcon?.classList.add('filter-active');
                } else {
                    delete activeFilters[index];
                    filterIcon?.classList.remove('filter-active');
                }
            }
            tableManager.applyAllFilters();
            if (filterIcon) bootstrap.Dropdown.getInstance(filterIcon)?.hide();
        });

        dropdownMenu.querySelector('.reset-filter-btn')?.addEventListener('click', () => {
            delete activeFilters[index];
            if (index === '3') {
                dropdownMenu.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                dropdownMenu.querySelectorAll('input[type="search"]').forEach(input => input.value = '');
                tableManager.updateSubTopicFilter();
            } else if (index === '5') {
                dropdownMenu.querySelector('.date-range-from')?._flatpickr?.clear();
                dropdownMenu.querySelector('.date-range-to')?._flatpickr?.clear();
            } else {
                dropdownMenu.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                const searchInput = dropdownMenu.querySelector('.filter-search');
                if (searchInput) searchInput.value = '';
            }
            filterIcon?.classList.remove('filter-active');
            dropdownMenu.querySelectorAll('.filter-search').forEach(input => input.dispatchEvent(new Event('input')));
            tableManager.applyAllFilters();
            if (filterIcon) bootstrap.Dropdown.getInstance(filterIcon)?.hide();
        });

        dropdownMenu.querySelectorAll('.filter-search, .filter-search-main, .filter-search-sub').forEach(searchInput => {
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                let container = e.target.closest('div').nextElementSibling;
                container?.querySelectorAll('.form-check').forEach(item => {
                    const text = item.querySelector('label')?.textContent?.toLowerCase() || '';
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });
        });
    });

    // ===== CSV (unchanged) =====
    function getCleanCellText(cell) { if (!cell) return ''; return cell.textContent.trim().replace(/\s\s+/g, ' '); }
    function downloadAsCSV(filename, headers, data) {
        const csvString = [headers.join(','), ...data.map(row => row.map(val => `"${('' + val).replace(/"/g, '""')}"`).join(','))].join('\n');
        const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
    document.getElementById('download-csv-btn')?.addEventListener('click', () => {
        const headers = ['#', 'Status', 'Mode', 'Training Topic', 'Sub Topic', 'Trainer', 'Date', 'Participants', 'Training Sheet Link'];
        const rows = [];
        tableBody.querySelectorAll('tr').forEach(row => {
            if (row.dataset.filtered !== 'true') {
                const rowData = [];
                rowData.push(
                    getCleanCellText(row.cells[0]),
                    getCleanCellText(row.cells[1]),
                    getCleanCellText(row.cells[2]),
                    getCleanCellText(row.cells[3]?.querySelector('strong')),
                    getCleanCellText(row.cells[3]?.querySelector('div')),
                    getCleanCellText(row.cells[4]),
                    getCleanCellText(row.cells[5]?.querySelector('small'))
                );
                const present = row.cells[6]?.querySelector('.bg-success')?.textContent || '0';
                const absent = row.cells[6]?.querySelector('.bg-danger')?.textContent || '0';
                rowData.push(`Present: ${present}, Absent: ${absent}`);
                const viewLink = row.cells[8]?.querySelector('a.btn-outline-secondary');
                rowData.push(viewLink ? viewLink.href : getCleanCellText(row.cells[8]));
                rows.push(rowData);
            }
        });
        downloadAsCSV('training_data.csv', headers, rows);
    });

    document.getElementById('refresh-table-btn')?.addEventListener('click', (e) => {
        const btn = e.currentTarget;
        const icon = btn.querySelector('i');
        icon?.classList.add('fa-spin');
        btn.disabled = true;
        setTimeout(() => {
            tableManager.populateFilters();
            tableManager.applyAllFilters();
            icon?.classList.remove('fa-spin');
            btn.disabled = false;
        }, 500);
    });

    // ===== Date pickers =====
    if (window.flatpickr) {
        flatpickr(".date-range-from", { dateFormat: "Y-m-d" });
        flatpickr(".date-range-to", { dateFormat: "Y-m-d" });
    }

    // ===== Initial render =====
    tableManager.populateFilters();
    tableManager.applyAllFilters();
    tableManager.setupPagination();
    tableManager.displayPage(1);
});
</script>

    

    <!-- JavaScript for Participant Management Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let masterEmployeeList = [ { id: '151-001122', name: 'Jatan Singh', initials: 'JS', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'jatan.s@example.com', phone: '9876543220', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-03-01', born: '1999-01-01' }, { id: '151-002246', name: 'Ganesh Yadav', initials: 'GY', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'ganesh.y@example.com', phone: '9876543215', department: 'Engineering', role: 'Supervisor', category: 'Staff', foodHandler: 'Yes', joined: '2023-07-01', born: '1970-01-01' }, { id: '151-005767', name: 'Prateek Jain', initials: 'PJ', corporate: 'Global Hotels Inc.', regional: 'North America', unit: 'New York Central', gender: 'Male', email: 'prateek.j@example.com', phone: '9876543210', department: 'Engineering', role: 'Engineer', category: 'Executive', foodHandler: 'No', joined: '2022-12-15', born: '1988-03-10' }, { id: '151-008912', name: 'Priya Sharma', initials: 'PS', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Paris Charm', gender: 'Female', email: 'priya.s@example.com', phone: '9876543211', department: 'Front Office', role: 'Manager', category: 'Executive', foodHandler: 'No', joined: '2023-02-20', born: '1995-11-25' }, { id: '151-003456', name: 'Rohan Mehra', initials: 'RM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'rohan.m@example.com', phone: '9876543212', department: 'F&B Service', role: 'Captain', category: 'Staff', foodHandler: 'Yes', joined: '2021-08-01', born: '1992-07-14' }, { id: '151-009123', name: 'Anjali Verma', initials: 'AV', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Rome Boutique', gender: 'Female', email: 'anjali.v@example.com', phone: '9876543213', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-01-05', born: '1998-01-30' }, { id: '151-007788', name: 'Siddhi Mehta', initials: 'SM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Corporate HQ', gender: 'Female', email: 'siddhi@example.com', phone: '9876543214', department: 'Sales', role: 'Asst Manager', category: 'Executive', foodHandler: 'No', joined: '2020-05-18', born: '1990-09-03' }, ];
            let trainingParticipantData = { '489': { roster: ['151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912'], statuses: { '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present' } }, '490': { roster: ['151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122'], statuses: { '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'absent', '151-007788': 'absent', '151-001122': 'absent' } }, '492': { roster: Array(26).fill(0).map((_,i) => masterEmployeeList[i % masterEmployeeList.length].id), statuses: {'151-001122': 'absent'} } };

            let currentTrainingId = null; let rosterEmployeeIds = []; let selectedForAddition = []; let selectedInTableIds = [];
            const tableBody = document.getElementById('employee-table-body'); const selectAllTableCheckbox = document.getElementById('select-all-table-checkbox'); const markPresentBtn = document.getElementById('mark-present-btn'); const markAbsentBtn = document.getElementById('mark-absent-btn'); const mainSubmitBtn = document.getElementById('main-submit-btn'); const searchInput = document.getElementById('employee-search-input1'); const resultsContainer = document.getElementById('search-results-container'); const searchActionsContainer = document.getElementById('search-actions-container'); const resultsList = document.getElementById('search-results-list'); const selectionPreviewContainer = document.getElementById('selected-for-addition-preview'); const selectAllCheckbox = document.getElementById('select-all-checkbox'); const bulkAddBtn = document.getElementById('bulk-add-btn'); const addNewEmployeeBtn = document.getElementById('add-new-employee-btn'); const addEmployeeModal = document.getElementById('add-employee-modal'); const addEmployeeForm = document.getElementById('add-employee-form'); const manageParticipantsModalBody = document.querySelector('.manage-participants-modal-body'); const rosterCountsEl = document.getElementById('roster-counts');
            
            // *** FIX: Jaro-Winkler function restored ***
            function jaroWinkler(s1, s2) { let m = 0; if (s1.length === 0 || s2.length === 0) return 0; if (s1 === s2) return 1; let range = Math.floor(Math.max(s1.length, s2.length) / 2) - 1, s1Matches = new Array(s1.length), s2Matches = new Array(s2.length); for (let i = 0; i < s1.length; i++) { let low = (i >= range) ? i - range : 0, high = (i + range <= s2.length - 1) ? i + range : s2.length - 1; for (let j = low; j <= high; j++) { if (!s2Matches[j] && s1[i] === s2[j]) { s1Matches[i] = true; s2Matches[j] = true; m++; break; } } } if (m === 0) return 0; let k = 0, t = 0; for (let i = 0; i < s1.length; i++) { if (s1Matches[i]) { while (!s2Matches[k]) k++; if (s1[i] !== s2[k]) t++; k++; } } t /= 2; let jaro = ((m / s1.length) + (m / s2.length) + ((m - t) / m)) / 3; let p = 0.1, l = 0; if (jaro > 0.7) { while (s1[l] === s2[l] && l < 4) l++; jaro = jaro + l * p * (1 - jaro); } return jaro; }

            function updateRosterCounts() { let present = 0, absent = 0, neutral = 0; rosterEmployeeIds.forEach(id => { const data = trainingParticipantData[currentTrainingId]; if (data) { switch (data.statuses[id]) { case 'present': present++; break; case 'absent': absent++; break; default: neutral++; } } }); rosterCountsEl.innerHTML = `<span class="badge bg-success">Present: ${present}</span><span class="badge bg-danger">Absent: ${absent}</span><span class="badge bg-secondary">Neutral: ${neutral}</span>`; }
            function renderTable() { if(!tableBody) return; const currentData = trainingParticipantData[currentTrainingId]; const sortedRoster = rosterEmployeeIds.map(id => { const emp = masterEmployeeList.find(e => e.id === id); if (emp) { return { ...emp, status: currentData.statuses[id] || 'neutral' }; } return null; }).filter(Boolean).sort((a, b) => a.name.localeCompare(b.name)); tableBody.innerHTML = sortedRoster.map(emp => { const isSelected = selectedInTableIds.includes(emp.id); const statusSliderHTML = `<div class="status-slider-container status-${emp.status}"><div class="status-slider-track"><div class="status-slider-label" data-value="absent">Absent</div><div class="status-slider-label" data-value="neutral">Neutral</div><div class="status-slider-label" data-value="present">Present</div><div class="status-slider-thumb"></div></div></div>`; return `<tr data-employee-id="${emp.id}"><td><input type="checkbox" class="row-checkbox" ${isSelected ? 'checked' : ''}></td><td><div class="employee-cell"><div class="avatar">${emp.initials}</div><div><span class="name">${emp.name}</span><div class="corporate-details"><span>${emp.corporate||''}</span><span>${emp.regional||''}</span><span>${emp.unit||''}</span></div></div></div></td><td><div class="cell-stack"><div class="sub-label"><i class="fa-solid fa-envelope"></i> ${emp.email}</div><div class="sub-label"><i class="fa-solid fa-phone"></i> ${emp.phone}</div></div></td><td><div class="cell-stack"><div class="label">${emp.department}</div><div class="sub-label">${emp.role}</div></div></td><td><div class="cell-stack"><div class="label">${emp.category}</div><div class="sub-label">Food Handler: ${emp.foodHandler}</div></div></td><td>${statusSliderHTML}</td><td class="action-cell"><i class="fas fa-trash-alt icon" title="Remove from Roster" style="cursor:pointer; color: var(--danger-color);"></i></td></tr>`; }).join(''); updateBulkActionButtons(); updateSelectAllTableCheckboxState(); updateRosterCounts(); }
            function updateBulkActionButtons() { const hasSelection = selectedInTableIds.length > 0; markPresentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; markAbsentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; }
            function updateSelectAllTableCheckboxState() { if(!selectAllTableCheckbox || !tableBody) return; const rows = tableBody.querySelectorAll('tr'); if (rows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const allSelected = rows.length > 0 && rows.length === selectedInTableIds.length; selectAllTableCheckbox.checked = allSelected; selectAllTableCheckbox.indeterminate = selectedInTableIds.length > 0 && !allSelected; }
            function bulkUpdateStatus(newStatus) { selectedInTableIds.forEach(id => { trainingParticipantData[currentTrainingId].statuses[id] = newStatus; }); selectedInTableIds = []; renderTable(); }
            
            const manageParticipantsModalEl = document.getElementById('manageParticipantsModal');
            manageParticipantsModalEl.addEventListener('show.bs.modal', function(event) { currentTrainingId = event.relatedTarget.dataset.trainingId; if (!trainingParticipantData[currentTrainingId]) { trainingParticipantData[currentTrainingId] = { roster: [], statuses: {} }; } rosterEmployeeIds = [...trainingParticipantData[currentTrainingId].roster]; selectedInTableIds = []; selectedForAddition = []; renderTable(); });
            if(tableBody) tableBody.addEventListener('click', (e) => { const row = e.target.closest('tr[data-employee-id]'); if (!row) return; const employeeId = row.dataset.employeeId; if (e.target.classList.contains('row-checkbox')) { if (e.target.checked) { if (!selectedInTableIds.includes(employeeId)) selectedInTableIds.push(employeeId); } else { selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); } updateBulkActionButtons(); updateSelectAllTableCheckboxState(); } else if (e.target.closest('.fa-trash-alt')) { if (confirm(`Remove ${row.querySelector('.name').textContent.trim()} from this training?`)) { rosterEmployeeIds = rosterEmployeeIds.filter(id => id !== employeeId); delete trainingParticipantData[currentTrainingId].statuses[employeeId]; selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); renderTable(); } } const sliderLabel = e.target.closest('.status-slider-label'); if (sliderLabel) { const newStatus = sliderLabel.dataset.value; if (trainingParticipantData[currentTrainingId].statuses[employeeId] !== newStatus) { trainingParticipantData[currentTrainingId].statuses[employeeId] = newStatus; renderTable(); } } });
            if(markPresentBtn) markPresentBtn.addEventListener('click', () => bulkUpdateStatus('present'));
            if(markAbsentBtn) markAbsentBtn.addEventListener('click', () => bulkUpdateStatus('absent'));
            if(mainSubmitBtn) mainSubmitBtn.addEventListener('click', () => { if (!currentTrainingId) return; trainingParticipantData[currentTrainingId].roster = rosterEmployeeIds; let presentCount = 0, absentCount = 0; Object.values(trainingParticipantData[currentTrainingId].statuses).forEach(status => { if (status === 'present') presentCount++; if (status === 'absent') absentCount++; }); const mainTableRow = document.querySelector(`button[data-training-id="${currentTrainingId}"]`)?.closest('tr'); if(mainTableRow) { mainTableRow.querySelector('.badge.bg-success').textContent = presentCount; mainTableRow.querySelector('.badge.bg-danger').textContent = absentCount; } window.tableManager.updateDashboardMetrics(); bootstrap.Modal.getInstance(manageParticipantsModalEl).hide(); });

            // File Upload and Review Logic (RESTORED & FIXED)
            const uploadFileBtn = document.getElementById('upload-file-btn'); const uploadFileModalEl = document.getElementById('uploadFileModal'); const uploadFileModal = new bootstrap.Modal(uploadFileModalEl, { keyboard: false }); const fileUploadStep = document.getElementById('upload-file-step'); const pdfLoadingStep = document.getElementById('pdf-loading-step'); const pdfReviewStep = document.getElementById('pdf-review-step'); const fileUploadInput = document.getElementById('file-upload-input'); const handwritingOptionWrapper = document.getElementById('handwriting-option-wrapper'); const detectHandwritingCheckbox = document.getElementById('detect-handwriting-checkbox'); const extractTableBtn = document.getElementById('extract-table-btn'); const pdfBackBtn = document.getElementById('pdf-back-btn'); const importParticipantsBtn = document.getElementById('import-participants-btn'); const loadingText = document.getElementById('loading-text'); const mapIdSelect = document.getElementById('map-id-select'); const mapNameSelect = document.getElementById('map-name-select'); const mapDepartmentSelect = document.getElementById('map-department-select'); const reviewThead = document.getElementById('pdf-review-thead'); const reviewTbody = document.getElementById('pdf-review-tbody'); let simulatedExtractedData = [];
            function showFileUploadStep(step) { fileUploadStep.style.display = 'none'; pdfLoadingStep.style.display = 'none'; pdfReviewStep.style.display = 'none'; if (step === 'upload') fileUploadStep.style.display = 'block'; if (step === 'loading') pdfLoadingStep.style.display = 'block'; if (step === 'review') pdfReviewStep.style.display = 'block'; }
            uploadFileModalEl.addEventListener('hidden.bs.modal', () => { showFileUploadStep('upload'); fileUploadInput.value = ''; handwritingOptionWrapper.style.display = 'none'; detectHandwritingCheckbox.checked = false; if(extractTableBtn) extractTableBtn.disabled = true; });
            if (uploadFileBtn) { uploadFileBtn.addEventListener('click', () => { showFileUploadStep('upload'); uploadFileModal.show(); }); }
            if (fileUploadInput) { fileUploadInput.addEventListener('change', () => { extractTableBtn.disabled = !fileUploadInput.files.length; if(fileUploadInput.files.length > 0) { const fileExtension = fileUploadInput.files[0].name.split('.').pop().toLowerCase(); handwritingOptionWrapper.style.display = fileExtension === 'pdf' ? 'block' : 'none'; } else { handwritingOptionWrapper.style.display = 'none'; } }); }
            if (extractTableBtn) { extractTableBtn.addEventListener('click', () => { const file = fileUploadInput.files[0]; if (!file) return; const fileExtension = file.name.split('.').pop().toLowerCase(); showFileUploadStep('loading'); if (fileExtension === 'csv') { loadingText.textContent = "Parsing CSV file..."; const reader = new FileReader(); reader.onload = (e) => { const text = e.target.result; const rows = text.split('\n').filter(row => row.trim() !== ''); const headers = rows.shift().split(',').map(h => h.trim().replace(/"/g, '')); const headerMap = { "Unit Name": "Department", "ID Number": "Sr. No", "Employee Name": "Participant Name" }; const internalHeaders = headers.map(h => headerMap[h] || h); simulatedExtractedData = rows.map(row => { const values = row.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g).map(v => v.trim().replace(/"/g, '')); let obj = {}; headers.forEach((header, index) => { obj[headerMap[header] || header] = values[index]; }); return obj; }); populateReviewUI(internalHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }; reader.readAsText(file); } else if (fileExtension === 'pdf') { const detectHandwriting = detectHandwritingCheckbox.checked; loadingText.textContent = detectHandwriting ? "Analyzing document layout and performing OCR/HCR..." : "Analyzing PDF..."; setTimeout(() => { const baseData = [ { "Sr. No": "151-001122", "Participant Name": "Jatan Singh", "Department": "Housekeeping", "Designation": "Associate" }, { "Sr. No": "151-002246", "Participant Name": "Ganesh Y.", "Department": "Engineering", "Designation": "Supervisor" }, { "Sr. No": "999-12345", "Participant Name": "Joy Guha Roy", "Department": "Kitchen", "Designation": "Commis Chef" } ]; const pdfHeaders = ["Sr. No", "Participant Name", "Department", "Designation"]; simulatedExtractedData = detectHandwriting ? JSON.parse(JSON.stringify(baseData)).map(row => { /* ... handwritten logic ... */ return row; }) : JSON.parse(JSON.stringify(baseData)); populateReviewUI(pdfHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }, detectHandwriting ? 2500 : 1000); } }); }
            function populateReviewUI(headers, autoSelect) { const optionsHtml = headers.map(h => `<option value="${h}">${h}</option>`).join(''); mapIdSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapNameSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapDepartmentSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapIdSelect.value = autoSelect.id; mapNameSelect.value = autoSelect.name; mapDepartmentSelect.value = autoSelect.dept; reviewThead.innerHTML = `<tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>`; reviewTbody.innerHTML = simulatedExtractedData.map(row => `<tr>${headers.map(h => `<td class="${row.handwritten && row.handwritten[h] ? 'handwritten-text' : ''}">${row[h] !== undefined ? row[h] : ''}</td>`).join('')}</tr>`).join(''); showFileUploadStep('review'); }
            if (pdfBackBtn) { pdfBackBtn.addEventListener('click', () => { showFileUploadStep('upload'); }); }
            if (importParticipantsBtn) { importParticipantsBtn.addEventListener('click', () => { const idCol = mapIdSelect.value, nameCol = mapNameSelect.value, deptCol = mapDepartmentSelect.value; if (!nameCol) { alert('Please map the Full Name column.'); return; } const reviewSection = document.getElementById('pdf-review-section'); const reviewTbody = document.getElementById('reviewed-participants-tbody'); reviewTbody.innerHTML = ''; simulatedExtractedData.forEach(rowData => { const importedName = rowData[nameCol] || '', importedId = rowData[idCol] || '', importedDept = rowData[deptCol] || '', importedRole = rowData['Designation'] || ''; const initials = importedName.split(' ').map(n=>n[0]).join('').toUpperCase(); let matches = []; const idMatch = masterEmployeeList.find(e=>e.id===importedId); if (idMatch){ matches.push({employee:idMatch, score:1, isIdMatch:true}); } else if(importedName) { matches = masterEmployeeList.map(emp => ({employee:emp, score: jaroWinkler(importedName.toLowerCase(), emp.name.toLowerCase()), isIdMatch:false})).filter(m=>m.score > 0.8).sort((a,b)=>b.score - a.score).slice(0,3); } const popoverContent = (emp) => `<strong>ID:</strong> ${emp.id}<br><strong>Unit:</strong> ${emp.unit || 'N/A'}`; let suggestionsHTML = matches.length > 0 ? matches.map(m => `<a href="#" class="suggestion-link" data-employee='${JSON.stringify(m.employee)}' data-bs-toggle="popover" data-bs-trigger="hover" title="DB Record: ${m.employee.name}" data-bs-content="${popoverContent(m.employee)}"><i class="fas ${m.isIdMatch ? 'fa-id-badge text-success' : 'fa-user text-primary'} me-2"></i> ${m.employee.name} <span class="badge ${m.isIdMatch ? 'bg-success' : 'bg-primary'} float-end">${m.isIdMatch ? 'ID Match' : (m.score * 100).toFixed(0) + '%'}</span></a>`).join('') : '<div class="no-suggestions">No matches in DB.</div>'; const actionsHTML = `<button class="btn btn-sm btn-outline-success add-reviewed-participant-btn" title="Add to Roster"><i class="fas fa-check"></i></button> ${matches.length === 0 ? `<button class="btn btn-sm btn-outline-primary add-manual-btn" title="Add as new employee"><i class="fas fa-user-plus"></i></button>` : ''} <button class="btn btn-sm btn-outline-danger discard-reviewed-participant-btn" title="Discard row"><i class="fas fa-trash"></i></button>`; const tr = document.createElement('tr'); tr.innerHTML = `<td><div class="employee-cell imported-info"><div class="avatar">${initials}</div><div class="employee-info w-100"><div class="name"><span contenteditable="true" class="imported-name-cell">${importedName}</span><span class="badge bg-success ms-2 matched-indicator" style="display:none;">Matched</span></div><div class="imported-details"><div><small>ID:</small><span contenteditable="true" class="editable-id">${importedId}</span></div><div><small>Dept:</small><span contenteditable="true" class="editable-dept">${importedDept}</span></div><div><small>Role:</small><span contenteditable="true" class="editable-role">${importedRole}</span></div></div></div></div></td><td><div class="suggestions-container"><h6>Potential Matches</h6>${suggestionsHTML}</div></td><td class="action-cell">${actionsHTML}</td>`; reviewTbody.appendChild(tr); }); new bootstrap.Popover(reviewTbody, { selector: '[data-bs-toggle="popover"]', container: 'body', trigger: 'hover focus', html: true }); reviewSection.style.display = 'block'; uploadFileModal.hide(); }); }
            function addParticipantToRoster(data) { if (!data.id && !data.name) return; if (!data.id) data.id = `NEW-${Date.now().toString().slice(-6)}`; if (rosterEmployeeIds.includes(data.id)) return; if (!masterEmployeeList.some(emp => emp.id === data.id)) { masterEmployeeList.push({ id: data.id, name: data.name, initials: data.name.split(' ').map(n => n[0]).join('').toUpperCase(), department: data.department, role: data.role, status: 'neutral' }); } rosterEmployeeIds.push(data.id); trainingParticipantData[currentTrainingId].statuses[data.id] = 'neutral'; renderTable(); }
            if(manageParticipantsModalBody) { manageParticipantsModalBody.addEventListener('click', e => { const targetBtn = e.target.closest('a, button'); if (!targetBtn) return; e.preventDefault(); const reviewTbody = document.getElementById('reviewed-participants-tbody'); if (targetBtn.matches('.suggestion-link')) { const tr = targetBtn.closest('tr'); const employeeData = JSON.parse(targetBtn.dataset.employee); tr.querySelector('.editable-id').textContent = employeeData.id; tr.querySelector('.imported-name-cell').textContent = employeeData.name; tr.querySelector('.editable-dept').textContent = employeeData.department; tr.querySelector('.editable-role').textContent = employeeData.role; tr.querySelector('.matched-indicator').style.display = 'inline-block'; } if (targetBtn.matches('.add-manual-btn')) { const tr = targetBtn.closest('tr'); addEmployeeModal.dataset.sourceRowIndex = tr.rowIndex - 1; addEmployeeForm.reset(); document.getElementById('add-employee-form-container').querySelector('h2').textContent = "Add New User from Import"; document.getElementById('full-name').value = tr.querySelector('.imported-name-cell').textContent.trim(); document.getElementById('employee-id').value = tr.querySelector('.editable-id').textContent.trim(); document.getElementById('department').value = tr.querySelector('.editable-dept').textContent.trim(); document.getElementById('designation').value = tr.querySelector('.editable-role').textContent.trim(); addEmployeeModal.classList.add('visible'); } if (targetBtn.matches('.add-reviewed-participant-btn')) { const tr = targetBtn.closest('tr'); const employeeName = tr.querySelector('.imported-name-cell').textContent.trim(); if (!employeeName) { alert('Participant Name cannot be empty.'); return; } addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: employeeName, department: tr.querySelector('.editable-dept').textContent.trim(), role: tr.querySelector('.editable-role').textContent.trim() }); tr.remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.matches('.discard-reviewed-participant-btn')) { targetBtn.closest('tr').remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.id === 'add-all-reviewed-btn') { if (confirm(`Add all ${reviewTbody.rows.length} participants?`)) { [...reviewTbody.rows].forEach(tr => { addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: tr.querySelector('.imported-name-cell').textContent.trim(), department: tr.querySelector('.editable-dept').textContent.trim(), role: tr.querySelector('.editable-role').textContent.trim() }); }); reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } if (targetBtn.id === 'discard-all-reviewed-btn') { if (confirm('Discard all imported participants?')) { reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } }); }

            // Other general initializations
            initAddEmployeeForm();
        });
    </script>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
            let masterEmployeeList = [ { id: '151-002246', name: 'Ganesh Yadav', initials: 'GY', corporate: 'Global Tech Inc.', regional: 'North America', unit: 'Innovation Hub', gender: 'Male', email: 'e@gmail.com', phone: '982749832', department: 'Food Production', role: 'Top Management', category: 'Apprentice', foodHandler: 'Yes', joined: '2023-07-01', born: '1970-01-01' }, { id: '151-001122', name: 'Jatan Singh', initials: 'JS', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'jatan.s@example.com', phone: '9876543220', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-03-01', born: '1999-01-01' }, { id: '151-005767', name: 'Prateek Jain', initials: 'PJ', corporate: 'Global Hotels Inc.', regional: 'North America', unit: 'New York Central', gender: 'Male', email: 'prateek.j@example.com', phone: '9876543210', department: 'Engineering', role: 'Engineer', category: 'Executive', foodHandler: 'No', joined: '2022-12-15', born: '1988-03-10' }, { id: '151-008912', name: 'Priya Sharma', initials: 'PS', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Paris Charm', gender: 'Female', email: 'priya.s@example.com', phone: '9876543211', department: 'Front Office', role: 'Manager', category: 'Executive', foodHandler: 'No', joined: '2023-02-20', born: '1995-11-25' }, { id: '151-003456', name: 'Rohan Mehra', initials: 'RM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'rohan.m@example.com', phone: '9876543212', department: 'F&B Service', role: 'Captain', category: 'Staff', foodHandler: 'Yes', joined: '2021-08-01', born: '1992-07-14' }, { id: '151-009123', name: 'Anjali Verma', initials: 'AV', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Rome Boutique', gender: 'Female', email: 'anjali.v@example.com', phone: '9876543213', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-01-05', born: '1998-01-30' }, { id: '151-007788', name: 'Siddhi Mehta', initials: 'SM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Corporate HQ', gender: 'Female', email: 'siddhi@example.com', phone: '9876543214', department: 'Sales', role: 'Asst Manager', category: 'Executive', foodHandler: 'No', joined: '2020-05-18', born: '1990-09-03' }, ];
            let trainingParticipantData = { '489': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present' } }, '490': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'absent', '151-007788': 'absent', '151-001122': 'absent' } }, '492': { roster: Array(26).fill(0).map((_,i) => masterEmployeeList[i % masterEmployeeList.length].id), statuses: {'151-001122': 'absent'} } };
            const allDepartments = ["Food Production", "Engineering", "Sales", "Front Office", "Housekeeping", "F&B Service", "HR", "Kitchen"];
            const allRoles = ["Top Management", "Associate", "Engineer", "Manager", "Captain", "Supervisor", "Asst Manager", "Commis Chef", "Technician"];
            
            const orgData = {
                "Global Tech Inc.": {
                    "North America": {
                        "Innovation Hub": ["Food Production", "Engineering", "Sales"],
                        "New York Central": ["Front Office", "Engineering", "Sales"]
                    }
                },
                "Global Hotels Inc.": {
                    "Asia-Pacific": {
                        "Mumbai Grand": ["Housekeeping", "F&B Service", "Engineering", "Front Office"],
                        "Corporate HQ": ["Sales", "HR"]
                    }
                },
                "Boutique Stays LLC": {
                    "Europe": {
                        "Paris Charm": ["Front Office", "Housekeeping"],
                        "Rome Boutique": ["Housekeeping"]
                    }
                }
            };


            let currentTrainingId = null; let rosterEmployeeIds = []; let selectedForAddition = []; let selectedInTableIds = [];
            const tableBody = document.getElementById('employee-table-body'); const selectAllTableCheckbox = document.getElementById('select-all-table-checkbox'); const markPresentBtn = document.getElementById('mark-present-btn'); const markAbsentBtn = document.getElementById('mark-absent-btn'); const mainSubmitBtn = document.getElementById('main-submit-btn');
            const manageParticipantsModalBody = document.querySelector('.manage-participants-modal-body'); const rosterCountsEl = document.getElementById('roster-counts');
            
            const searchInput = document.getElementById('employee-search-input1');
            const resultsContainer = document.getElementById('search-results-container');
            const resultsList = document.getElementById('search-results-list');
            const selectionPreviewContainer = document.getElementById('selected-for-addition-preview');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const bulkAddBtn = document.getElementById('bulk-add-btn');
            let currentSearchResults = [];
            
            // Add/Edit Employee Modal elements
            const addNewEmployeeBtn = document.getElementById('add-new-employee-btn');
            const addEmployeeModal = document.getElementById('add-employee-modal');
            const addEmployeeFormContainer = document.getElementById('add-employee-form-container');
            const addEmployeeForm = document.getElementById('add-employee-form');
            const modalCloseBtn = addEmployeeFormContainer.querySelector('.close-btn');
            const modalCancelBtn = document.getElementById('modal-cancel-btn');


            function jaroWinkler(s1, s2) { let m = 0; if (s1.length === 0 || s2.length === 0) return 0; if (s1 === s2) return 1; let range = Math.floor(Math.max(s1.length, s2.length) / 2) - 1, s1Matches = new Array(s1.length), s2Matches = new Array(s2.length); for (let i = 0; i < s1.length; i++) { let low = (i >= range) ? i - range : 0, high = (i + range <= s2.length - 1) ? i + range : s2.length - 1; for (let j = low; j <= high; j++) { if (!s2Matches[j] && s1[i] === s2[j]) { s1Matches[i] = true; s2Matches[j] = true; m++; break; } } } if (m === 0) return 0; let k = 0, t = 0; for (let i = 0; i < s1.length; i++) { if (s1Matches[i]) { while (!s2Matches[k]) k++; if (s1[i] !== s2[k]) t++; k++; } } t /= 2; let jaro = ((m / s1.length) + (m / s2.length) + ((m - t) / m)) / 3; let p = 0.1, l = 0; if (jaro > 0.7) { while (s1[l] === s2[l] && l < 4) l++; jaro = jaro + l * p * (1 - jaro); } return jaro; }

            function updateSearchUI() {
                selectionPreviewContainer.innerHTML = selectedForAddition.map(id => {
                    const emp = masterEmployeeList.find(e => e.id === id);
                    if (!emp) return '';
                    return `<span class="selected-preview-tag">${emp.name}<span class="remove-tag-btn" data-id="${id}" title="Remove">&times;</span></span>`;
                }).join('');
                bulkAddBtn.disabled = selectedForAddition.length === 0;
                bulkAddBtn.textContent = `Add Selected (${selectedForAddition.length})`;
                resultsList.innerHTML = currentSearchResults.map(emp => {
                    const isSelected = selectedForAddition.includes(emp.id);
                    return `<li data-id="${emp.id}">
                                <input type="checkbox" class="result-checkbox" data-id="${emp.id}" ${isSelected ? 'checked' : ''}>
                                <div class="w-100">
                                    <span class="result-name">${emp.name}</span>
                                    <span class="result-details">ID: ${emp.id} &bull; Dept: ${emp.department || 'N/A'}</span>
                                </div>
                            </li>`;
                }).join('');
                if (currentSearchResults.length > 0) {
                    const allVisibleSelected = currentSearchResults.every(emp => selectedForAddition.includes(emp.id));
                    selectAllCheckbox.checked = allVisibleSelected;
                } else {
                    selectAllCheckbox.checked = false;
                }
            }
            
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                if (searchTerm.length > 0) {
                    currentSearchResults = masterEmployeeList.filter(emp =>
                        !rosterEmployeeIds.includes(emp.id) &&
                        (emp.name.toLowerCase().includes(searchTerm) || emp.id.toLowerCase().includes(searchTerm))
                    );
                    if (currentSearchResults.length === 0) {
                        resultsList.innerHTML = `<li class="no-results">No employees found.</li>`;
                    }
                } else {
                    currentSearchResults = [];
                    resultsList.innerHTML = `<li class="no-results">Type to search for employees.</li>`;
                }
                updateSearchUI();
            }
            
            if (searchInput) {
                searchInput.addEventListener('input', performSearch);
                searchInput.addEventListener('focus', () => {
                    resultsContainer.classList.add('visible');
                    performSearch();
                });
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.search-add-wrapper')) {
                        resultsContainer.classList.remove('visible');
                    }
                });
                resultsContainer.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const empId = e.target.closest('li[data-id]')?.dataset.id;
                    if (empId) {
                        if (selectedForAddition.includes(empId)) {
                            selectedForAddition = selectedForAddition.filter(id => id !== empId);
                        } else {
                            selectedForAddition.push(empId);
                        }
                        updateSearchUI();
                    }
                    if(e.target.matches('.remove-tag-btn')){
                        const empIdToRemove = e.target.dataset.id;
                        selectedForAddition = selectedForAddition.filter(id => id !== empIdToRemove);
                        updateSearchUI();
                    }
                });
                 selectAllCheckbox.addEventListener('change', () => {
                    const visibleIds = currentSearchResults.map(emp => emp.id);
                    if (selectAllCheckbox.checked) {
                        visibleIds.forEach(id => {
                            if (!selectedForAddition.includes(id)) {
                                selectedForAddition.push(id);
                            }
                        });
                    } else {
                        selectedForAddition = selectedForAddition.filter(id => !visibleIds.includes(id));
                    }
                    updateSearchUI();
                });
                bulkAddBtn.addEventListener('click', () => {
                    selectedForAddition.forEach(id => {
                        if (!rosterEmployeeIds.includes(id)) {
                            rosterEmployeeIds.push(id);
                             if(trainingParticipantData[currentTrainingId]) {
                                trainingParticipantData[currentTrainingId].statuses[id] = 'neutral';
                            }
                        }
                    });
                    selectedForAddition = [];
                    searchInput.value = '';
                    resultsContainer.classList.remove('visible');
                    renderTable();
                });
            }

            function updateRosterCounts() { let present = 0, absent = 0, neutral = 0; rosterEmployeeIds.forEach(id => { const data = trainingParticipantData[currentTrainingId]; if (data && data.statuses) { switch (data.statuses[id]) { case 'present': present++; break; case 'absent': absent++; break; default: neutral++; } } }); rosterCountsEl.innerHTML = `<span class="badge bg-success">Present: ${present}</span><span class="badge bg-danger">Absent: ${absent}</span><span class="badge bg-secondary">Neutral: ${neutral}</span>`; }
            
            function renderTable() {
                if (!tableBody) return;
                const thead = document.querySelector('.table-wrapper thead');
                if (thead) thead.style.display = 'none';
                const currentData = trainingParticipantData[currentTrainingId];
                const sortedRoster = rosterEmployeeIds
                    .map(id => {
                        const emp = masterEmployeeList.find(e => e.id === id);
                        if (emp) {
                            return { ...emp, status: (currentData && currentData.statuses[id]) ? currentData.statuses[id] : 'neutral' };
                        }
                        return null;
                    })
                    .filter(Boolean)
                    .sort((a, b) => a.name.localeCompare(b.name));

                tableBody.innerHTML = sortedRoster.map(emp => {
                    if (!emp.updated) {
                       emp.updated = new Date(Date.now() - Math.random() * 1e10).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
                    }
                    const isSelected = selectedInTableIds.includes(emp.id);
                    const statusSliderHTML = `<div class="status-slider-container status-${emp.status || 'neutral'}" data-employee-id="${emp.id}"><div class="status-slider-track"><div class="status-slider-label" data-value="absent">Absent</div><div class="status-slider-label" data-value="neutral">Neutral</div><div class="status-slider-label" data-value="present">Present</div><div class="status-slider-thumb"></div></div></div>`;
                    const prefix = emp.gender === 'Male' ? 'Mr.' : 'Ms.';
                    const displayName = `${prefix} ${emp.name}`;
                    
                    return `
                    <tr class="employee-card-list-item" data-employee-id="${emp.id}">
                        <td class="p-0">
                            <div class="employee-card-row">
                                <div class="card-col-select">
                                    <input type="checkbox" class="row-checkbox" ${isSelected ? 'checked' : ''}>
                                </div>

                                <div class="card-col-org">
                                    <strong>${emp.corporate || 'N/A'}</strong>
                                    <span>${emp.regional || 'N/A'}</span>
                                    <span>${emp.unit || 'N/A'}</span>
                                </div>

                                <div class="card-col-main-info">
                                    <div class="avatar">${emp.initials}</div>
                                    <div>
                                        <strong>${displayName}</strong>
                                        <div class="details-grid">
                                            <span><i class="fas fa-id-card-clip"></i>ID: ${emp.id}</span>
                                            <span><i class="fas fa-user"></i>${emp.gender}</span>
                                            <span><i class="fas fa-birthday-cake"></i>Born: ${emp.born}</span>
                                            <span><i class="fas fa-calendar-alt"></i>Joined: ${emp.joined}</span>
                                            <span><i class="fas fa-clock"></i>Updated: ${emp.updated}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-col-contact">
                                    <span><i class="fas fa-envelope"></i>${emp.email}</span>
                                    <span><i class="fas fa-phone"></i>${emp.phone}</span>
                                </div>

                                <div class="card-col-role">
                                    <strong>${emp.department || 'N/A'}</strong>
                                    <span>${emp.role || 'N/A'}</span>
                                    <span>Responsibility: ${emp.department || 'N/A'}</span>
                                </div>

                                <div class="card-col-category">
                                    <strong>${emp.category || 'N/A'}</strong>
                                    <span>Food Handler: ${emp.foodHandler}</span>
                                </div>
                                
                                <div class="card-col-status">
                                     ${statusSliderHTML}
                                </div>

                                <div class="card-col-actions">
                                    <i class="fas fa-trash-alt icon" title="Remove from Roster"></i>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                }).join('');

                updateBulkActionButtons();
                updateSelectAllTableCheckboxState();
                updateRosterCounts();
            }

            function updateBulkActionButtons() { const hasSelection = selectedInTableIds.length > 0; markPresentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; markAbsentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; }
            function updateSelectAllTableCheckboxState() { if(!selectAllTableCheckbox || !tableBody) return; const rows = tableBody.querySelectorAll('tr'); if (rows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const allSelected = rows.length > 0 && rows.length === selectedInTableIds.length; selectAllTableCheckbox.checked = allSelected; selectAllTableCheckbox.indeterminate = selectedInTableIds.length > 0 && !allSelected; }
            function bulkUpdateStatus(newStatus) { selectedInTableIds.forEach(id => { trainingParticipantData[currentTrainingId].statuses[id] = newStatus; }); selectedInTableIds = []; renderTable(); }
            
            const manageParticipantsModalEl = document.getElementById('manageParticipantsModal');
            manageParticipantsModalEl.addEventListener('show.bs.modal', function(event) { currentTrainingId = event.relatedTarget.dataset.trainingId; if (!trainingParticipantData[currentTrainingId]) { trainingParticipantData[currentTrainingId] = { roster: [], statuses: {} }; } rosterEmployeeIds = [...trainingParticipantData[currentTrainingId].roster]; selectedInTableIds = []; selectedForAddition = []; renderTable(); });
            if(tableBody) tableBody.addEventListener('click', (e) => { const row = e.target.closest('tr[data-employee-id]'); if (!row) return; const employeeId = row.dataset.employeeId; if (e.target.classList.contains('row-checkbox')) { if (e.target.checked) { if (!selectedInTableIds.includes(employeeId)) selectedInTableIds.push(employeeId); } else { selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); } updateBulkActionButtons(); updateSelectAllTableCheckboxState(); } else if (e.target.closest('.fa-trash-alt')) { if (confirm(`Remove ${row.querySelector('.card-col-main-info strong').textContent.trim()} from this training?`)) { rosterEmployeeIds = rosterEmployeeIds.filter(id => id !== employeeId); delete trainingParticipantData[currentTrainingId].statuses[employeeId]; selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); renderTable(); } } const sliderLabel = e.target.closest('.status-slider-label'); if (sliderLabel) { const newStatus = sliderLabel.dataset.value; if (trainingParticipantData[currentTrainingId].statuses[employeeId] !== newStatus) { trainingParticipantData[currentTrainingId].statuses[employeeId] = newStatus; const sliderContainer = sliderLabel.closest('.status-slider-container'); sliderContainer.className = 'status-slider-container'; sliderContainer.classList.add(`status-${newStatus}`); updateRosterCounts(); } } });
            if(markPresentBtn) markPresentBtn.addEventListener('click', () => bulkUpdateStatus('present'));
            if(markAbsentBtn) markAbsentBtn.addEventListener('click', () => bulkUpdateStatus('absent'));
            if(mainSubmitBtn) mainSubmitBtn.addEventListener('click', () => { if (!currentTrainingId) return; trainingParticipantData[currentTrainingId].roster = rosterEmployeeIds; let presentCount = 0, absentCount = 0; Object.values(trainingParticipantData[currentTrainingId].statuses).forEach(status => { if (status === 'present') presentCount++; if (status === 'absent') absentCount++; }); const mainTableRow = document.querySelector(`button[data-training-id="${currentTrainingId}"]`)?.closest('tr'); if(mainTableRow) { mainTableRow.querySelector('.badge.bg-success').textContent = presentCount; mainTableRow.querySelector('.badge.bg-danger').textContent = absentCount; } window.tableManager.updateDashboardMetrics(); bootstrap.Modal.getInstance(manageParticipantsModalEl).hide(); });

            // File Upload and Review Logic 
            const uploadFileBtn = document.getElementById('upload-file-btn'); const uploadFileModalEl = document.getElementById('uploadFileModal'); const uploadFileModal = new bootstrap.Modal(uploadFileModalEl, { keyboard: false }); const fileUploadStep = document.getElementById('upload-file-step'); const pdfLoadingStep = document.getElementById('pdf-loading-step'); const pdfReviewStep = document.getElementById('pdf-review-step'); const fileUploadInput = document.getElementById('file-upload-input'); const handwritingOptionWrapper = document.getElementById('handwriting-option-wrapper'); const detectHandwritingCheckbox = document.getElementById('detect-handwriting-checkbox'); const extractTableBtn = document.getElementById('extract-table-btn'); const pdfBackBtn = document.getElementById('pdf-back-btn'); const importParticipantsBtn = document.getElementById('import-participants-btn'); const loadingText = document.getElementById('loading-text'); const mapIdSelect = document.getElementById('map-id-select'); const mapNameSelect = document.getElementById('map-name-select'); const mapDepartmentSelect = document.getElementById('map-department-select'); const reviewThead = document.getElementById('pdf-review-thead'); const reviewTbody = document.getElementById('reviewed-participants-tbody'); const downloadSampleCsvBtn = document.getElementById('download-sample-csv-btn'); let simulatedExtractedData = [];
            
            function triggerCsvDownload(csvString, filename) {
                const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                if (link.download !== undefined) {
                    const url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', filename);
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                }
            }

            if (downloadSampleCsvBtn) {
                downloadSampleCsvBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const csvHeaders = ['Sr. No', 'Participant Name', 'Department', 'Designation'];
                    const csvRows = [
                        ['151-001234', 'Amit Kumar', 'Housekeeping', 'Associate'],
                        ['151-005678', 'Sunita Sharma', 'F&B Service', 'Captain'],
                        ['151-009012', 'Rajesh Patel', 'Engineering', 'Technician']
                    ];
                    const csvContent = [
                        csvHeaders.join(','),
                        ...csvRows.map(row => row.join(','))
                    ].join('\n');
                    triggerCsvDownload(csvContent, 'sample_participants.csv');
                });
            }

            function showFileUploadStep(step) { fileUploadStep.style.display = 'none'; pdfLoadingStep.style.display = 'none'; pdfReviewStep.style.display = 'none'; if (step === 'upload') fileUploadStep.style.display = 'block'; if (step === 'loading') pdfLoadingStep.style.display = 'block'; if (step === 'review') pdfReviewStep.style.display = 'block'; }
            uploadFileModalEl.addEventListener('hidden.bs.modal', () => { showFileUploadStep('upload'); fileUploadInput.value = ''; handwritingOptionWrapper.style.display = 'none'; detectHandwritingCheckbox.checked = false; if(extractTableBtn) extractTableBtn.disabled = true; });
            if (uploadFileBtn) { uploadFileBtn.addEventListener('click', () => { showFileUploadStep('upload'); uploadFileModal.show(); }); }
            if (fileUploadInput) { fileUploadInput.addEventListener('change', () => { extractTableBtn.disabled = !fileUploadInput.files.length; if(fileUploadInput.files.length > 0) { const fileExtension = fileUploadInput.files[0].name.split('.').pop().toLowerCase(); handwritingOptionWrapper.style.display = fileExtension === 'pdf' ? 'block' : 'none'; } else { handwritingOptionWrapper.style.display = 'none'; } }); }
            if (extractTableBtn) { extractTableBtn.addEventListener('click', () => { const file = fileUploadInput.files[0]; if (!file) return; const fileExtension = file.name.split('.').pop().toLowerCase(); showFileUploadStep('loading'); if (fileExtension === 'csv') { loadingText.textContent = "Parsing CSV file..."; const reader = new FileReader(); reader.onload = (e) => { const text = e.target.result; const rows = text.split('\n').filter(row => row.trim() !== ''); const headers = rows.shift().split(',').map(h => h.trim().replace(/"/g, '')); const headerMap = { "Unit Name": "Department", "ID Number": "Sr. No", "Employee Name": "Participant Name" }; const internalHeaders = headers.map(h => headerMap[h] || h); simulatedExtractedData = rows.map(row => { const values = row.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g).map(v => v.trim().replace(/"/g, '')); let obj = {}; headers.forEach((header, index) => { obj[headerMap[header] || header] = values[index]; }); return obj; }); populateReviewUI(internalHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }; reader.readAsText(file); } else if (fileExtension === 'pdf') { const detectHandwriting = detectHandwritingCheckbox.checked; loadingText.textContent = detectHandwriting ? "Analyzing document layout and performing OCR/HCR..." : "Analyzing PDF..."; setTimeout(() => { const baseData = [ { "Sr. No": "151-001122", "Participant Name": "Jatan Singh", "Department": "Housekeeping", "Designation": "Associate" }, { "Sr. No": "151-002246", "Participant Name": "Ganesh Y.", "Department": "Engineering", "Designation": "Supervisor" }, { "Sr. No": "999-12345", "Participant Name": "Joy Guha Roy", "Department": "Kitchen", "Designation": "Commis Chef" } ]; const pdfHeaders = ["Sr. No", "Participant Name", "Department", "Designation"]; simulatedExtractedData = detectHandwriting ? JSON.parse(JSON.stringify(baseData)).map(row => { /* ... handwritten logic ... */ return row; }) : JSON.parse(JSON.stringify(baseData)); populateReviewUI(pdfHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }, detectHandwriting ? 2500 : 1000); } }); }
            function populateReviewUI(headers, autoSelect) { const optionsHtml = headers.map(h => `<option value="${h}">${h}</option>`).join(''); mapIdSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapNameSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapDepartmentSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapIdSelect.value = autoSelect.id; mapNameSelect.value = autoSelect.name; mapDepartmentSelect.value = autoSelect.dept; reviewThead.innerHTML = `<tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>`; reviewTbody.innerHTML = simulatedExtractedData.map(row => `<tr>${headers.map(h => `<td class="${row.handwritten && row.handwritten[h] ? 'handwritten-text' : ''}">${row[h] !== undefined ? row[h] : ''}</td>`).join('')}</tr>`).join(''); showFileUploadStep('review'); }
            if (pdfBackBtn) { pdfBackBtn.addEventListener('click', () => { showFileUploadStep('upload'); }); }
            if (importParticipantsBtn) { 
                importParticipantsBtn.addEventListener('click', () => { 
                    const idCol = mapIdSelect.value, nameCol = mapNameSelect.value, deptCol = mapDepartmentSelect.value, roleCol = 'Designation';
                    if (!nameCol) { alert('Please map the Full Name column.'); return; } 
                    const reviewSection = document.getElementById('pdf-review-section'); 
                    const reviewTbody = document.getElementById('reviewed-participants-tbody'); 
                    reviewTbody.innerHTML = ''; 

                    // Get a list of names currently in the roster for quick checking
                    const rosterNames = rosterEmployeeIds.map(id => masterEmployeeList.find(emp => emp.id === id)?.name.toLowerCase());

                    simulatedExtractedData.forEach(rowData => { 
                        const importedName = rowData[nameCol] || '', importedId = rowData[idCol] || '', importedDept = rowData[deptCol] || '', importedRole = rowData[roleCol] || ''; 
                        const initials = importedName.split(' ').map(n=>n[0]).join('').toUpperCase(); 
                        
                        // Check for duplicate names already in the roster
                        const isInRoster = rosterNames.some(rosterName => jaroWinkler(importedName.toLowerCase(), rosterName) > 0.9);
                        const rosterBadge = isInRoster ? `<span class="badge bg-warning ms-2">In Roster</span>` : '';

                        let matches = []; 
                        const idMatch = masterEmployeeList.find(e=>e.id===importedId); 
                        if (idMatch){ matches.push({employee:idMatch, score:1, isIdMatch:true}); } 
                        else if(importedName) { matches = masterEmployeeList.map(emp => ({employee:emp, score: jaroWinkler(importedName.toLowerCase(), emp.name.toLowerCase()), isIdMatch:false})).filter(m=>m.score > 0.8 && !rosterEmployeeIds.includes(m.employee.id)).sort((a,b)=>b.score - a.score).slice(0,3); } 
                        
                        const popoverContent = (emp) => `<strong>ID:</strong> ${emp.id}<br><strong>Unit:</strong> ${emp.unit || 'N/A'}`; 
                        let suggestionsHTML = matches.length > 0 ? matches.map(m => `<a href="#" class="suggestion-link" data-employee='${JSON.stringify(m.employee)}' data-bs-toggle="popover" data-bs-trigger="hover" title="DB Record: ${m.employee.name}" data-bs-content="${popoverContent(m.employee)}"><i class="fas ${m.isIdMatch ? 'fa-id-badge text-success' : 'fa-user text-primary'} me-2"></i> ${m.employee.name} <span class="badge ${m.isIdMatch ? 'bg-success' : 'bg-primary'} float-end">${m.isIdMatch ? 'ID Match' : (m.score * 100).toFixed(0) + '%'}</span></a>`).join('') : '<div class="no-suggestions">No matches in DB.</div>'; 
                        
                        const actionsHTML = `<button class="btn btn-sm btn-outline-success add-reviewed-participant-btn" title="Add to Roster"><i class="fas fa-check"></i></button> ${matches.length === 0 ? `<button class="btn btn-sm btn-outline-primary add-manual-btn" title="Add as new employee"><i class="fas fa-user-plus"></i></button>` : ''} <button class="btn btn-sm btn-outline-danger discard-reviewed-participant-btn" title="Discard row"><i class="fas fa-trash"></i></button>`; 
                        
                        const createSelect = (options, selectedValue) => {
                            let uniqueOptions = [...new Set([...options, selectedValue].filter(Boolean))].sort();
                            return `<select class="form-select form-select-sm">${uniqueOptions.map(opt => `<option value="${opt}" ${opt === selectedValue ? 'selected' : ''}>${opt}</option>`).join('')}</select>`;
                        };

                        const deptDropdown = createSelect(allDepartments, importedDept);
                        const roleDropdown = createSelect(allRoles, importedRole);

                        const tr = document.createElement('tr'); 
                        tr.innerHTML = `<td><div class="employee-cell imported-info"><div class="avatar">${initials}</div><div class="employee-info w-100"><div class="name"><span contenteditable="true" class="imported-name-cell">${importedName}</span><span class="badge bg-success ms-2 matched-indicator" style="display:none;">Matched</span>${rosterBadge}</div><div class="imported-details"><div><small>ID:</small><span contenteditable="true" class="editable-id">${importedId}</span></div><div><small>Dept:</small><span class="editable-dept">${deptDropdown}</span></div><div><small>Role:</small><span class="editable-role">${roleDropdown}</span></div></div></div></div></td><td><div class="suggestions-container"><h6>Potential Matches</h6>${suggestionsHTML}</div></td><td class="action-cell">${actionsHTML}</td>`; 
                        reviewTbody.appendChild(tr); 
                    }); 
                    new bootstrap.Popover(reviewTbody, { selector: '[data-bs-toggle="popover"]', container: 'body', trigger: 'hover focus', html: true }); 
                    reviewSection.style.display = 'block'; 
                    uploadFileModal.hide(); 
                }); 
            }
            function addParticipantToRoster(data) { if (!data.id && !data.name) return; if (!data.id) data.id = `NEW-${Date.now().toString().slice(-6)}`; if (rosterEmployeeIds.includes(data.id)) return; if (!masterEmployeeList.some(emp => emp.id === data.id)) { masterEmployeeList.push({ id: data.id, name: data.name, initials: data.name.split(' ').map(n => n[0]).join('').toUpperCase(), department: data.department, role: data.role, status: 'neutral' }); } rosterEmployeeIds.push(data.id); trainingParticipantData[currentTrainingId].statuses[data.id] = 'neutral'; renderTable(); }
            if(manageParticipantsModalBody) { manageParticipantsModalBody.addEventListener('click', e => { const targetBtn = e.target.closest('a, button'); if (!targetBtn) return; e.preventDefault(); const reviewTbody = document.getElementById('reviewed-participants-tbody'); if (targetBtn.matches('.suggestion-link')) { const tr = targetBtn.closest('tr'); const employeeData = JSON.parse(targetBtn.dataset.employee); tr.querySelector('.editable-id').textContent = employeeData.id; tr.querySelector('.imported-name-cell').textContent = employeeData.name; tr.querySelector('.editable-dept select').value = employeeData.department || ''; tr.querySelector('.editable-role select').value = employeeData.role || ''; tr.querySelector('.matched-indicator').style.display = 'inline-block'; } if (targetBtn.matches('.add-manual-btn')) { const tr = targetBtn.closest('tr'); addEmployeeModal.dataset.sourceRowIndex = Array.from(reviewTbody.children).indexOf(tr); addEmployeeForm.reset(); document.getElementById('add-employee-form-container').querySelector('h2').textContent = "Add New User from Import"; document.getElementById('full-name').value = tr.querySelector('.imported-name-cell').textContent.trim(); document.getElementById('employee-id').value = tr.querySelector('.editable-id').textContent.trim(); document.getElementById('department-select').value = tr.querySelector('.editable-dept select').value; document.getElementById('designation').value = tr.querySelector('.editable-role select').value; addEmployeeModal.classList.add('visible'); } if (targetBtn.matches('.add-reviewed-participant-btn')) { const tr = targetBtn.closest('tr'); const employeeName = tr.querySelector('.imported-name-cell').textContent.trim(); if (!employeeName) { alert('Participant Name cannot be empty.'); return; } addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: employeeName, department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); tr.remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.matches('.discard-reviewed-participant-btn')) { targetBtn.closest('tr').remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.id === 'add-all-reviewed-btn') { if (confirm(`Add all ${reviewTbody.rows.length} participants?`)) { [...reviewTbody.rows].forEach(tr => { addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: tr.querySelector('.imported-name-cell').textContent.trim(), department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); }); reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } if (targetBtn.id === 'discard-all-reviewed-btn') { if (confirm('Discard all imported participants?')) { reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } }); }
            
            function initAddEmployeeForm() {
                const corporateSelect = document.getElementById('corporate-select');
                const regionalSelect = document.getElementById('regional-select');
                const unitSelect = document.getElementById('unit-select');
                const departmentSelect = document.getElementById('department-select');

                function populateDropdown(selectElement, options, placeholder) {
                    selectElement.innerHTML = `<option value="">${placeholder}</option>`;
                    options.forEach(option => selectElement.add(new Option(option, option)));
                    selectElement.disabled = options.length === 0;
                }

                populateDropdown(corporateSelect, Object.keys(orgData), 'Select Corporate');

                corporateSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const regionals = selectedCorporate ? Object.keys(orgData[selectedCorporate]) : [];
                    populateDropdown(regionalSelect, regionals, 'Select Regional');
                    populateDropdown(unitSelect, [], 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                });
                
                regionalSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const selectedRegional = regionalSelect.value;
                    const units = selectedCorporate && selectedRegional ? Object.keys(orgData[selectedCorporate][selectedRegional]) : [];
                    populateDropdown(unitSelect, units, 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                });

                unitSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const selectedRegional = regionalSelect.value;
                    const selectedUnit = unitSelect.value;
                    const departments = selectedCorporate && selectedRegional && selectedUnit ? orgData[selectedCorporate][selectedRegional][selectedUnit] : [];
                    $(departmentSelect).empty().append('<option value="">Select Department</option>');
                    departments.forEach(dept => $(departmentSelect).append(new Option(dept, dept)));
                    $(departmentSelect).prop('disabled', departments.length === 0).selectpicker('refresh');
                });
                
                function hideAddEmployeeModal() {
                    addEmployeeModal.classList.remove('visible');
                    addEmployeeForm.reset();
                    populateDropdown(regionalSelect, [], 'Select Regional');
                    populateDropdown(unitSelect, [], 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                    delete addEmployeeModal.dataset.sourceRowIndex; 
                }

                if (modalCloseBtn) modalCloseBtn.addEventListener('click', hideAddEmployeeModal);
                if (modalCancelBtn) modalCancelBtn.addEventListener('click', hideAddEmployeeModal);

                if (addNewEmployeeBtn) {
                    addNewEmployeeBtn.addEventListener('click', () => {
                        addEmployeeForm.reset();
                        addEmployeeFormContainer.querySelector('h2').textContent = "Add New Employee";
                        delete addEmployeeModal.dataset.sourceRowIndex;
                        addEmployeeModal.classList.add('visible');
                    });
                }
                
                if (addEmployeeForm) {
                    addEmployeeForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        const newEmployee = {
                            id: document.getElementById('employee-id').value.trim(),
                            name: document.getElementById('full-name').value.trim(),
                            corporate: corporateSelect.value,
                            regional: regionalSelect.value,
                            unit: unitSelect.value,
                            department: $(departmentSelect).val(),
                            email: document.getElementById('email').value.trim(),
                            phone: document.getElementById('contact').value.trim(),
                            gender: document.getElementById('gender').value,
                            role: document.getElementById('designation').value.trim(),
                            joined: document.getElementById('date-joining').value,
                            born: document.getElementById('date-birth').value,
                            category: document.getElementById('staff-category').value,
                            foodHandler: document.getElementById('food-handlers-category').value
                        };
                        newEmployee.initials = newEmployee.name.split(' ').map(n => n[0]).join('').toUpperCase();
                        if (!newEmployee.id || !newEmployee.name) {
                            alert('Employee ID and Full Name are required.');
                            return;
                        }
                        if (masterEmployeeList.some(emp => emp.id === newEmployee.id)) {
                            alert(`An employee with ID ${newEmployee.id} already exists.`);
                            return;
                        }
                        masterEmployeeList.unshift(newEmployee);
                        addParticipantToRoster(newEmployee);
                        if (addEmployeeModal.dataset.sourceRowIndex) {
                            const reviewTbody = document.getElementById('reviewed-participants-tbody');
                            const rowIndex = parseInt(addEmployeeModal.dataset.sourceRowIndex, 10);
                            if (reviewTbody.rows[rowIndex]) { reviewTbody.rows[rowIndex].remove(); }
                             if (reviewTbody.rows.length === 0) { document.getElementById('pdf-review-section').style.display = 'none'; }
                        }
                        hideAddEmployeeModal();
                    });
                }
            }
            initAddEmployeeForm();
        });
    </script>