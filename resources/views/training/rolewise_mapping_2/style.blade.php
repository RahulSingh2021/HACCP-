<style>
    /* Reset and Base Styles */
    :root {
      --primary-color: #4361ee;
      --primary-hover: #3a56d4;
      --secondary-color: #3f37c9;
      --success-color: #4cc9f0;
      --warning-color: #f8961e;
      --danger-color: #f94144;
      --light-bg: #f8f9fa;
      --dark-text: #212529;
      --medium-text: #495057;
      --light-text: #6c757d;
      --border-color: #dee2e6;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.07);
      --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
      --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
      --transition: all 0.3s ease;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      line-height: 1.6;
      background-color: #f5f7fb;
      color: var(--dark-text);
      padding: 20px;
    }

    /* Container and Layout */
    .container {
      max-width: 1400px;
      margin: 0 auto;
      background-color: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: var(--shadow-lg);
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid var(--border-color);
    }

    .header h1 {
      color: var(--primary-color);
      font-weight: 600;
      font-size: 1.8rem;
      margin: 0;
    }

    .header-controls {
      display: flex;
      gap: 1rem;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      font-weight: 500;
      font-size: 0.875rem;
      cursor: pointer;
      transition: var(--transition);
      border: 1px solid transparent;
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
    }

    .btn-primary:hover {
      background-color: var(--primary-hover);
      box-shadow: var(--shadow-sm);
    }

    .btn-outline {
      background-color: transparent;
      border-color: var(--border-color);
      color: var(--medium-text);
    }

    .btn-outline:hover {
      background-color: var(--light-bg);
    }

    .btn-sm {
      padding: 0.375rem 0.75rem;
      font-size: 0.8125rem;
    }

    /* Table Styles */
    .table-responsive {
      overflow-x: auto;
      margin-top: 1.5rem;
      border-radius: 8px;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-sm);
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 1200px;
    }

    th, td {
      padding: 0.75rem 1rem;
      text-align: left;
      vertical-align: middle;
      font-size: 0.875rem;
      border-right: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
      white-space: nowrap;
    }
    
    td {
      white-space: normal;
    }

    th {
      font-weight: 600;
      color: var(--medium-text);
      background-color: var(--light-bg);
      position: sticky;
      top: 0;
    }

    /* Hierarchical Column Headers */
    .hierarchical-column-header {
      text-align: left;
      background-color: #e9ecef;
      font-weight: 600;
      color: var(--dark-text);
    }

    .col-department { width: 160px; }
    .col-category { width: 180px; }
    .col-role { width: 200px; }

    /* Category Headers */
    .category-header {
      background-color: #e2e8ee;
      color: #2a4d69;
      text-align: center;
      font-weight: 600;
    }

    /* Table Body Styles */
    tbody tr:hover {
      background-color: rgba(67, 97, 238, 0.05);
    }

    .hierarchical-row-label {
      font-weight: 600;
      color: var(--dark-text);
      background-color: #f8f9fa;
    }
    
    /* Select Dropdown Styles */
    select {
      padding: 0.5rem 0.75rem;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      background-color: #fff;
      min-width: 150px; /* Adjusted min-width */
      cursor: pointer;
      font-size: 0.875rem;
      transition: var(--transition);
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 0.5rem center;
      background-size: 12px;
    }

    select:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }

    /* Competency Level Select */
    .competency-select select {
      min-width: 80px;
    }

    /* Tooltip for status */
    [data-tooltip] {
      position: relative;
      cursor: pointer;
    }

    [data-tooltip]:hover::after {
      content: attr(data-tooltip);
      position: absolute;
      bottom: 100%;
      left: 50%;
      transform: translateX(-50%);
      background-color: #333;
      color: white;
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      font-size: 0.75rem;
      white-space: nowrap;
      z-index: 10;
      margin-bottom: 5px;
    }
    
    /* Filter Section */
    .filter-section {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        background-color: #fdfdff;
    }

    .filter-section-header {
      font-weight: 600;
      font-size: 1rem;
      color: var(--dark-text);
      margin-bottom: 1rem;
    }

    .filter-controls {
        display: flex;
        gap: 1.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.875rem;
        color: var(--medium-text);
        font-weight: 500;
    }
    
    .filter-actions {
        display: flex;
        gap: 0.5rem;
        margin-left: auto; /* Pushes buttons to the right */
    }

    /* Legend */
    .legend {
      margin-bottom: 1.5rem;
      font-size: 0.875rem;
      padding: 0.75rem 1rem;
      background-color: var(--light-bg);
      border: 1px solid var(--border-color);
      border-radius: 6px;
    }

    .legend p {
      margin: 0;
      line-height: 1.5;
      color: var(--medium-text);
    }
    .legend p strong {
      color: var(--dark-text);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .filter-controls {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-actions {
            margin-left: 0;
            justify-content: flex-start;
        }
    }
    @media (max-width: 768px) {
      .container {
        padding: 1rem;
      }
      .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
      .header-controls {
        width: 100%;
        justify-content: flex-start;
      }
    }

</style>