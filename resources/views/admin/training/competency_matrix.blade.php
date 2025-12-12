@extends('layouts.app1', ['pagetitle' => 'Dashboard'])
  <style>
    :root {
      --primary-color: #2c5e91;
      --secondary-color: #4CAF50;
      --accent-color: #FF6B35;
      --warning-color: #FFC107;
      --danger-color: #DC3545;
      --light-gray: #f5f5f5;
      --dark-gray: #333;
      --gap-highlight: #ffebee;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f9f9f9;
      padding: 20px;
      color: var(--dark-gray);
      line-height: 1.6;
    }
    
    .container {
      max-width: 1400px;
      margin: 0 auto;
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    h1 {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 2px solid var(--primary-color);
    }
    
    .subtitle {
      text-align: center;
      color: #666;
      margin-bottom: 30px;
      font-style: italic;
    }
    
    .controls {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 20px;
    }
    
    .filters {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    
    .actions {
      display: flex;
      gap: 15px;
    }
    
    select, input, button {
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: inherit;
    }
    
    button {
      background-color: var(--primary-color);
      color: white;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    button:hover {
      background-color: #1a4a7a;
    }
    
    button.secondary {
      background-color: #6c757d;
    }
    
    button.secondary:hover {
      background-color: #5a6268;
    }
    
    table {
      border-collapse: collapse;
      width: 100%;
      background: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }
    
    th, td {
      padding: 12px 15px;
      border: 1px solid #e0e0e0;
      text-align: left;
    }
    
    th {
      background-color: var(--primary-color);
      color: white;
      font-weight: 600;
      position: sticky;
      top: 0;
    }
    
    tr:nth-child(even) {
      background-color: var(--light-gray);
    }
    
    tr:hover {
      background-color: #f0f7ff;
    }
    
    .employee-info {
      background-color: #f0f7ff;
      font-weight: bold;
    }
    
    .type-should {
      background-color: #e6f7e6;
      font-weight: bold;
    }
    
    .type-actual {
      background-color: #fff3e6;
      font-weight: bold;
    }
    
    .type-plan {
      background-color: #f5f5f5;
      font-weight: bold;
    }
    
    .competency-level {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 0.9em;
    }
    
    .level-5 {
      background-color: #e6f7e6;
      color: var(--secondary-color);
    }
    
    .level-4 {
      background-color: #e6f7e6;
      color: var(--secondary-color);
    }
    
    .level-3 {
      background-color: #fff3e6;
      color: var(--accent-color);
    }
    
    .level-2 {
      background-color: #fff3e6;
      color: var(--accent-color);
    }
    
    .level-1 {
      background-color: #fdecea;
      color: var(--danger-color);
    }
    
    .level-na {
      background-color: #f0f0f0;
      color: #666;
    }
    
    .training-plan {
      font-style: italic;
      color: var(--primary-color);
    }
    
    .training-plan-gap {
      background-color: var(--gap-highlight);
      cursor: pointer;
      position: relative;
    }
    
    .training-plan-gap::after {
      content: "+ Add training plan";
      color: var(--danger-color);
      font-style: italic;
      font-size: 0.9em;
    }
    
    .training-plan-gap.has-plan::after {
      content: none;
    }
    
    .action-icons {
      display: flex;
      gap: 10px;
    }
    
    .action-icons i {
      cursor: pointer;
      color: var(--primary-color);
      transition: color 0.3s;
    }
    
    .action-icons i:hover {
      color: #1a4a7a;
    }
    
    .footer {
      text-align: center;
      margin-top: 30px;
      color: #666;
      font-size: 0.9em;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .stats {
      display: flex;
      gap: 20px;
      margin-top: 20px;
    }
    
    .stat-card {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      flex: 1;
      text-align: center;
    }
    
    .stat-card h3 {
      margin-top: 0;
      color: var(--primary-color);
    }
    
    .stat-value {
      font-size: 24px;
      font-weight: bold;
      margin: 10px 0;
    }
    
    .level-description {
      font-size: 0.8em;
      color: #999;
      margin-top: 10px;
    }
    
    .competency-dropdown {
      padding: 5px;
      border-radius: 4px;
      border: 1px solid #ddd;
      font-family: inherit;
      width: 100%;
    }
    
    @media (max-width: 768px) {
      .controls {
        flex-direction: column;
      }
      
      .filters, .actions {
        width: 100%;
      }
      
      table {
        display: block;
        overflow-x: auto;
      }
    }
      
  </style>

@section('content')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @include('admin.training.training_navbar')
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="training-types" role="tabpanel">
                            
                              
    <h1>Detailed Competency Matrix</h1>
    <div class="subtitle">ISO 22000:2018 Food Safety Management System</div>
    
    <div class="stats">
      <div class="stat-card">
        <h3>Total Employees</h3>
        <div class="stat-value" id="total-employees">4</div>
        <div>Tracked in system</div>
      </div>
      <div class="stat-card">
        <h3>Fully Compliant</h3>
        <div class="stat-value" id="compliant-count">1</div>
        <div>Meets all requirements</div>
      </div>
      <div class="stat-card">
        <h3>Gaps Identified</h3>
        <div class="stat-value" id="gaps-count">2</div>
        <div>Training needed</div>
      </div>
      <div class="stat-card">
        <h3>Critical Gaps</h3>
        <div class="stat-value" id="critical-gaps">1</div>
        <div>High priority items</div>
      </div>
    </div>
    
    <div class="controls">
      <div class="filters">
        <select id="department-filter">
          <option value="">All Departments</option>
          <option value="QA">Quality Assurance</option>
          <option value="Production">Production</option>
          <option value="Maintenance">Maintenance</option>
          <option value="Warehouse">Warehouse</option>
        </select>
        
        <select id="compliance-filter">
          <option value="">All Compliance Status</option>
          <option value="Compliant">Fully Compliant</option>
          <option value="Partial">Partially Compliant</option>
          <option value="Non-Compliant">Non-Compliant</option>
        </select>
        
        <input type="text" id="search-input" placeholder="Search employees...">
      </div>
      
      <div class="actions">
        <button id="add-employee"><i class="fas fa-user-plus"></i> Add Employee</button>
        <button id="export-data" class="secondary"><i class="fas fa-file-export"></i> Export</button>
        <button id="refresh-data" class="secondary"><i class="fas fa-sync-alt"></i> Refresh</button>
      </div>
    </div>
    
    <div class="level-description">
      <strong>Competency Levels:</strong> 
      1 - Awareness | 2 - Basic Knowledge | 3 - Can Perform with Supervision | 4 - Can Perform Independently | 5 - Can Train Others
    </div>
    
    <table id="competency-table">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Department</th>
          <th>Type</th>
          <th>HACCP Principles</th>
          <th>Good Manufacturing Practices</th>
          <th>Allergen Management</th>
          <th>Personal Hygiene</th>
          <th>Equipment Sanitation</th>
          <th>Documentation Control</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Employee 1 -->
        <tr class="employee-info">
          <td rowspan="3">John Smith</td>
          <td rowspan="3">QA</td>
          <td class="type-should">Should</td>
          <td><span class="competency-level level-5">5</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td><span class="competency-level level-3">3</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td><span class="competency-level level-na">-</span></td>
          <td><span class="competency-level level-3">3</span></td>
          <td rowspan="3" class="action-icons">
            <i class="fas fa-edit" title="Edit"></i>
            <i class="fas fa-chart-line" title="View History"></i>
          </td>
        </tr>
        <tr>
          <td class="type-actual">Actual</td>
          <td>
            <select class="competency-dropdown" data-skill="haccp" data-employee="john-smith">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="gmp" data-employee="john-smith">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected>4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="allergen" data-employee="john-smith">
              <option value="1" selected>1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="hygiene" data-employee="john-smith">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected>4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="sanitation" data-employee="john-smith">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0" selected>-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="documentation" data-employee="john-smith">
              <option value="1">1</option>
              <option value="2" selected>2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="type-plan">Plan</td>
          <td class="training-plan-gap" data-skill="haccp" data-employee="john-smith"><span class="training-plan">Advanced HACCP Training (Q3)</span></td>
          <td>-</td>
          <td class="training-plan-gap" data-skill="allergen" data-employee="john-smith"><span class="training-plan">Allergen Workshop (Q2)</span></td>
          <td>-</td>
          <td>-</td>
          <td class="training-plan-gap" data-skill="documentation" data-employee="john-smith"><span class="training-plan">Documentation Training (Q1)</span></td>
        </tr>
        
        <!-- Employee 2 -->
        <tr class="employee-info">
          <td rowspan="3">Sarah Johnson</td>
          <td rowspan="3">Production</td>
          <td class="type-should">Should</td>
          <td><span class="competency-level level-3">3</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td><span class="competency-level level-3">3</span></td>
          <td><span class="competency-level level-na">-</span></td>
          <td><span class="competency-level level-2">2</span></td>
          <td rowspan="3" class="action-icons">
            <i class="fas fa-edit" title="Edit"></i>
            <i class="fas fa-chart-line" title="View History"></i>
          </td>
        </tr>
        <tr>
          <td class="type-actual">Actual</td>
          <td>
            <select class="competency-dropdown" data-skill="haccp" data-employee="sarah-johnson">
              <option value="1" selected>1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="gmp" data-employee="sarah-johnson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="allergen" data-employee="sarah-johnson">
              <option value="1">1</option>
              <option value="2" selected>2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="hygiene" data-employee="sarah-johnson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="sanitation" data-employee="sarah-johnson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0" selected>-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="documentation" data-employee="sarah-johnson">
              <option value="1" selected>1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="type-plan">Plan</td>
          <td class="training-plan-gap" data-skill="haccp" data-employee="sarah-johnson"><span class="training-plan">Basic HACCP (Q1)</span></td>
          <td class="training-plan-gap" data-skill="gmp" data-employee="sarah-johnson"></td>
          <td class="training-plan-gap" data-skill="allergen" data-employee="sarah-johnson"><span class="training-plan">Allergen Control (Q1)</span></td>
          <td>-</td>
          <td>-</td>
          <td class="training-plan-gap" data-skill="documentation" data-employee="sarah-johnson"><span class="training-plan">Documentation Basics (Q2)</span></td>
        </tr>
        
        <!-- Employee 3 -->
        <tr class="employee-info">
          <td rowspan="3">Michael Brown</td>
          <td rowspan="3">Maintenance</td>
          <td class="type-should">Should</td>
          <td><span class="competency-level level-2">2</span></td>
          <td><span class="competency-level level-3">3</span></td>
          <td><span class="competency-level level-2">2</span></td>
          <td><span class="competency-level level-3">3</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td><span class="competency-level level-2">2</span></td>
          <td rowspan="3" class="action-icons">
            <i class="fas fa-edit" title="Edit"></i>
            <i class="fas fa-chart-line" title="View History"></i>
          </td>
        </tr>
        <tr>
          <td class="type-actual">Actual</td>
          <td>
            <select class="competency-dropdown" data-skill="haccp" data-employee="michael-brown">
              <option value="1" selected>1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="gmp" data-employee="michael-brown">
              <option value="1">1</option>
              <option value="2" selected>2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="allergen" data-employee="michael-brown">
              <option value="1" selected>1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="hygiene" data-employee="michael-brown">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="sanitation" data-employee="michael-brown">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected>4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="documentation" data-employee="michael-brown">
              <option value="1" selected>1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="type-plan">Plan</td>
          <td class="training-plan-gap" data-skill="haccp" data-employee="michael-brown"><span class="training-plan">HACCP Awareness (Q1)</span></td>
          <td class="training-plan-gap" data-skill="gmp" data-employee="michael-brown"></td>
          <td class="training-plan-gap" data-skill="allergen" data-employee="michael-brown"><span class="training-plan">Allergen Basics (Q2)</span></td>
          <td>-</td>
          <td>-</td>
          <td class="training-plan-gap" data-skill="documentation" data-employee="michael-brown"><span class="training-plan">Documentation Basics (Q3)</span></td>
        </tr>
        
        <!-- Employee 4 -->
        <tr class="employee-info">
          <td rowspan="3">Emma Wilson</td>
          <td rowspan="3">QA</td>
          <td class="type-should">Should</td>
          <td><span class="competency-level level-5">5</span></td>
          <td><span class="competency-level level-5">5</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td><span class="competency-level level-3">3</span></td>
          <td><span class="competency-level level-4">4</span></td>
          <td rowspan="3" class="action-icons">
            <i class="fas fa-edit" title="Edit"></i>
            <i class="fas fa-chart-line" title="View History"></i>
          </td>
        </tr>
        <tr>
          <td class="type-actual">Actual</td>
          <td>
            <select class="competency-dropdown" data-skill="haccp" data-employee="emma-wilson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5" selected>5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="gmp" data-employee="emma-wilson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5" selected>5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="allergen" data-employee="emma-wilson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected>4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="hygiene" data-employee="emma-wilson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected>4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="sanitation" data-employee="emma-wilson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
          <td>
            <select class="competency-dropdown" data-skill="documentation" data-employee="emma-wilson">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="0">-</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="type-plan">Plan</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td class="training-plan-gap" data-skill="sanitation" data-employee="emma-wilson"></td>
          <td class="training-plan-gap" data-skill="documentation" data-employee="emma-wilson"><span class="training-plan">Advanced Documentation (Q4)</span></td>
        </tr>
      </tbody>
    </table>
    
 
  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    
<!-- Add Training Modal -->
<!-- Modal -->
@endsection
@section('footerscript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/19.1.8/js/dx.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.7.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>

  
  <script>
    // Filter functionality
    document.getElementById('search-input').addEventListener('input', filterTable);
    document.getElementById('department-filter').addEventListener('change', filterTable);
    document.getElementById('compliance-filter').addEventListener('change', filterTable);
    
    function filterTable() {
      const searchValue = document.getElementById('search-input').value.toLowerCase();
      const departmentFilter = document.getElementById('department-filter').value;
      const complianceFilter = document.getElementById('compliance-filter').value;
      const rows = document.querySelectorAll('.employee-info');
      let visibleCount = 0;
      let compliantCount = 0;
      let gapsCount = 0;
      let criticalGaps = 0;
      
      rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const department = row.cells[1].textContent;
        const actualRow = row.nextElementSibling;
        const shouldCells = row.querySelectorAll('td[class^="competency-level"]');
        const actualSelects = actualRow.querySelectorAll('select.competency-dropdown');
        
        let isCompliant = true;
        let hasCriticalGap = false;
        
        for (let i = 0; i < shouldCells.length; i++) {
          const shouldLevel = parseInt(shouldCells[i].textContent) || 0;
          const actualLevel = parseInt(actualSelects[i].value) || 0;
          
          if (actualLevel < shouldLevel - 1) {
            hasCriticalGap = true;
            isCompliant = false;
          } else if (actualLevel < shouldLevel) {
            isCompliant = false;
          }
        }
        
        const nameMatch = !searchValue || name.includes(searchValue);
        const departmentMatch = !departmentFilter || department === departmentFilter;
        const complianceMatch = !complianceFilter || 
          (complianceFilter === 'Compliant' && isCompliant) ||
          (complianceFilter === 'Partial' && !isCompliant && !hasCriticalGap) ||
          (complianceFilter === 'Non-Compliant' && hasCriticalGap);
        
        if (nameMatch && departmentMatch && complianceMatch) {
          row.style.display = '';
          actualRow.style.display = '';
          actualRow.nextElementSibling.style.display = '';
          visibleCount++;
          
          if (isCompliant) compliantCount++;
          if (!isCompliant) gapsCount++;
          if (hasCriticalGap) criticalGaps++;
        } else {
          row.style.display = 'none';
          actualRow.style.display = 'none';
          actualRow.nextElementSibling.style.display = 'none';
        }
      });
      
      // Update stats
      document.getElementById('total-employees').textContent = visibleCount;
      document.getElementById('compliant-count').textContent = compliantCount;
      document.getElementById('gaps-count').textContent = gapsCount;
      document.getElementById('critical-gaps').textContent = criticalGaps;
    }
    
    // Update display when dropdowns change
    document.querySelectorAll('.competency-dropdown').forEach(dropdown => {
      dropdown.addEventListener('change', function() {
        filterTable();
        highlightGaps();
      });
    });
    
    // Highlight gaps and make plan cells clickable
    function highlightGaps() {
      const employeeRows = document.querySelectorAll('.employee-info');
      
      employeeRows.forEach(row => {
        const shouldCells = row.querySelectorAll('td[class^="competency-level"]');
        const actualRow = row.nextElementSibling;
        const actualSelects = actualRow.querySelectorAll('select.competency-dropdown');
        const planRow = actualRow.nextElementSibling;
        const planCells = planRow.querySelectorAll('td[data-skill]');
        
        for (let i = 0; i < shouldCells.length; i++) {
          const shouldLevel = parseInt(shouldCells[i].textContent) || 0;
          const actualLevel = parseInt(actualSelects[i].value) || 0;
          const planCell = planCells[i];
          
          if (shouldLevel > 0 && actualLevel < shouldLevel) {
            planCell.classList.add('training-plan-gap');
            if (!planCell.querySelector('.training-plan')) {
              planCell.innerHTML = '<span class="training-plan"></span>';
            }
          } else {
            planCell.classList.remove('training-plan-gap');
          }
          
          // Add has-plan class if there's a training plan
          if (planCell.querySelector('.training-plan') && planCell.querySelector('.training-plan').textContent.trim() !== '') {
            planCell.classList.add('has-plan');
          } else {
            planCell.classList.remove('has-plan');
          }
        }
      });
    }
    
    // Add click handler for plan cells
    document.addEventListener('click', function(e) {
      const planCell = e.target.closest('.training-plan-gap');
      if (planCell) {
        const skill = planCell.dataset.skill;
        const employee = planCell.dataset.employee;
        const currentPlan = planCell.querySelector('.training-plan').textContent.trim();
        
        const newPlan = prompt(Enter training plan for ${skill} (${employee}):, currentPlan);
        if (newPlan !== null) {
          planCell.querySelector('.training-plan').textContent = newPlan;
          if (newPlan.trim() !== '') {
            planCell.classList.add('has-plan');
          } else {
            planCell.classList.remove('has-plan');
          }
        }
      }
    });
    
    // Initialize table
    filterTable();
    highlightGaps();
  </script>
@endsection
