<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>COA History - Organic Whole Wheat Pasta</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Fonts: Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- SheetJS (xlsx) Library for Excel Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- Custom CSS for Advanced Design -->
<style>
    :root {
        --bs-success-rgb: 5, 150, 105; /* Emerald Green */
        --bs-warning-rgb: 245, 158, 11; /* Amber */
        --bs-danger-rgb: 220, 38, 38;  /* Red */
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f9fafb; /* Lighter background */
    }

    /* --- Sticky Header with Glassmorphism Effect --- */
    .header-sticky {
        position: sticky;
        top: 0;
        z-index: 1020;
        background-color: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /* --- General Card Styling --- */
    .custom-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .custom-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    
    .detail-icon {
        color: var(--bs-secondary-color);
        width: 16px;
        height: 16px;
        margin-right: 8px;
    }

    /* --- Desktop Table Enhancements --- */
    .table-custom {
        min-width: 1100px; /* Adjusted min-width for new columns */
    }
    .table-custom thead {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .table-custom tbody tr {
        transition: transform 0.15s ease-out, box-shadow 0.15s ease-out;
    }
    .table-custom tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 1;
        position: relative;
    }

    /* --- Mobile COA Card Enhancements --- */
    .coa-card-mobile {
        border-left-width: 5px;
        border-left-style: solid;
    }
    .coa-card-mobile.status-valid { border-left-color: #10b981; }
    .coa-card-mobile.status-warning { border-left-color: #f59e0b; }
    .coa-card-mobile.status-expired { border-left-color: #ef4444; }
    
    .coa-card-mobile .card-header {
         background-color: #f8f9fa;
         border-bottom: 1px solid #e9ecef;
    }
</style>
</head>
<body>

<header class="header-sticky py-3">
<div class="container">
<div class="row align-items-center gy-2">
<div class="col-lg-7 col-md-6">
<h1 class="h5 fw-bold mb-0 text-success">COA History</h1>
<p class="mb-0 small text-muted">{{$brand_name ?? 'N/A'}}: {{$product_name ?? 'N/A'}}</p>
</div>
<div class="col-lg-5 col-md-6 text-md-end">
    <button class="btn btn-sm btn-success" id="export-excel-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-1" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
        </svg>
        Export to Excel
    </button>
</div>
</div>
</div>
</header>

<main class="container my-4">
<!-- Product Details Section -->
<section class="mb-4">
<div class="custom-card">
<div class="card-body p-4">
<div class="row gy-3 gx-4">
<div class="col-lg-6 d-flex align-items-center">
<svg class="detail-icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/></svg>
<div class="w-100">
<div class="small text-muted">Name</div>
<div class="fw-semibold">{{$product_name ?? 'N/A'}}</div>
</div>
</div>
<div class="col-lg-6 d-flex align-items-center">
<svg class="detail-icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8.049c0 .438-.063.864-.19 1.285a.5.5 0 0 1-.749.297l-2.091-1.22c-.37-.217-.835-.217-1.205 0l-2.09 1.22a.5.5 0 0 1-.75-.297A5.002 5.002 0 0 1 8 5.064a5.002 5.002 0 0 1-1.935 3.287.5.5 0 0 1-.75.297l-2.09-1.22c-.37-.217-.835-.217-1.205 0l-2.091 1.22a.5.5 0 0 1-.749-.297A6.967 6.967 0 0 1 0 8.049c0-4.411 3.582-8 8-8s8 3.589 8 8.049zM6.622 4.013l.888-1.776a.25.25 0 0 1 .44-.042l.888 1.776a.25.25 0 0 0 .14.14l1.777.888a.25.25 0 0 1 .042.44l-1.777.888a.25.25 0 0 0-.14.14l-.888 1.776a.25.25 0 0 1-.44.042l-.888-1.776a.25.25 0 0 0-.14-.14l-1.777-.888a.25.25 0 0 1-.042-.44l1.777.888a.25.25 0 0 0 .14-.14z"/></svg>
<div class="w-100">
<div class="small text-muted">Brand</div>
<div class="fw-semibold">{{$brand_name ?? 'N/A'}}</div>
</div>
</div>
<div class="col-lg-6 d-flex align-items-center">
<svg class="detail-icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
<div class="w-100">
<div class="small text-muted">Allergens</div>
<div class="fw-semibold">{{$allergens ?? 'N/A'}}</div>
</div>
</div>
<div class="col-lg-6 d-flex align-items-center">
<svg class="detail-icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
<div class="w-100">
<div class="small text-muted">Origin</div>
<div class="fw-semibold">India</div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- COA History Section -->
<section>
    <!-- Desktop Table -->
    <div class="d-none d-lg-block">
         <div class="custom-card">
             <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Sl No</th>
                            <th>Batch Number</th>
                            <th>Uploaded By</th>
                            <th>Manufacturing Date</th>
                            <th>Receiving Date</th>
                            <!--<th>Expiry Date</th>-->
                            <th>Testing Date</th>
                            <th>Test Report Valid Till</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody id="coa-tbody-desktop">
                        <!-- Desktop rows injected by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="d-lg-none" id="coa-tbody-mobile">
        <!-- Mobile cards injected by JS -->
    </div>
</section>
</main>

<!--<footer class="text-center py-4 mt-4">-->
<!--<small class="text-muted">This is a computer-generated report. All data is sourced from internal records.</small>-->
<!--</footer>-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
// const variantId = @json($variantId);
let variantId = @json($variantId);

const url = "/admin/public/index.php/get-coa-history-data?variant_id=" + variantId;

    
console.log('url_made',url);
    fetch(url)
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json(); 
      })
      .then(data => {
          console.log("datadatadata",data)
        abc(data);
      })
      .catch(error => {
        console.error('Fetch error:', error);
      });
});

function abc(data){
const today = new Date();
today.setHours(0, 0, 0, 0);

let coaData = data;
<!--const coaData = [-->
<!--    { sl: 5, uploadedBy: 'GoodHarvest Corp >> North America >> Chicago Plant', mfgDate: '2024-07-13', receivingDate: '2024-07-20', expDate: '2026-07-12', testing: '2024-07-15', batch: 'BN-240712-A01' },-->
<!--    { sl: 4, uploadedBy: 'GoodHarvest Corp >> North America >> Chicago Plant', mfgDate: '2024-05-08', receivingDate: '2024-05-15', expDate: '2026-05-07', testing: '2024-05-10', batch: 'BN-240507-C03' },-->
<!--    { sl: 3, uploadedBy: 'GoodHarvest Corp >> Europe >> Milan Plant', mfgDate: '2022-03-10', receivingDate: '2022-03-18', expDate: '2024-03-09', testing: '2022-03-11', batch: 'BN-220309-B05' },-->
<!--    { sl: 2, uploadedBy: 'GoodHarvest Corp >> North America >> Denver Plant', mfgDate: '2023-10-01', receivingDate: '2023-10-08', expDate: '2025-09-30', testing: '2023-10-05', batch: 'BN-250815-A11' },-->
<!--    { sl: 1, uploadedBy: 'GoodHarvest Corp >> Europe >> Milan Plant', mfgDate: '2023-11-21', receivingDate: '2023-11-28', expDate: '2025-11-20', testing: '2023-11-22', batch: 'BN-231120-D02' }-->
<!--].sort((a, b) => new Date(b.expDate) - new Date(a.expDate));-->



const desktopTbody = document.getElementById('coa-tbody-desktop');
const mobileContainer = document.getElementById('coa-tbody-mobile');
const exportExcelBtn = document.getElementById('export-excel-btn');

desktopTbody.innerHTML = '';
mobileContainer.innerHTML = '';

const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
};

// const calculateReportValidTill = (testingDateStr) => {
//     const testingDate = new Date(testingDateStr);
//     const year = testingDate.getFullYear();
//     const month = testingDate.getMonth(); // 0-11 (Jan-Dec)

//     // April, May, June
//     if (month >= 3 && month <= 5) {
//         return new Date(year, 8, 30); // 30th September of the current year
//     }
//     // Oct, Nov, Dec
//     else if (month >= 9 && month <= 11) {
//         return new Date(year, 2, 31); // 31st March of the current year
//     }
//     // July, Aug, Sep, Jan, Feb, March
//     else {
//         const validTill = new Date(testingDate);
//         validTill.setMonth(validTill.getMonth() + 3);
//         return validTill;
//     }
// };
const calculateReportValidTill = (testingDateStr) => {
    const testingDate = new Date(testingDateStr);
    const year = testingDate.getFullYear();
    const month = testingDate.getMonth(); // 0-11 (Jan-Dec)

    // ✅ 01 April – 30 September → 30th September (same year)
    if (month >= 3 && month <= 8) {
        return new Date(year, 8, 30);
    }
    // ✅ 01 October – 31 March → 30th March (next year)
    else if (month >= 9 || month <= 2) {
        return new Date(year + 1, 2, 31);
    }
    // (Optional fallback – not needed actually, but keeping structure same)
    else {
        const validTill = new Date(testingDate);
        validTill.setMonth(validTill.getMonth() + 3);
        return validTill;
    }
};


coaData.forEach((item, index) => {
    const reportValidTillDate = calculateReportValidTill(item.testing);
    item.reportValidTill = reportValidTillDate.toISOString().split('T')[0];

    const expiryDate = new Date(item.expDate);
    const timeDiff = expiryDate.getTime() - today.getTime();
    const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

    let statusClass, statusBadge, statusText;
    if (dayDiff < 0) {
        statusClass = 'expired';
        statusText = 'Expired';
        statusBadge = `<span class="badge rounded-pill text-bg-danger">${statusText}</span>`;
    } else if (dayDiff <= 90) {
        statusClass = 'warning';
        statusText = `${dayDiff} days left`;
        statusBadge = `<span class="badge rounded-pill text-bg-warning">${statusText}</span>`;
    } else {
        statusClass = 'valid';
        statusText = 'Valid';
        statusBadge = `<span class="badge rounded-pill text-bg-success">${statusText}</span>`;
    }
    
    item.statusText = statusText;

// --- Populate Desktop Table ---
// const row = `
// <tr>
// <td class="ps-4 fw-medium text-muted">${String(item.sl).padStart(2, '0')}</td>
// <td><span class="badge bg-secondary-subtle text-secondary-emphasis fw-medium">${item.batch}</span></td>
// <td class="text-muted small">${item.uploadedBy.replace(/ >> /g, '<br>')}</td>
// <td class="text-muted">${formatDate(item.mfgDate)}</td>
// <td class="text-muted">${formatDate(item.receivingDate)}</td>
// <td class="fw-medium">${formatDate(item.expDate)}</td>
// <td class="text-muted">${formatDate(item.testing)}</td>
// <td class="text-muted">${formatDate(item.reportValidTill)}</td>
// <td class="text-center">${statusBadge}</td>
// <td class="text-end pe-4">
// <a href="${item.pdf}" 
//   class="btn btn-sm btn-outline-secondary" 
//   download 
//   target="_blank">
//   View PDF
// </a></td>
// </tr>
// `;
const row = `
<tr>
<td class="ps-4 fw-medium text-muted">${String(item.sl).padStart(2, '0')}</td>
<td><span class="badge bg-secondary-subtle text-secondary-emphasis fw-medium">${item.batch}</span></td>
<td class="text-muted small">${item.uploadedBy.replace(/ >> /g, '<br>')}</td>
<td class="text-muted">${formatDate(item.mfgDate)}</td>
<td class="text-muted">${formatDate(item.receivingDate)}</td>
<td class="text-muted">${formatDate(item.testing)}</td>
<td class="text-muted">${formatDate(item.reportValidTill)}</td>
<td class="text-center">${statusBadge}</td>
<td class="text-end pe-4">
<a href="${item.pdf}" 
   class="btn btn-sm btn-outline-secondary" 
   download 
   target="_blank">
   View PDF
</a></td>
</tr>
`;
desktopTbody.innerHTML += row;

// --- Populate Mobile Cards ---
// const card = `
// <div class="card custom-card coa-card-mobile status-${statusClass} mb-3">
//     <div class="card-header">
//         <div class="d-flex justify-content-between align-items-center">
//             <h6 class="mb-0 fw-bold">${item.batch}</h6>
//             ${statusBadge}
//         </div>
//     </div>
//     <div class="card-body py-3 px-4">
//         <div class="row">
//             <div class="col-12 mb-3">
//                 <div class="small text-muted">Uploaded By</div>
//                 <div class="fw-medium small">${item.uploadedBy.replace(/ >> /g, ' &rsaquo; ')}</div>
//             </div>
//             <div class="col-6 mb-3">
//                 <div class="small text-muted">Manufacturing</div>
//                 <div class="fw-medium">${formatDate(item.mfgDate)}</div>
//             </div>
//             <div class="col-6 mb-3">
//                 <div class="small text-muted">Receiving</div>
//                 <div class="fw-medium">${formatDate(item.receivingDate)}</div>
//             </div>
//             <div class="col-6 mb-3">
//                 <div class="small text-muted">Expiry</div>
//                 <div class="fw-medium">${formatDate(item.expDate)}</div>
//             </div>
//             <div class="col-6 mb-3">
//                 <div class="small text-muted">Testing</div>
//                 <div class="fw-medium">${formatDate(item.testing)}</div>
//             </div>
//             <div class="col-12 mb-2">
//                 <div class="small text-muted">Report Valid Till</div>
//                 <div class="fw-medium">${formatDate(item.reportValidTill)}</div>
//             </div>
//         </div>
//     </div>
//     <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-4">
//         <a href="/path/to/pdf/${item.batch}.pdf" class="btn btn-success w-100" target="_blank">View PDF</a>
//     </div>
// </div>
// `;
// mobileContainer.innerHTML += card;
// });
const card = `
<div class="card custom-card coa-card-mobile status-${statusClass} mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">${item.batch}</h6>
            ${statusBadge}
        </div>
    </div>
    <div class="card-body py-3 px-4">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="small text-muted">Uploaded By</div>
                <div class="fw-medium small">${item.uploadedBy.replace(/ >> /g, ' &rsaquo; ')}</div>
            </div>
            <div class="col-6 mb-3">
                <div class="small text-muted">Manufacturing</div>
                <div class="fw-medium">${formatDate(item.mfgDate)}</div>
            </div>
            <div class="col-6 mb-3">
                <div class="small text-muted">Receiving</div>
                <div class="fw-medium">${formatDate(item.receivingDate)}</div>
            </div>
            <div class="col-6 mb-3">
                <div class="small text-muted">Testing</div>
                <div class="fw-medium">${formatDate(item.testing)}</div>
            </div>
            <div class="col-12 mb-2">
                <div class="small text-muted">Report Valid Till</div>
                <div class="fw-medium">${formatDate(item.reportValidTill)}</div>
            </div>
        </div>
    </div>
    <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-4">
        <a href="/path/to/pdf/${item.batch}.pdf" class="btn btn-success w-100" target="_blank">View PDF</a>
    </div>
</div>
`;
mobileContainer.innerHTML += card;
});

const exportToExcel = () => {
    // const headers = ["Sl No", "Batch Number", "Uploaded By", "Manufacturing Date", "Receiving Date", "Expiry Date", "Testing Date", "Test Report Valid Till", "Status", "PDF Link"];
     const headers = ["Sl No", "Batch Number", "Uploaded By", "Manufacturing Date", "Receiving Date", "Testing Date", "Test Report Valid Till", "Status", "PDF Link"];
    
    const data = coaData.map(item => {
        // Construct the full URL for the PDF link
        const pdfLink = `${window.location.origin}/path/to/pdf/${item.batch}.pdf`;
        return [
            item.sl,
            item.batch,
            item.uploadedBy,
            formatDate(item.mfgDate),
            formatDate(item.receivingDate),
            // formatDate(item.expDate),
            formatDate(item.testing),
            formatDate(item.reportValidTill),
            item.statusText,
            pdfLink // Add the generated link to the row data
        ];
    });

    const worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "COA History");

    const date = new Date().toISOString().slice(0, 10);
    XLSX.writeFile(workbook, `COA-History-Report-${date}.xlsx`);
};

exportExcelBtn.addEventListener('click', exportToExcel);
}
// });
</script>

</body>
</html>