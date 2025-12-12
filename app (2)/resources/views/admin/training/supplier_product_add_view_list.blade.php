<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Product Risk Selection</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
  }
  .container {
    width: 95%;
    max-width: 1200px;
    margin: 40px auto;
    background-color: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }

  /* REVISED: Vendor Details Styling */
  .vendor-details {
    border: 1px solid #ddd;
    background-color: #fafafa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
  }
  .vendor-details h3 {
    margin: 0 0 15px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
  }
  .vendor-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 12px 20px;
  }
  .vendor-details-item {
    display: flex;
    align-items: center;
    font-size: 14px;
  }
  .vendor-details-item strong {
    color: #555;
    margin-right: 8px;
    min-width: 100px; /* Aligns values */
  }
  .vendor-details-item span {
    display: flex;
    align-items: center;
  }
  .status {
    font-weight: bold;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 12px;
    color: white;
    margin-left: 5px;
  }
  .status-active { background-color: #27ae60; }
  .status-invalid { background-color: #c0392b; }
  .risk-high { background-color: #e74c3c; }
  .risk-medium { background-color: #f39c12; }
  .risk-low { background-color: #2ecc71; }
  .risk-na { background-color: #95a5a6; }


  .header-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }
  .header-buttons {
      display: flex;
      gap: 10px;
  }
  h2, h3 {
    margin: 0;
  }

  /* Selected Products Display */
  .selected-food-container {
    border: 1px dashed #ccc;
    padding: 10px 15px;
    margin-bottom: 25px;
    min-height: 40px;
    border-radius: 5px;
    background-color: #f9f9f9;
  }
  .selected-tag {
    display: inline-flex;
    align-items: center;
    background-color: #2c5b7c;
    color: white;
    padding: 6px 12px;
    margin: 4px;
    border-radius: 20px;
    font-size: 14px;
  }
  .deselect-btn {
    margin-left: 8px;
    font-weight: bold;
    cursor: pointer;
  }
  .deselect-btn:hover {
    color: #f1c40f;
  }
  .risk-indicator {
    display: inline-block;
    font-size: 10px;
    color: white;
    padding: 2px 8px;
    border-radius: 10px;
    font-weight: bold;
    margin-left: 8px;
  }
  .risk-indicator.High { background-color: #e74c3c; }
  .risk-indicator.Medium { background-color: #f39c12; }
  .risk-indicator.Low { background-color: #2ecc71; }

  /* Table Styling */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }
  th, td {
    padding: 12px;
    text-align: left;
    vertical-align: top;
    border-bottom: 1px solid #ddd;
  }
  thead th {
    background-color: #2c5b7c;
    color: white;
    font-weight: bold;
    border-bottom: none;
    position: relative;
  }
  .filter-icon {
    cursor: pointer;
    font-size: 1em;
    margin-left: 5px;
  }
  tbody tr:nth-child(odd) { background-color: #f0f2f4; }
  tbody tr:nth-child(even) { background-color: #e0e4e8; }
  th.sl-no, td.sl-no {
    width: 50px;
    text-align: center;
    vertical-align: middle;
  }

  /* Input Styling */
  .product-name-cell label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
    cursor: pointer;
  }
  .risk-category-cell label {
    display: inline-flex;
    align-items: center;
    margin-right: 15px;
    font-size: 14px;
    cursor: pointer;
  }
   td.risk-category-cell, td.product-name-cell {
    vertical-align: middle;
  }
  input[type="checkbox"], input[type="radio"] {
    width: 1.2em;
    height: 1.2em;
    margin-right: 5px;
  }

  /* Header Dropdown Styles */
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #ffffff;
    min-width: 200px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 10;
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #ddd;
  }
   .dropdown-content .checkbox-container {
    max-height: 200px;
    overflow-y: auto;
  }
  .dropdown-content label {
      color: #333;
      display: block;
      padding: 5px;
      font-weight: normal;
  }
  .dropdown-content input[type="text"] {
    width: calc(100% - 24px);
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  /* Generalized Multi-select styles */
    td .multi-select-container {
        position: relative;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        min-height: 34px;
        box-sizing: border-box;
    }
    td .selected-items-display {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        padding: 5px;
        cursor: pointer;
    }
    .selected-items-display .placeholder {
        color: #888;
        font-size: 14px;
        line-height: 1.5;
        user-select: none;
    }
    .selected-item-tag {
        display: inline-flex;
        align-items: center;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
    }
    .selected-item-tag.brand { background-color: #3498db; }
    .selected-item-tag.storage { background-color: #9b59b6; }
    .selected-item-tag.allergen { background-color: #e67e22; }

    .remove-item-btn {
        margin-left: 6px;
        font-weight: bold;
        cursor: pointer;
    }
    .remove-item-btn:hover {
        color: #c0392b;
    }
    .multi-select-dropdown-content {
        display: none;
        position: absolute;
        top: 105%;
        left: 0;
        width: 100%;
        min-width: 220px;
        background-color: #ffffff;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 11;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }
    .multi-select-dropdown-content input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .multi-select-dropdown-content .multi-select-checkbox-container {
        max-height: 180px;
        overflow-y: auto;
    }
    .multi-select-dropdown-content label {
        display: block;
        padding: 4px 8px;
        font-weight: normal;
        cursor: pointer;
    }
    .multi-select-dropdown-content label:hover {
        background-color: #f1f1f1;
    }

  /* NEW: Button styles */
  .action-btn {
    padding: 8px 15px;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s;
    font-weight: bold;
  }
  #clear-filters-btn {
    background-color: #e74c3c;
  }
  #clear-filters-btn:hover {
    background-color: #c0392b;
  }
  #download-excel-btn {
    background-color: #27ae60;
  }
  #download-excel-btn:hover {
    background-color: #229954;
  }


  /* Pagination Styling */
  .pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
  }
  .pagination-controls button {
    background-color: #2c5b7c;
    color: white;
    border: none;
    padding: 8px 12px;
    margin: 0 2px;
    cursor: pointer;
    border-radius: 4px;
  }
  .pagination-controls button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }
  .pagination-controls button.active {
    background-color: #3498db;
    font-weight: bold;
  }
  .pagination-dots {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    margin: 0 2px;
    user-select: none;
    color: #555;
  }
  .rows-per-page-selector label {
    margin-right: 10px;
  }
  .rows-per-page-selector select {
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ccc;
  }

</style>
</head>
<body>

<div class="container">
  <!-- REVISED: Vendor Details Section -->
  <div class="vendor-details">
    <h3>Vendor Details</h3>
    <div class="vendor-details-grid">
      <div class="vendor-details-item"><strong>Vendor Name:</strong> <span id="vendor-name">{{$supplier->name ?? "N/A"}}</span></div>
      <div class="vendor-details-item"><strong>Uploaded by:</strong> <span id="vendor-uploader">
        @php
          $user = \DB::table('users')->find($supplier->created_by);
        @endphp

        {{ $user ? $user->name : 'N/A' }}</span></div>
 <div class="vendor-details-item"><strong>Status:</strong>  <span>
        <span class="status {{ $supplier->status == 1 ? 'status-active' : 'status-inactive' }}" id="vendor-status">
          {{ $supplier->status == 1 ? 'Active' : 'Inactive' }}
        </span>
      </span></div>

     <div class="vendor-details-item"><strong>Service Nature:</strong> <span id="vendor-service">{{$supplier->service_nature ?? "N/A"}}</span></div>
        @php
            $id = $supplier->id;
        
            $risks = DB::table('sqa_raw_material_product_vendors as v')
                ->join('sqa_raw_material_product_details as d', 'v.sqa_raw_material_product_detail_id', '=', 'd.id')
                ->where('v.sqa_new_supplier_id', $id)
                ->pluck('d.risk')
                ->map(fn($risk) => strtolower(trim($risk))) // trim & lowercase
                ->toArray();
        
            $supplierRisk = 'Not Added';
            if (in_array('high', $risks)) {
                $supplierRisk = 'high';
            } elseif (in_array('medium', $risks)) {
                $supplierRisk = 'medium';
            } elseif (in_array('low', $risks)) {
                $supplierRisk = 'low';
            }
        
            $riskLevel = strtolower($supplierRisk);
            $class = match($riskLevel) {
                'high' => 'risk-high',
                'medium' => 'risk-medium',
                'low' => 'risk-low',
                default => 'risk-na',
            };
        @endphp
        
        <div class="vendor-details-item">
            <strong>Vendor Risk:</strong>
            <span>
                <span id="vendor-risk-status" class="status {{ $class }}">
                    {{ $riskLevel }}
                </span>
            </span>
        </div>

       <div class="vendor-details-item">
            <strong>FSSAI:</strong>
            <span id="vendor-fssai">
                {{ $supplier->license_number ?? 'N/A' }}
                <span class="badge {{ $supplier->license_expiry_date > now()->toDateString() ? 'text-bg-success' : 'text-bg-danger' }}" data-field="license-status" style="margin-left: 10px;">
                    {{ $supplier->license_expiry_date > now()->toDateString() ? 'Valid' : 'Invalid' }}
                </span>
            </span>
        </div>

      <div class="vendor-details-item"><strong>Email:</strong> <span id="vendor-email">{{$supplier->email ?? "N/A"}}</span></div>
      <div class="vendor-details-item"><strong>Address:</strong> <span id="vendor-address">{{$supplier->full_address ?? "N/A"}}</span></div>

    </div>
  </div>


  <div class="header-controls">
    <h2>Selected Products <span id="selection-summary"></span></h2>
    <!-- NEW: Container for buttons -->
    <div class="header-buttons">
      <button type="button" id="download-excel-btn" class="action-btn" onclick="downloadSelectedProducts()">Download Excel</button>
      <button type="button" id="clear-filters-btn" class="action-btn" onclick="clearFilters()">Clear Filters</button>
    </div>
  </div>
  
     <form id="saveSelectedProductsForm">
         <input type="hidden" value="{{$supplier->id}}" id="supplier-id">
      <div class="selected-food-container" id="selected-food-display"></div>
      
      <button type="submit"
        style="
          background-color: #007bff;
          color: white;
          padding: 10px 20px;
          border: none;
          border-radius: 5px;
          font-size: 16px;
          cursor: pointer;
          display: inline-block;
          margin-top: 15px;
          margin-bottom: 15px;
        ">
        Save All
      </button>
    </form>

  <!-- Product Table -->
  <form onsubmit="return false;">
    <table>
      <thead>
        <tr>
          <th class="sl-no">Sl. No.</th>
          <th>
            Product Name
            <span class="filter-icon" onclick="toggleDropdown('productFilter')">&#128269;</span>
            <div id="productFilter" class="dropdown-content">
              <input type="text" id="productSearch" onkeyup="searchInDropdown('productSearch', 'productFilter')" placeholder="Search for names..">
               <div class="checkbox-container" id="productCheckboxContainer"></div>
            </div>
          </th>
          <th>
            Brand Name
            <span class="filter-icon" onclick="toggleDropdown('brandFilter')">&#128269;</span>
            <div id="brandFilter" class="dropdown-content">
              <input type="text" id="brandSearch" onkeyup="searchInDropdown('brandSearch', 'brandFilter')" placeholder="Search brands..">
              <div class="checkbox-container" id="brandCheckboxContainer"></div>
            </div>
          </th>
          <th>
            Risk category
            <span class="filter-icon" onclick="toggleDropdown('riskFilter')">&#128269;</span>
            <div id="riskFilter" class="dropdown-content">
              <label><input type="checkbox" onchange="applyFilters()" value="high"> High</label>
              <label><input type="checkbox" onchange="applyFilters()" value="medium"> Medium</label>
              <label><input type="checkbox" onchange="applyFilters()" value="low"> Low</label>
            </div>
          </th>
          <th style="display:none">
            
            <span class="filter-icon" onclick="toggleDropdown('storageFilter')">&#128269;</span>
            <div id="storageFilter" class="dropdown-content">
              <input type="text" id="storageSearch" onkeyup="searchInDropdown('storageSearch', 'storageFilter')" placeholder="Search storage..">
              <div class="checkbox-container" id="storageCheckboxContainer"></div>
            </div>
          </th>
          <th style="display:none">
            
            <span class="filter-icon" onclick="toggleDropdown('allergenFilter')">&#128269;</span>
            <div id="allergenFilter" class="dropdown-content">
              <input type="text" id="allergenSearch" onkeyup="searchInDropdown('allergenSearch', 'allergenFilter')" placeholder="Search allergens..">
              <div class="checkbox-container" id="allergenCheckboxContainer"></div>
            </div>
          </th>
        </tr>
      </thead>
      <tbody id="productTableBody">
        <!-- Table rows will be populated by JavaScript -->
      </tbody>
    </table>
  </form>

  <!-- Pagination Section -->
  <div class="pagination-container">
    <div class="rows-per-page-selector">
      <label for="rows-per-page">Rows per page:</label>
      <select id="rows-per-page" onchange="changeRowsPerPage(this)">
        <option value="5">5</option>
        <option value="10" selected>10</option>
        <option value="15">15</option>
        <option value="20">20</option>
      </select>
    </div>
    <div class="pagination-controls" id="pagination-controls">
      <!-- Pagination buttons will be populated by JavaScript -->
    </div>
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
// document.getElementById('saveSelectedProductsForm').addEventListener('submit', function(e) {
//     e.preventDefault();

//     const selectedTags = document.querySelectorAll('#selected-food-display .selected-tag');
//     const supplierId = document.getElementById('supplier-id').value;selected-food-display

//     const collectedData = [];

//     selectedTags.forEach(tag => {
//         const span = tag.querySelector('span[data-id]');
//         if (span) {
//             collectedData.push({
//                 id: span.getAttribute('data-id'),
//                 product: span.getAttribute('data-product'),
//                 risk: span.getAttribute('data-risk'),
//                 brands: span.getAttribute('data-brand') ? span.getAttribute('data-brand').split(',') : []

//             });
//         }
//     });


// fetch("{{ route('add.vendor.raw.material') }}", {
//     method: 'POST',
//     headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//     },
//     body: JSON.stringify({
//         supplier_id: supplierId,
//         products: collectedData
//     })
// })
// .then(response => {
//     console.log("Raw Response:", response);
//     return response.text();  
// })
// .then(data => {
//     console.log("Response Body:", data);
//     // try JSON parse manually
//     try {
//         const parsed = JSON.parse(data);
//         console.log("Parsed JSON:", parsed);
//         toastr.success("Products saved successfully!");
//         setTimeout(() => location.reload(), 2000);
//     } catch (err) {
//         console.error("JSON Parse Error:", err);
//         toastr.error("Invalid JSON response from server");
//     }
// })
// .catch(error => {
//     console.error("Fetch Error:", error);
//     toastr.error("Something went wrong!");
// });

// });

document.getElementById('saveSelectedProductsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const supplierId = document.getElementById('supplier-id').value;
    const selectedTags = document.querySelectorAll('#selected-food-display .selected-tag');

    const collectedData = [];

    selectedTags.forEach(tag => {
        const span = tag.querySelector('span[data-id]');
        if (span) {
            collectedData.push({
                id: span.getAttribute('data-id'),
                product: span.getAttribute('data-product'),
                risk: span.getAttribute('data-risk'),
                brands: span.getAttribute('data-brand') ? span.getAttribute('data-brand').split(',') : []
            });
        }
    });
    fetch("{{ route('add.vendor.raw.material') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            supplier_id: supplierId,
            products: collectedData
        })
    })
    .then(response => response.json())
    .then(data => {
        toastr.success("Products saved successfully!");
        // setTimeout(() => location.reload(), 2000);
        setTimeout(() => {
          window.location.href = "https://efsm.safefoodmitra.com/admin/public/index.php/trainers/sqa";
        }, 2000);
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        toastr.error("Something went wrong!");
    });
});

</script>

<script>
// To demonstrate advanced pagination, let's create a larger dataset
// const sampleProducts = [
//     { name: 'Milk', risk: 'High', brand: 'Dairy Farm', storage: ['Refrigerate'], allergens: ['Dairy'] },
//     { name: 'Cheese', risk: 'High', brand: 'Happy Cow', storage: ['Refrigerate'], allergens: ['Dairy'] },
//     { name: 'Raw Chicken', risk: 'High', brand: 'Farm Fresh', storage: ['Freeze'], allergens: ['None'] },
//     { name: 'Apples', risk: 'Low', brand: 'Green Valley', storage: ['Room Temperature', 'Dry Place'], allergens: ['None'] },
//     { name: 'Bread', risk: 'Low', brand: 'Bakery Co.', storage: ['Dry Place'], allergens: ['Gluten'] },
//     { name: 'Eggs', risk: 'High', brand: 'Happy Hen', storage: ['Refrigerate'], allergens: ['Eggs'] },
//     { name: 'Yogurt', risk: 'High', brand: 'Dairy Farm', storage: ['Refrigerate'], allergens: ['Dairy'] },
//     { name: 'Peanut Butter', risk: 'Medium', brand: 'Nutty Co.', storage: ['Dry Place'], allergens: ['Peanuts'] },
//     { name: 'Salmon', risk: 'High', brand: 'Ocean Fresh', storage: ['Freeze'], allergens: ['Fish'] },
//     { name: 'Soy Milk', risk: 'Low', brand: 'Healthy Choice', storage: ['Refrigerate after opening'], allergens: ['Soy'] },
//     { name: 'Almonds', risk: 'Low', brand: 'Nutty Co.', storage: ['Dry Place'], allergens: ['Tree Nuts'] },
//     { name: 'Tofu', risk: 'Medium', brand: 'Healthy Choice', storage: ['Refrigerate'], allergens: ['Soy'] },
//     { name: 'Oranges', risk: 'Low', brand: 'Green Valley', storage: ['Room Temperature'], allergens: ['None'] },
//     { name: 'Cereal', risk: 'Low', brand: 'Morning Glory', storage: ['Dry Place'], allergens: ['Gluten', 'Tree Nuts'] },
//     { name: 'Shrimp', risk: 'High', brand: 'Ocean Fresh', storage: ['Freeze'], allergens: ['Shellfish'] }
// ];

 const sampleProducts = @json($formatted);


// Create a large list of 200 products for testing pagination
const products = [];
// for(let i = 1; i <= 200; i++) {
//     const p = sampleProducts[i % sampleProducts.length];
//     products.push({ ...p, name: `${p.name} #${i}`});
// }
    for (let i = 0; i < sampleProducts.length; i++) {
    const p = sampleProducts[i];
    // products.push({ ...p, name: `${p.name} #${i + 1}` });
     products.push({ ...p, name: `${p.name}` });
}

    


// let selectedProducts = new Set();
let selectedProducts = new Set(@json($preselectedProductNames));
let currentPage = 1;
let rowsPerPage = 10;

let selectedBrandsMap = new Map();
let selectedStoragesMap = new Map();
let selectedAllergensMap = new Map();

const stateMaps = {
    brand: selectedBrandsMap,
    storage: selectedStoragesMap,
    allergen: selectedAllergensMap
};

document.addEventListener('DOMContentLoaded', () => {
  products.forEach(product => {
      const brandSet = new Set(Array.isArray(product.brand) ? product.brand : [product.brand]);
      const storageSet = new Set(Array.isArray(product.storage) ? product.storage : [product.storage]);
      const allergenSet = new Set(Array.isArray(product.allergens) ? product.allergens : [product.allergens]);

      selectedBrandsMap.set(product.name, brandSet);
      selectedStoragesMap.set(product.name, storageSet);
      selectedAllergensMap.set(product.name, allergenSet);
  });

  document.getElementById('rows-per-page').value = rowsPerPage;
  populateFilterCheckboxes();
  populateTable();
  updateSelectedFoodDisplay();
  updateVendorRisk();
  updateVendorBrand();
});

function populateFilterCheckboxes() {
    const productNames = [...new Set(products.map(p => p.name))];
    const brands = [...new Set(products.flatMap(p => p.brand))];
    const storages = [...new Set(products.flatMap(p => p.storage))];
    const allergens = [...new Set(products.flatMap(p => p.allergens))];
    
    createCheckboxes('productCheckboxContainer', productNames, 'productName');
    createCheckboxes('brandCheckboxContainer', brands, 'brand');
    createCheckboxes('storageCheckboxContainer', storages, 'storage');
    createCheckboxes('allergenCheckboxContainer', allergens, 'allergen');
}

function createCheckboxes(containerId, items, groupName) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    items.sort().forEach(item => {
        const label = document.createElement('label');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.value = item;
        checkbox.name = groupName;
        checkbox.onchange = applyFilters;
        
        label.appendChild(checkbox);
        label.appendChild(document.createTextNode(` ${item}`));
        container.appendChild(label);
    });
}

function getActiveFilters() {
    const productNameSearch = document.getElementById('productSearch').value.toLowerCase();
    
    const getCheckedValues = (selector) => 
        Array.from(document.querySelectorAll(`${selector}:checked`))
             .map(cb => cb.value);
    
    const productNames = getCheckedValues('#productFilter input[type="checkbox"]');
    const risk = getCheckedValues('#riskFilter input');
    const brands = getCheckedValues('#brandFilter input');
    const storages = getCheckedValues('#storageFilter input');
    const allergens = getCheckedValues('#allergenFilter input');

    return { productNameSearch, productNames, risk, brands, storages, allergens };
}

function applyFilters() {
    currentPage = 1;
    populateTable();
}

function createMultiSelectDropdownHTML(product, type, allItems) {
    const uniqueProductId = product.name.replace(/[^a-zA-Z0-9]/g, '');
    const selectedItems = stateMaps[type].get(product.name) || new Set();

    let selectedTagsHTML = '';
    selectedItems.forEach(item => {
        selectedTagsHTML += `
            <span class="selected-item-tag ${type}">
                ${item}
                <span class="remove-item-btn" 
                      onclick="removeItem(event, '${product.name}', '${item.replace(/'/g, "\\'")}', '${type}')">✖</span>
            </span>
        `;
    });

    const checkboxesHTML = allItems.map(item => `
        <label>
            <input type="checkbox" value="${item}" 
                   onchange="toggleItemSelection('${product.name}', '${item.replace(/'/g, "\\'")}', this.checked, '${type}')" 
                   ${selectedItems.has(item) ? 'checked' : ''}>
            ${item}
        </label>
    `).join('');

    return `
        <div class="multi-select-container">
            <div class="selected-items-display" 
                 id="selected-${type}-${uniqueProductId}" 
                 onclick="toggleMultiSelectDropdown(event, '${uniqueProductId}', '${type}')">
                ${selectedTagsHTML.length > 0 ? selectedTagsHTML : `<span class="placeholder">Select ${type}...</span>`}
            </div>
            <div class="multi-select-dropdown-content" id="${type}-dropdown-${uniqueProductId}">
                <input type="text" placeholder="Search..." onkeyup="filterMultiSelectDropdown(event)">
                <div class="multi-select-checkbox-container">
                    ${checkboxesHTML}
                </div>
            </div>
        </div>
    `;
}

function populateTable() {
  const tableBody = document.getElementById('productTableBody');
  tableBody.innerHTML = ''; 

  const filters = getActiveFilters();
//   const allBrands = [...new Set(products.flatMap(p => p.brand))].sort();
const allBrands = @json($brands);
  const allStorages = [...new Set(products.flatMap(p => p.storage))].sort();
  const allAllergens = [...new Set(products.flatMap(p => p.allergens))].sort();

  const filteredProducts = products.filter(product => {
    const searchMatch = product.name.toLowerCase().includes(filters.productNameSearch);
    const nameMatch = filters.productNames.length === 0 || filters.productNames.includes(product.name);
    const riskMatch = filters.risk.length === 0 || filters.risk.includes(product.risk);
    
    const productBrands = Array.isArray(product.brand) ? product.brand : [product.brand];
    const brandMatch = filters.brands.length === 0 || filters.brands.some(b => productBrands.includes(b));
    
    const productStorages = Array.isArray(product.storage) ? product.storage : [product.storage];
    const storageMatch = filters.storages.length === 0 || filters.storages.some(s => productStorages.includes(s));
    
    const productAllergens = Array.isArray(product.allergens) ? product.allergens : [product.allergens];
    const allergenMatch = filters.allergens.length === 0 || filters.allergens.some(a => productAllergens.includes(a));

    return searchMatch && nameMatch && riskMatch && brandMatch && storageMatch && allergenMatch;
  });

  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const paginatedProducts = filteredProducts.slice(startIndex, endIndex);

  paginatedProducts.forEach((product, index) => {
    const row = document.createElement('tr');
    const uniqueProductId = product.name.replace(/[^a-zA-Z0-9]/g, '');
    
    const riskRadiosHTML = ['high', 'medium', 'low'].map(risk => `
      <label>
        <input type="radio" name="risk_${uniqueProductId}" value="${risk}" ${product.risk === risk ? 'checked' : ''} onchange="updateProductRisk('${product.name}', this.value)">
        ${risk}
      </label>
    `).join('');
    
    row.innerHTML = `
      <td class="sl-no">${startIndex + index + 1}</td>
      <td class="product-name-cell">
      <input type="hidden" value="${product.id}" name="product_detail_id">
        <label>
          <input type="checkbox" name="food" value="${product.name}" onchange="toggleProductSelection('${product.name}')" ${selectedProducts.has(product.name) ? 'checked' : ''}>
          ${product.name}
        </label>
      </td>
      <td>${createMultiSelectDropdownHTML(product, 'brand', allBrands)}</td>
      <td style="display:none">${createMultiSelectDropdownHTML(product, 'storage', allStorages)}</td>
      <td  style="display:none">${createMultiSelectDropdownHTML(product, 'allergen', allAllergens)}</td>
      <td class="risk-category-cell">${riskRadiosHTML}</td>
    `;
    
    tableBody.appendChild(row);
  });
  setupPagination(filteredProducts.length);
}

// function toggleItemSelection(productName, itemName, isSelected, type) {
//     const selectedItems = stateMaps[type].get(productName);
//     if (isSelected) {
//         selectedItems.add(itemName);
//     } else {
//         selectedItems.delete(itemName);
//     }
//     rerenderTags(productName, type);
// }

function toggleItemSelection(productName, item, isChecked, type) {
    const map = stateMaps[type];
    const selectedSet = map.get(productName) || new Set();

    if (isChecked) {
        selectedSet.add(item);
    } else {
        selectedSet.delete(item);
    }
    map.set(productName, selectedSet);

    if (!selectedProducts.has(productName)) {
        selectedProducts.add(productName);
    }

    const checkbox = document.querySelector(`input[type="checkbox"][value="${productName}"]`);
    if (checkbox) checkbox.checked = true;

    updateSelectedFoodDisplay();
}


// function removeItem(event, productName, itemName, type) {
//     event.stopPropagation();
//     const selectedItems = stateMaps[type].get(productName);
//     selectedItems.delete(itemName);
//     rerenderTags(productName, type);

//     const uniqueProductId = productName.replace(/[^a-zA-Z0-9]/g, '');
//     const dropdown = document.getElementById(`${type}-dropdown-${uniqueProductId}`);
//     const checkbox = dropdown.querySelector(`input[value="${itemName.replace(/"/g, '\\"')}"]`);
//     if (checkbox) {
//         checkbox.checked = false;
//     }
// }

function removeItem(event, productName, itemName, type) {
    event.stopPropagation();

    const selectedItems = stateMaps[type].get(productName);
    selectedItems.delete(itemName);
    rerenderTags(productName, type);
    updateSelectedFoodDisplay();
    const uniqueProductId = productName.replace(/[^a-zA-Z0-9]/g, '');
    const dropdown = document.getElementById(`${type}-dropdown-${uniqueProductId}`);
    const checkbox = dropdown.querySelector(`input[value="${itemName.replace(/"/g, '\\"')}"]`);
    if (checkbox) {
        checkbox.checked = false;
    }
}


function rerenderTags(productName, type) {
    const uniqueProductId = productName.replace(/[^a-zA-Z0-9]/g, '');
    const container = document.getElementById(`selected-${type}-${uniqueProductId}`);
    if (!container) return;

    const selectedItems = stateMaps[type].get(productName);
    let tagsHTML = '';
    selectedItems.forEach(item => {
        tagsHTML += `
            <span class="selected-item-tag ${type}">
                ${item}
                <span class="remove-item-btn" 
                      onclick="removeItem(event, '${productName}', '${item.replace(/'/g, "\\'")}', '${type}')">✖</span>
            </span>
        `;
    });

    container.innerHTML = tagsHTML.length > 0 ? tagsHTML : `<span class="placeholder">Select ${type}...</span>`;
}

function toggleMultiSelectDropdown(event, uniqueProductId, type) {
    event.stopPropagation();
    document.querySelectorAll('.multi-select-dropdown-content').forEach(d => {
        if (d.id !== `${type}-dropdown-${uniqueProductId}`) {
            d.style.display = 'none';
        }
    });

    const dropdown = document.getElementById(`${type}-dropdown-${uniqueProductId}`);
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
}

function filterMultiSelectDropdown(event) {
    const input = event.target;
    const filter = input.value.toLowerCase();
    const dropdownContent = input.closest('.multi-select-dropdown-content');
    const labels = dropdownContent.querySelectorAll('.multi-select-checkbox-container label');
    labels.forEach(label => {
        const txtValue = label.textContent || label.innerText;
        label.style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
    });
}

function setupPagination(totalItems) {
    const paginationControls = document.getElementById('pagination-controls');
    paginationControls.innerHTML = '';
    const pageCount = Math.ceil(totalItems / rowsPerPage);

    if (pageCount <= 1) return;

    const createPageButton = (page, text = page) => {
        const button = document.createElement('button');
        button.textContent = text;
        if (page === currentPage) {
            button.classList.add('active');
        }
        button.onclick = () => {
            currentPage = page;
            populateTable();
        };
        return button;
    };
    
    const createEllipsis = () => {
        const dots = document.createElement('span');
        dots.className = 'pagination-dots';
        dots.textContent = '...';
        return dots;
    };
    
    const createNavButton = (text, page, disabled) => {
         const button = document.createElement('button');
         button.textContent = text;
         button.disabled = disabled;
         button.onclick = () => {
            currentPage = page;
            populateTable();
         };
         return button;
    };

    paginationControls.appendChild(createNavButton('First', 1, currentPage === 1));
    paginationControls.appendChild(createNavButton('Previous', currentPage - 1, currentPage === 1));

    const pageNumbersToShow = new Set();
    pageNumbersToShow.add(1);
    pageNumbersToShow.add(pageCount);
    pageNumbersToShow.add(currentPage);
    if (currentPage > 1) pageNumbersToShow.add(currentPage - 1);
    if (currentPage < pageCount) pageNumbersToShow.add(currentPage + 1);

    const sortedPages = Array.from(pageNumbersToShow).sort((a, b) => a - b);
    
    let lastPage = 0;
    sortedPages.forEach(page => {
        if (page > lastPage + 1) {
            paginationControls.appendChild(createEllipsis());
        }
        if (page !== lastPage) {
            paginationControls.appendChild(createPageButton(page));
        }
        lastPage = page;
    });

    paginationControls.appendChild(createNavButton('Next', currentPage + 1, currentPage === pageCount));
    paginationControls.appendChild(createNavButton('Last', pageCount, currentPage === pageCount));
}


function changeRowsPerPage(selectElement) {
    rowsPerPage = parseInt(selectElement.value, 10);
    currentPage = 1; 
    populateTable();
}


function updateProductRisk(productName, newRisk) {
  const productToUpdate = products.find(p => p.name === productName);
  if (productToUpdate) {
    productToUpdate.risk = newRisk;
    updateSelectedFoodDisplay();
    updateVendorRisk();
    updateVendorBrand();
  }
}

// function toggleProductSelection(productName) {
//   if (selectedProducts.has(productName)) {
//     selectedProducts.delete(productName);
//   } else {
//     selectedProducts.add(productName);
//   }
//   updateSelectedFoodDisplay();
//   updateVendorRisk();
//   updateVendorBrand();
// }

function toggleProductSelection(productName) {
    const checkbox = document.querySelector(`input[type="checkbox"][value="${productName}"]`);
    if (!checkbox) return;

    if (selectedProducts.has(productName)) {
        selectedProducts.delete(productName);
        checkbox.checked = false;

        // Agar product deselect hua → brands clear bhi kar sakte ho (optional)
        // stateMaps['brand'].set(productName, new Set());
    } else {
        selectedProducts.add(productName);
        checkbox.checked = true;

        // Agar product ke pas koi brand previously selected hai → keep it
        if (!stateMaps['brand'].has(productName)) {
            stateMaps['brand'].set(productName, new Set());
        }
    }

    updateSelectedFoodDisplay();
}


// function updateSelectedFoodDisplay() {
//   const displayContainer = document.getElementById('selected-food-display');
//   const summarySpan = document.getElementById('selection-summary');
//   displayContainer.innerHTML = '';

//   summarySpan.textContent = `(${selectedProducts.size} selected)`;

//   if (selectedProducts.size === 0) {
//     displayContainer.textContent = 'No products selected.';
//     return;
//   }

//   selectedProducts.forEach(productName => {
//     const product = products.find(p => p.name === productName);
//     if (!product) return;

//     const tag = document.createElement('div');
//     tag.className = 'selected-tag';

//     // const riskHTML = `<span class="risk-indicator ${product.risk}">${product.risk}</span>`;

//     let riskClass = '';
//     const riskLevel = product.risk; 
//     switch (riskLevel) { 
//         case 'high':
//             riskClass = 'risk-high';
//             break;
//         case 'medium':
//             riskClass = 'risk-medium';
//             break;
//         case 'low':
//             riskClass = 'risk-low';
//             break;
//         default:
//             riskClass = 'risk-na';
//             break;
//     }
    
//     const riskHTML = `<span class="risk-indicator ${riskClass}">${riskLevel}</span>`;
        
//         console.log("brnad_name",product);
//     tag.innerHTML = `
//       <span data-id="${product.id}"  data-product="${productName}"  data-risk="${riskLevel}">${productName}</span>
//       ${riskHTML}
//       <span class="deselect-btn" onclick="deselectFood('${productName}')">✖</span>
//     `;
//     displayContainer.appendChild(tag);
//   });
// }

function updateSelectedFoodDisplay() {
  const displayContainer = document.getElementById('selected-food-display');
  const summarySpan = document.getElementById('selection-summary');
  displayContainer.innerHTML = '';

  summarySpan.textContent = `(${selectedProducts.size} selected)`;

  if (selectedProducts.size === 0) {
    displayContainer.textContent = 'No products selected.';
    return;
  }

    //   selectedProducts.forEach(productName => {
    //     const product = products.find(p => p.name === productName);
    //     if (!product) return;
    
    //     const selectedBrands = Array.from(stateMaps['brand'].get(productName) || []);
    
    //     const tag = document.createElement('div');
    //     tag.className = 'selected-tag';
    
    //     // Risk indicator
    //     let riskClass = '';
    //     const riskLevel = product.risk;
    //     switch(riskLevel) {
    //       case 'high': riskClass = 'risk-high'; break;
    //       case 'medium': riskClass = 'risk-medium'; break;
    //       case 'low': riskClass = 'risk-low'; break;
    //       default: riskClass = 'risk-na'; break;
    //     }
    //     const riskHTML = `<span class="risk-indicator ${riskClass}">${riskLevel}</span>`;
    
    //     // ✅ Brand display + data attribute
    //     const brandHTML = selectedBrands.length 
    //       ? ` (${selectedBrands.join(', ')})` 
    //       : '';
    
    //     tag.innerHTML = `
    //       <span data-id="${product.id}" 
    //             data-product="${productName}" 
    //             data-risk="${riskLevel}" 
    //             data-brand="${selectedBrands.join(',')}">
    //             ${productName}
    //       </span>
    //       ${riskHTML}
    //       <span class="deselect-btn" onclick="deselectFood('${productName}')">✖</span>
    //     `;
    
    //     displayContainer.appendChild(tag);
    //   });

    selectedProducts.forEach(productName => {
        const product = products.find(p => p.name === productName);
        if (!product) return;
    
        const selectedBrands = Array.from(stateMaps['brand'].get(productName) || []);
    
        const tag = document.createElement('div');
        tag.className = 'selected-tag';
    
    
        // Risk indicator
        let riskClass = '';
        const riskLevel = product.risk;
        switch(riskLevel) {
            case 'high': riskClass = 'risk-high'; break;
            case 'medium': riskClass = 'risk-medium'; break;
            case 'low': riskClass = 'risk-low'; break;
            default: riskClass = 'risk-na'; break;
        }
        const riskHTML = `<span class="risk-indicator ${riskClass}">${riskLevel}</span>`;
        tag.innerHTML = `
          <span data-id="${product.id}" 
                data-product="${productName}"
                data-risk="${riskLevel}"
                data-brand="${selectedBrands.join(',')}">
                ${productName}
          </span>
          ${riskHTML}
          <span class="deselect-btn" onclick="deselectFood('${productName}')">✖</span>
        `;
    
        displayContainer.appendChild(tag);
    });

}
    
   

function deselectFood(productName) {
  selectedProducts.delete(productName);
  const checkbox = document.querySelector(`input[name="food"][value="${productName}"]`);
  if (checkbox) {
    checkbox.checked = false;
  }
  updateSelectedFoodDisplay();
  updateVendorRisk();
  updateVendorBrand();
}


function deselectBrand(productName, brandName) {
    if (!stateMaps['brand']) return;

    const brandSet = stateMaps['brand'].get(productName);
    if (!brandSet) return;

    // Remove the brand
    brandSet.delete(brandName);

    // Update the map
    stateMaps['brand'].set(productName, brandSet);

    // Optionally, if no brands left, you can remove the product
    // Here we keep the product selected even with 0 brands

    // Refresh display
    updateSelectedFoodDisplay();
    updateVendorBrand(); // if you have this function for syncing brands
}


function updateVendorRisk() {
    const riskStatusEl = document.getElementById('vendor-risk-status');
    
    if (selectedProducts.size === 0) {
        riskStatusEl.textContent = 'N/A';
        riskStatusEl.className = 'status risk-na';
        return;
    }

    const selectedRisks = Array.from(selectedProducts).map(productName => {
        return products.find(p => p.name === productName).risk;
    });

    if (selectedRisks.includes('high')) {
        riskStatusEl.textContent = 'high';
        riskStatusEl.className = 'status risk-high';
    } else if (selectedRisks.includes('medium')) {
        riskStatusEl.textContent = 'medium';
        riskStatusEl.className = 'status risk-medium';
    } else {
        riskStatusEl.textContent = 'low';
        riskStatusEl.className = 'status risk-low';
    }
}

function updateVendorBrand() {
    const riskStatusEl = document.getElementById('vendor-risk-status');
    
    if (selectedProducts.size === 0) {
        riskStatusEl.textContent = 'N/A';
        riskStatusEl.className = 'status risk-na';
        return;
    }

    const selectedRisks = Array.from(selectedProducts).map(productName => {
        return products.find(p => p.name === productName).risk;
    });

    if (selectedRisks.includes('high')) {
        riskStatusEl.textContent = 'high';
        riskStatusEl.className = 'status risk-high';
    } else if (selectedRisks.includes('medium')) {
        riskStatusEl.textContent = 'medium';
        riskStatusEl.className = 'status risk-medium';
    } else {
        riskStatusEl.textContent = 'low';
        riskStatusEl.className = 'status risk-low';
    }
}

function toggleDropdown(id) {
  document.querySelectorAll('.dropdown-content').forEach(dropdown => {
    if (dropdown.id !== id) dropdown.style.display = 'none';
  });
  const dropdown = document.getElementById(id);
  dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

function searchInDropdown(inputId, dropdownId) {
    const input = document.getElementById(inputId);
    const filter = input.value.toLowerCase();
    const dropdown = document.getElementById(dropdownId);
    const labels = dropdown.querySelectorAll('.checkbox-container label');
    labels.forEach(label => {
        const txtValue = label.textContent || label.innerText;
        label.style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
    });
}

function clearFilters() {
  document.getElementById('productSearch').value = '';
  document.querySelectorAll('.dropdown-content input[type="text"]').forEach(input => input.value = '');
  document.querySelectorAll('.dropdown-content input[type="checkbox"]').forEach(cb => cb.checked = false);
  document.querySelectorAll('.dropdown-content label').forEach(label => label.style.display = ''); 
  applyFilters();
}

// REVISED: Function to download selected products as a CSV file with vendor details
function downloadSelectedProducts() {
    if (selectedProducts.size === 0) {
        alert("No products selected to download.");
        return;
    }

    // Helper to format a cell for CSV (handles commas and quotes)
    const escapeCsvCell = (cell) => {
        if (cell === null || cell === undefined) {
            return '';
        }
        const stringCell = String(cell);
        if (stringCell.includes(',')) {
            return `"${stringCell.replace(/"/g, '""')}"`;
        }
        return stringCell;
    };

    // 1. Gather Vendor Details from the DOM
    const vendorName = document.getElementById('vendor-name').textContent;
    const uploadedBy = document.getElementById('vendor-uploader').textContent;
    const status = document.getElementById('vendor-status').textContent;
    const serviceNature = document.getElementById('vendor-service').textContent;
    const vendorRisk = document.getElementById('vendor-risk-status').textContent;
    const fssai = document.getElementById('vendor-fssai').textContent.trim(); // Use trim to clean up whitespace
    const email = document.getElementById('vendor-email').textContent;
    const address = document.getElementById('vendor-address').textContent;

    // 2. Create the Vendor Details section for the CSV
    const vendorDetailsData = [
        ['Vendor Details'],
        [],
        ['Vendor Name:', vendorName, '', 'Uploaded by:', uploadedBy],
        ['Status:', status, '', 'Service Nature:', serviceNature],
        ['Vendor Risk:', vendorRisk, '', 'Email:', email],
        ['FSSAI:', fssai, '', 'Address:', address]
    ];
    const vendorDetailsCsv = vendorDetailsData.map(row => row.map(escapeCsvCell).join(',')).join('\r\n');


    // 3. Create the Product Data section
    const productHeaders = ['Sl. No.', 'Product Name', 'Brand Name', 'Risk Category'];
    const productRows = Array.from(selectedProducts).map((productName, index) => {
        const product = products.find(p => p.name === productName);
        const brands = Array.from(stateMaps.brand.get(productName) || []).join('; ');
        // const storages = Array.from(stateMaps.storage.get(productName) || []).join('; ');
        // const allergens = Array.from(stateMaps.allergen.get(productName) || []).join('; ');

        // return [
        //     index + 1,
        //     product.name,
        //     brands,
        //     storages,
        //     allergens,
        //     product.risk
        // ].map(escapeCsvCell).join(',');
                return [
            index + 1,
            product.name,
            brands,
            product.risk
        ].map(escapeCsvCell).join(',');
    });
    
    const productCsv = [productHeaders.join(','), ...productRows].join('\r\n');

    // 4. Combine both sections and initiate download
    const csvContent = vendorDetailsCsv + '\r\n\r\n' + productCsv;
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");

    if (link.download !== undefined) { 
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "selected_products_report.csv");
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}



window.onclick = function(event) {
  if (!event.target.matches('.filter-icon') && !event.target.closest('.dropdown-content')) {
    document.querySelectorAll('.dropdown-content').forEach(d => d.style.display = 'none');
  }
  if (!event.target.closest('.multi-select-container')) {
    document.querySelectorAll('.multi-select-dropdown-content').forEach(d => d.style.display = 'none');
  }
}
</script>

</body>