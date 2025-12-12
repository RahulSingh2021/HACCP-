<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <!-- <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" /> -->
    <!--plugins-->
    <link href="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{asset('assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/dark-theme.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/semi-dark.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/header-colors.css')}}" />
	
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
	
	
	<!-- Datatable   CSS -->
	
	   <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
	   <link rel="stylesheet" media="screen" href="https://cdn3.devexpress.com/jslib/19.1.4/css/dx.light.css" id="cm-theme" />


	<meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>efsms</title>
</head>
<style>
	
	
	th {
    font-size: 14px !important;
}
	
	 td {
    padding: 8px 10px;
    font-size: 14px;
}
	div#example_length {
    margin: 20px 0px;
}
	
	
	div#example_filter {
    display: none;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#example_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#example_paginate a {
    color: #fff !important;
}
	
	.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #dcdcdc));
    background: -webkit-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -moz-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -ms-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -o-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: #d10b1e !important;
    border: 0px !important;
}
	
	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 0px;
    background-color: #585858;
    background: red;
    background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
    background: -moz-linear-gradient(top, #585858 0%, #111 100%);
    background: -ms-linear-gradient(top, #585858 0%, #111 100%);
    background: -o-linear-gradient(top, #585858 0%, #111 100%);
    background: #d10b1e !important;
}
	
	.table>:not(:last-child)>:last-child>* {
    border-bottom-color: transparent;
}
	a.back {
    text-align: right;
    float: right;
    padding: 13px 30px;
    background: #17a00e;
    margin-bottom: 20px;
    border-radius: 6px;
    color: #fff;
}

a.active {
    color: #fff !important;
    text-decoration: none;
    background: #0d6efd;
}
















        /* --- Universal Styles --- */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            background-color: #f8f9fa;
        }
        
        body.drawer-open {
            overflow: hidden;
        }

        /* 
        ===================================================================
        DESKTOP / WEB VIEW STYLES (Default for screens > 768px)
        ===================================================================
        */
        
        .mobile-header, #overlay, #drawer-search-container {
            display: none;
        }

        nav {
            display: flex;
            flex-direction: row;
            background-color: #ffffff;
            padding: 0.75rem;
            overflow-x: auto;
            border-bottom: 1px solid #dee2e6;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        nav::-webkit-scrollbar {
            display: none;
        }

        .tab-link {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            background-color: #f8f9fa;
            color: #495057;
            border: none;
            padding: 0.6rem 1rem;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 20px;
            margin: 0 0.25rem;
            transition: all 0.2s ease-in-out;
        }
        
        .tab-link:hover {
            background-color: #e9ecef;
        }

        .tab-link.active {
            background-color: #007bff;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }

        .tab-icon svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }
        
        .tab-text {
            white-space: nowrap;
        }
        
        main {
            padding: 2rem;
        }

        #content-title {
            text-align: center;
            color: #343a40;
        }

        /* 
        ===================================================================
        MOBILE DRAWER STYLES (Applied only on screens <= 768px)
        ===================================================================
        */
        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.75rem 1rem;
                background-color: #ffffff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                position: sticky;
                top: 0;
                z-index: 100;
            }
            
            .mobile-header h1 {
                margin: 0;
                font-size: 1.2rem;
            }

            #menu-toggle {
                background: none;
                border: none;
                padding: 0.5rem;
                cursor: pointer;
            }
            
            #menu-toggle svg {
                width: 28px;
                height: 28px;
            }

            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 150;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            body.drawer-open #overlay {
                display: block;
                opacity: 1;
                visibility: visible;
            }

            nav {
                position: fixed;
                top: 0;
                left: 0;
                width: 280px;
                height: 100%;
                background-color: #f0f2f5;
                flex-direction: column;
                padding: 0;
                border-bottom: none;
                box-shadow: 4px 0 15px rgba(0,0,0,0.1);
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                z-index: 200;
            }
            
            #drawer-search-container {
                display: block;
                padding: 1rem;
                background-color: #f0f2f5;
                position: sticky;
                top: 0;
                z-index: 10;
            }
            
            #drawer-search {
                width: 100%;
                box-sizing: border-box;
                padding: 0.8rem;
                border: 1px solid #ddd;
                border-radius: 8px;
                font-size: 1rem;
            }

            body.drawer-open nav {
                transform: translateX(0);
            }

            .tab-link {
                background-color: var(--tab-color, #34495e);
                color: #ffffff;
                border-radius: 12px 50px 50px 12px;
                padding: 0.5rem 0.5rem 0.5rem 1.25rem;
                margin: 0 1rem 0.75rem 1rem;
                width: auto;
                justify-content: space-between;
                font-weight: 600;
                /* FIX: Added align-items to handle vertical centering for wrapped text */
                align-items: center; 
            }
            
            .tab-link.active {
                box-shadow: none;
            }

            .tab-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                background-color: #ffffff;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .tab-icon svg {
                width: 26px;
                height: 26px;
                fill: var(--tab-color, #34495e);
            }
            
            .tab-text {
                font-size: 1rem;
                /* FIX: Allow text to wrap and prevent overflow */
                flex: 1; /* Allows the element to grow and shrink */
                white-space: normal; /* Allows text to wrap */
                margin-right: 8px; /* Adds a small gap between text and icon */
                line-height: 1.3; /* Improves readability for wrapped text */
            }

            #content-title {
                font-size: 1.5rem;
            }
        }
    </style>
<body>

    <div class="wrapper">

    
@include('layouts.header')
<!--<div class="page-wrapper">-->
<!--        <div class="page-content">-->
<!--          <div id="overlay"></div>-->

<!--    <header class="mobile-header">-->
<!--        <button id="menu-toggle">-->
<!--            <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path></svg>-->
<!--        </button>-->
<!--        <h1>Records</h1>-->
<!--        <div style="width: 44px;"></div> <!-- Spacer -->-->
<!--    </header>-->

<!--    <nav>-->
<!--        <div id="drawer-search-container">-->
<!--            <input type="search" id="drawer-search" placeholder="Search records..." onkeyup="filterTabs()">-->
<!--        </div>-->

        <!-- Fully Updated List of Tabs -->
<!--        <button class="tab-link active" onclick="switchTab(event)" style="--tab-color: #3498db;">-->
<!--            <span class="tab-text">Inspection</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #f1c40f;">-->
<!--            <span class="tab-text">Opening Hygiene Checklist</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 9V3.5L18.5 9H13zm-2.5 9c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm-1-4h2v3h-2v-3z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #2c3e50;">-->
<!--            <span class="tab-text">Closing Hygiene Checklist</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 9V3.5L18.5 9H13zm-2.5 9c-2.21 0-4-1.79-4-4s1.79-4 4-4c.48 0 .95.07 1.4.18-.88.8-1.4 1.94-1.4 3.22s.52 2.42 1.4 3.22c-.45.11-.92.18-1.4.18z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #1abc9c;">-->
<!--            <span class="tab-text">Briefing</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 12H5v-2h14v2zm0-4H5v-2h14v2zm0-4H5V6h14v2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #95a5a6;">-->
<!--            <span class="tab-text">Supplier Audit</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm13.5-8.5l1.96 2.5H17V9.5h2.5zM18 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #7f8c8d;">-->
<!--            <span class="tab-text">Supplier Evaluation Checklist</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #27ae60;">-->
<!--            <span class="tab-text">Receiving Register</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm-1.5 14.5L9 13l1.41-1.41L12 13.17l3.59-3.58L17 11l-4.5 4.5zM13 9V3.5L18.5 9H13z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #c0392b;">-->
<!--            <span class="tab-text">Chilled Storage</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #8e44ad;">-->
<!--            <span class="tab-text">Frozen Storage</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #d35400;">-->
<!--            <span class="tab-text">Stock Register</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-1.45-5c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #2980b9;">-->
<!--            <span class="tab-text">Dry Storage</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M2 20h20v-4H2v4zm2-3h2v2H4v-2zM2 4v4h20V4H2zm4 3H4V5h2v2zm-4 7h20v-4H2v4zm2-3h2v2H4v-2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #2ecc71;">-->
<!--            <span class="tab-text">F & V</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #e67e22;">-->
<!--            <span class="tab-text">Egg Sanitization</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 4.17 2.52 7.69 6 9.12V22h2v-3.88c3.48-1.43 6-4.95 6-9.12 0-3.87-3.13-7-7-7zm0 2c1.55 0 2.9.82 3.65 2.05L7.05 14.65C5.82 13.9 5 12.55 5 11c0-2.76 2.24-5 5-5zm0 14c-1.55 0-2.9-.82-3.65-2.05l8.6-8.6C16.18 7.1 17 8.45 17 10c0 2.76-2.24 5-5 5z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #5DADE2;">-->
<!--            <span class="tab-text">Probe Themormeter Calibration</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M15 13V5c0-1.66-1.34-3-3-3S9 3.34 9 5v8c-1.21.91-2 2.37-2 4 0 2.76 2.24 5 5 5s5-2.24 5-5c0-1.63-.79-3.09-2-4zm-4-8c0-.55.45-1 1-1s1 .45 1 1v7.27c.58.14 1.12.4 1.59.75L15 13V5c0-1.66-1.34-3-3-3S9 3.34 9 5v8l.41-.32c.47-.35 1.01-.61 1.59-.75V5z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #f39c12;">-->
<!--            <span class="tab-text">Thawing</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 14h-8v-2h8v2zm0-4h-8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #e74c3c;">-->
<!--            <span class="tab-text">Cooking</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4s1.79-4 4-4c.71 0 1.38.19 1.95.52l1.05.61.47-1.18C10.23 7.5 11.08 7 12 7c1.66 0 3 1.34 3 3h-1c0-1.1-.9-2-2-2s-2 .9-2 2v.59L8.59 12 8 11.41V11c0-2.21 1.79-4 4-4s4 1.79 4 4h-1c0-1.1-.9-2-2-2s-2 .9-2 2v1h5c1.65 0 3 1.35 3 3s-1.35 3-3 3z"/></svg></span>-->
<!--        </button>-->
<!--         <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #F4D03F;">-->
<!--            <span class="tab-text">Oil Change</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 13.5L11 11V5h2v5l3.5 3.5-1 1z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #3498DB;">-->
<!--            <span class="tab-text">Cooling</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #E74C3C;">-->
<!--            <span class="tab-text">Reheating</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm-1-8H9v2h2v2h2v-2h2v-2h-2V8h-2v2z"/></svg></span>-->
<!--        </button>-->
<!--         <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #95a5a6;">-->
<!--            <span class="tab-text">Hot & Cold Holding</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 7h2v2h-2zm0 4h2v6h-2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #e91e63;">-->
<!--            <span class="tab-text">Portioning</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v5h-2zm0 6h2v2h-2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #27ae60;">-->
<!--            <span class="tab-text">ODC</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #A93226;">-->
<!--            <span class="tab-text">Dispatch</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #5499C7;">-->
<!--            <span class="tab-text">Pot wash</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8-8-3.59-8-8zm8 6c3.31 0 6-2.69 6-6s-2.69-6-6-6-6 2.69-6 6 2.69 6 6 6zm-1-4h2v2h-2zm0-6h2v4h-2z"/></svg></span>-->
<!--        </button>-->
<!--        <button class="tab-link" onclick="switchTab(event)" style="--tab-color: #9B59B6;">-->
<!--            <span class="tab-text">Dish Wash</span>-->
<!--            <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg></span>-->
<!--        </button>-->
<!--    </nav>-->

<!--    <main>-->
<!--        <main>-->
<!--    <div id="content-inspection" class="tab-content active">-->
<!--        <h3>Inspection Records</h3>-->
<!--        <p>This is where you'll show the data for inspections.</p>-->
<!--        <ul id="inspection-data"></ul>-->
<!--    </div>-->

<!--    <div id="content-opening-hygiene-checklist" class="tab-content">-->
<!--        <h3>Opening Hygiene Checklist</h3>-->
<!--        <p>Here are the details for the opening checklist.</p>-->
<!--        <div id="opening-checklist-data"></div>-->
<!--    </div>-->
    
<!--    <div id="content-closing-hygiene-checklist" class="tab-content">-->
<!--        <h3>Closing Hygiene Checklist</h3>-->
<!--        <p>Content for the Closing Hygiene Checklist will be displayed here.</p>-->
<!--    </div>-->

<!--    </main>-->
    
        <!--<h2 id="content-title"></h2>-->
        <!--<p>Record details and forms will appear here.</p>-->
<!--    </main>-->
<!--  </div>-->
<!--</div>-->

<div class="page-wrapper">
    <div class="page-content">
        <div id="overlay"></div>

        <header class="mobile-header">
            <button id="menu-toggle">
                <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path></svg>
            </button>
            <h1>Records</h1>
            <div style="width: 44px;"></div> </header>

        <nav>
            <div id="drawer-search-container">
                <input type="search" id="drawer-search" placeholder="Search records..." onkeyup="filterTabs()">
            </div>

            <button class="tab-link active" onclick="switchTab(event)" data-record="inspection" style="--tab-color: #3498db;">
                <span class="tab-text">Inspection</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="opening-hygiene-checklist" style="--tab-color: #f1c40f;">
                <span class="tab-text">Opening Hygiene Checklist</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 9V3.5L18.5 9H13zm-2.5 9c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm-1-4h2v3h-2v-3z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="closing-hygiene-checklist" style="--tab-color: #2c3e50;">
                <span class="tab-text">Closing Hygiene Checklist</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 9V3.5L18.5 9H13zm-2.5 9c-2.21 0-4-1.79-4-4s1.79-4 4-4c.48 0 .95.07 1.4.18-.88.8-1.4 1.94-1.4 3.22s.52 2.42 1.4 3.22c-.45.11-.92.18-1.4.18z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="briefing" style="--tab-color: #1abc9c;">
                <span class="tab-text">Briefing</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 12H5v-2h14v2zm0-4H5v-2h14v2zm0-4H5V6h14v2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="supplier-audit" style="--tab-color: #95a5a6;">
                <span class="tab-text">Supplier Audit</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm13.5-8.5l1.96 2.5H17V9.5h2.5zM18 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="supplier-evaluation-checklist" style="--tab-color: #7f8c8d;">
                <span class="tab-text">Supplier Evaluation Checklist</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="receiving-register" style="--tab-color: #27ae60;">
                <span class="tab-text">Receiving Register</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm-1.5 14.5L9 13l1.41-1.41L12 13.17l3.59-3.58L17 11l-4.5 4.5zM13 9V3.5L18.5 9H13z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="chilled-storage" style="--tab-color: #c0392b;">
                <span class="tab-text">Chilled Storage</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="frozen-storage" style="--tab-color: #8e44ad;">
                <span class="tab-text">Frozen Storage</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="stock-register" style="--tab-color: #d35400;">
                <span class="tab-text">Stock Register</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-1.45-5c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="dry-storage" style="--tab-color: #2980b9;">
                <span class="tab-text">Dry Storage</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M2 20h20v-4H2v4zm2-3h2v2H4v-2zM2 4v4h20V4H2zm4 3H4V5h2v2zm-4 7h20v-4H2v4zm2-3h2v2H4v-2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="f-v" style="--tab-color: #2ecc71;">
                <span class="tab-text">F & V</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="egg-sanitization" style="--tab-color: #e67e22;">
                <span class="tab-text">Egg Sanitization</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 4.17 2.52 7.69 6 9.12V22h2v-3.88c3.48-1.43 6-4.95 6-9.12 0-3.87-3.13-7-7-7zm0 2c1.55 0 2.9.82 3.65 2.05L7.05 14.65C5.82 13.9 5 12.55 5 11c0-2.76 2.24-5 5-5zm0 14c-1.55 0-2.9-.82-3.65-2.05l8.6-8.6C16.18 7.1 17 8.45 17 10c0 2.76-2.24 5-5 5z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="probe-thermometer-calibration" style="--tab-color: #5DADE2;">
                <span class="tab-text">Probe Themormeter Calibration</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M15 13V5c0-1.66-1.34-3-3-3S9 3.34 9 5v8c-1.21.91-2 2.37-2 4 0 2.76 2.24 5 5 5s5-2.24 5-5c0-1.63-.79-3.09-2-4zm-4-8c0-.55.45-1 1-1s1 .45 1 1v7.27c.58.14 1.12.4 1.59.75L15 13V5c0-1.66-1.34-3-3-3S9 3.34 9 5v8l.41-.32c.47-.35 1.01-.61 1.59-.75V5z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="thawing" style="--tab-color: #f39c12;">
                <span class="tab-text">Thawing</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 14h-8v-2h8v2zm0-4h-8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="cooking" style="--tab-color: #e74c3c;">
                <span class="tab-text">Cooking</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4s1.79-4 4-4c.71 0 1.38.19 1.95.52l1.05.61.47-1.18C10.23 7.5 11.08 7 12 7c1.66 0 3 1.34 3 3h-1c0-1.1-.9-2-2-2s-2 .9-2 2v.59L8.59 12 8 11.41V11c0-2.21 1.79-4 4-4s4 1.79 4 4h-1c0-1.1-.9-2-2-2s-2 .9-2 2v1h5c1.65 0 3 1.35 3 3s-1.35 3-3 3z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="oil-change" style="--tab-color: #F4D03F;">
                <span class="tab-text">Oil Change</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 13.5L11 11V5h2v5l3.5 3.5-1 1z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="cooling" style="--tab-color: #3498DB;">
                <span class="tab-text">Cooling</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="reheating" style="--tab-color: #E74C3C;">
                <span class="tab-text">Reheating</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6zm-1-8H9v2h2v2h2v-2h2v-2h-2V8h-2v2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="hot-cold-holding" style="--tab-color: #95a5a6;">
                <span class="tab-text">Hot & Cold Holding</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 7h2v2h-2zm0 4h2v6h-2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="portioning" style="--tab-color: #e91e63;">
                <span class="tab-text">Portioning</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v5h-2zm0 6h2v2h-2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="odc" style="--tab-color: #27ae60;">
                <span class="tab-text">ODC</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="dispatch" style="--tab-color: #A93226;">
                <span class="tab-text">Dispatch</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="pot-wash" style="--tab-color: #5499C7;">
                <span class="tab-text">Pot wash</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8-8-3.59-8-8zm8 6c3.31 0 6-2.69 6-6s-2.69-6-6-6-6 2.69-6 6 2.69 6 6 6zm-1-4h2v2h-2zm0-6h2v4h-2z"/></svg></span>
            </button>
            <button class="tab-link" onclick="switchTab(event)" data-record="dish-wash" style="--tab-color: #9B59B6;">
                <span class="tab-text">Dish Wash</span>
                <span class="tab-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg></span>
            </button>
        </nav>

        <main>
            <div class="record-content active" id="inspection">
                <h2>Inspection Records</h2>
                <div class="data-container">
                    </div>
            </div>
            
            <div class="record-content" id="opening-hygiene-checklist">
                <h2>Opening Hygiene Checklist</h2>
                <div class="data-container">
                    </div>
            </div>
            
            <div class="record-content" id="closing-hygiene-checklist">
                <h2>Closing Hygiene Checklist</h2>
                <div class="data-container">
                    </div>
            </div>

            <div class="record-content" id="briefing"><h2>Briefing</h2><div class="data-container"></div></div>
            <div class="record-content" id="supplier-audit"><h2>Supplier Audit</h2><div class="data-container"></div></div>
            <div class="record-content" id="supplier-evaluation-checklist"><h2>Supplier Evaluation Checklist</h2><div class="data-container"></div></div>
            <div class="record-content" id="receiving-register"><h2>Receiving Register</h2><div class="data-container"></div></div>
            <div class="record-content" id="chilled-storage"><h2>Chilled Storage</h2><div class="data-container"></div></div>
            <div class="record-content" id="frozen-storage"><h2>Frozen Storage</h2><div class="data-container"></div></div>
            <div class="record-content" id="stock-register"><h2>Stock Register</h2><div class="data-container"></div></div>
            <div class="record-content" id="dry-storage"><h2>Dry Storage</h2><div class="data-container"></div></div>
            <div class="record-content" id="f-v"><h2>F & V</h2><div class="data-container"></div></div>
            <div class="record-content" id="egg-sanitization"><h2>Egg Sanitization</h2><div class="data-container"></div></div>
            <div class="record-content" id="probe-thermometer-calibration"><h2>Probe Thermometer Calibration</h2><div class="data-container"></div></div>
            <div class="record-content" id="thawing"><h2>Thawing</h2><div class="data-container"></div></div>
            <div class="record-content" id="cooking"><h2>Cooking</h2><div class="data-container"></div></div>
            <div class="record-content" id="oil-change"><h2>Oil Change</h2><div class="data-container"></div></div>
            <div class="record-content" id="cooling"><h2>Cooling</h2><div class="data-container"></div></div>
            <div class="record-content" id="reheating"><h2>Reheating</h2><div class="data-container"></div></div>
            <div class="record-content" id="hot-cold-holding"><h2>Hot & Cold Holding</h2><div class="data-container"></div></div>
            <div class="record-content" id="portioning"><h2>Portioning</h2><div class="data-container"></div></div>
            <div class="record-content" id="odc"><h2>ODC</h2><div class="data-container"></div></div>
            <div class="record-content" id="dispatch"><h2>Dispatch</h2><div class="data-container"></div></div>
            <div class="record-content" id="pot-wash"><h2>Pot wash</h2><div class="data-container"></div></div>
            <div class="record-content" id="dish-wash"><h2>Dish Wash</h2><div class="data-container"></div></div>

        </main>
    </div>
</div>

@include('layouts.footer')


<!-- Popup Modal -->
<!-- Multi-Select Modal -->
<div class="modal fade" id="multiSelectModal" tabindex="-1" aria-labelledby="multiSelectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="multiSelectModalLabel">Select Multiple Options</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="multiSelectForm">
          <label for="multiSelect">Choose Options:</label>
          <select id="multiSelect" name="options[]" class="form-control select2" multiple="multiple" style="width: 100%;">
            <option value="Option 1">Option 1</option>
            <option value="Option 2">Option 2</option>
            <option value="Option 3">Option 3</option>
            <option value="Option 4">Option 4</option>
          </select>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitMultiSelect()">Save</button>
      </div>
      
    </div>
  </div>
</div>




   @stack('js')
      </div>

      </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!--plugins-->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
    <!--app JS-->
    <script src="{{asset('assets/js/app.js')}}"></script>
        <script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/plugins/chartjs/js/Chart.extension.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
    <script src="{{asset('assets/js/index.js')}}"></script>
	
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		
		    	<script src="{{asset('assets/js/select2-custom.js')}}"></script>

	
	
	    <!--Data Table JS-->
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	
	    	<script src="{{asset('assets/plugins/fancy-file-uploader/jquery.ui.widget.js')}}"></script>
	<script src="{{asset('assets/plugins/fancy-file-uploader/jquery.fileupload.js')}}"></script>
	<script src="{{asset('assets/plugins/fancy-file-uploader/jquery.iframe-transport.js')}}"></script>
	<script src="{{asset('assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js')}}"></script>
	<script src="{{asset('assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js')}}"></script>

	
	
	 <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- PDF Generation Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    
	<script>
    function openMyPopup() {
        var myModal = new bootstrap.Modal(document.getElementById('myPopupModal'));
        myModal.show();
    }
</script>

	
</body>



 @yield('footerscript')

					<?php if (auth()->check()) {
		
					$is_role = Auth::user()->is_role;
					
					?>

<?php } else {
		
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

					
					<script type="text/javascript">
    window.location = "https://efsms.in/admin/public/login";
</script>
					
					
<?php } ?>

<script>
// A simple object to hold dummy data.
// In a real application, you'd fetch this from a server or database.
const dynamicData = {
    'inspection': [
        { date: '2025-09-18', notes: 'Kitchen equipment checked, all good.' },
        { date: '2025-09-15', notes: 'Pest control inspection completed.' }
    ],
    'opening-hygiene-checklist': {
        checkedBy: 'Rahul Sharma',
        date: '2025-09-20',
        notes: 'All items checked and signed off.'
    },
    'closing-hygiene-checklist': {
        checkedBy: 'Priya Verma',
        date: '2025-09-19',
        notes: 'Floor cleaned, garbage disposed.'
    },
    'briefing': 'Today\'s briefing covered new menu items and guest feedback.',
    'supplier-audit': 'Supplier ABC audit report.',
    'supplier-evaluation-checklist': 'Evaluation of new supplier complete.',
    'receiving-register': 'Today\'s received goods updated in register.',
    'chilled-storage': 'Temperatures in chilled storage checked.',
    'frozen-storage': 'Temperatures in frozen storage checked.',
    'stock-register': 'Stock count for kitchen items completed.',
    'dry-storage': 'Dry storage area cleaned.',
    'f-v': 'Fruits and vegetables are fresh and stored properly.',
    'egg-sanitization': 'Eggs sanitized and stored.',
    'probe-thermometer-calibration': 'Probe calibrated successfully.',
    'thawing': 'Chicken stock and fish were moved to the thawing unit.',
    'cooking': 'All dishes prepared according to recipe standards.',
    'oil-change': 'Frying oil changed for both deep fryers.',
    'cooling': 'Soups and sauces cooled to safe temperatures.',
    'reheating': 'Leftover food reheated and checked for temperature.',
    'hot-cold-holding': 'Hot food held above 60°C, cold food below 5°C.',
    'portioning': 'Portions accurately weighed and sealed.',
    'odc': 'ODC report submitted and approved.',
    'dispatch': 'Morning dispatches completed on time.',
    'pot-wash': 'Pot wash station sanitized and ready.',
    'dish-wash': 'Dishwasher run cycle completed.'
};

function switchTab(event) {
    event.preventDefault();

    // Remove 'active' class from all tab buttons and content sections
    document.querySelectorAll('.tab-link').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.record-content').forEach(content => content.classList.remove('active'));

    // Add 'active' class to the clicked tab button
    const clickedTab = event.currentTarget;
    clickedTab.classList.add('active');

    // Get the data-record attribute to find the correct content section
    const recordId = clickedTab.getAttribute('data-record');
    
    // Find and show the corresponding content section
    const activeContent = document.getElementById(recordId);
    if (activeContent) {
        activeContent.classList.add('active');
        
        // Dynamically load the data for the selected tab
        loadData(recordId);
    }
}

function loadData(recordId) {
    const dataContainer = document.querySelector(`#${recordId} .data-container`);
    dataContainer.innerHTML = ''; // Clear existing data

    const data = dynamicData[recordId];

    if (!data) {
        dataContainer.innerHTML = '<p>No data available for this record type.</p>';
        return;
    }

    if (Array.isArray(data)) {
        let html = '<ul class="data-list">';
        data.forEach(item => {
            html += `<li><strong>Date:</strong> ${item.date} - ${item.notes}</li>`;
        });
        html += '</ul>';
        dataContainer.innerHTML = html;
    } else if (typeof data === 'object') {
        let html = '<ul class="data-list">';
        for (const key in data) {
            // Capitalize and format the key for display
            const formattedKey = key.replace(/([A-Z])/g, ' $1').replace(/^./, str => str.toUpperCase());
            html += `<li><strong>${formattedKey}:</strong> ${data[key]}</li>`;
        }
        html += '</ul>';
        dataContainer.innerHTML = html;
    } else {
        dataContainer.innerHTML = `<p>${data}</p>`;
    }
}

// Automatically switch to the first active tab on page load
document.addEventListener('DOMContentLoaded', () => {
    const firstTab = document.querySelector('.tab-link.active');
    if (firstTab) {
        firstTab.click();
    }
});
</script>    
   <!--<script>-->
   <!--     const menuToggle = document.getElementById('menu-toggle');-->
   <!--     const overlay = document.getElementById('overlay');-->
   <!--     const tabLinks = document.querySelectorAll('.tab-link');-->
   <!--     const body = document.body;-->
   <!--     const contentTitle = document.getElementById('content-title');-->

        // Set the initial title based on the default active tab
   <!--     document.addEventListener('DOMContentLoaded', () => {-->
   <!--         const activeTab = document.querySelector('.tab-link.active .tab-text');-->
   <!--         if (activeTab) {-->
   <!--             contentTitle.innerText = activeTab.innerText;-->
   <!--         }-->
   <!--     });-->

   <!--     function toggleDrawer() {-->
   <!--         body.classList.toggle('drawer-open');-->
   <!--     }-->

   <!--     function closeDrawer() {-->
   <!--         body.classList.remove('drawer-open');-->
   <!--     }-->
        
   <!--     menuToggle.addEventListener('click', toggleDrawer);-->
   <!--     overlay.addEventListener('click', closeDrawer);-->

   <!--     function switchTab(evt) {-->
   <!--         tabLinks.forEach(tab => tab.classList.remove('active'));-->
   <!--         const currentTab = evt.currentTarget;-->
   <!--         currentTab.classList.add('active');-->

   <!--         const tabText = currentTab.querySelector('.tab-text').innerText;-->
   <!--         contentTitle.innerText = tabText;-->
            
   <!--         if (window.innerWidth <= 768) {-->
   <!--             closeDrawer();-->
   <!--         }-->
   <!--     }-->

   <!--     function filterTabs() {-->
   <!--         const searchInput = document.getElementById('drawer-search');-->
   <!--         const filter = searchInput.value.toLowerCase();-->
   <!--         const tabsInNav = document.querySelectorAll("nav .tab-link");-->

   <!--         tabsInNav.forEach(tab => {-->
   <!--             const tabText = tab.querySelector('.tab-text').textContent.toLowerCase();-->
   <!--             if (tabText.includes(filter)) {-->
   <!--                 tab.style.display = "flex";-->
   <!--             } else {-->
   <!--                 tab.style.display = "none";-->
   <!--             }-->
   <!--         });-->
   <!--     }-->
   <!-- </script>-->
    


<script type="text/javascript">

$('#selectcorporate').change(function(){ 
    var id = $(this).val();
	

	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.regional_id').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                
                unit_list(data[0]['id']);
                
                
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.regional_id').append(selOpts);
           }
        });
});
	
	
	
	
$('.regional_id').change(function(){ 

      var id = $(this).val();

	unit_list(id);
});




function unit_list(id){
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.hotel_name').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.hotel_name').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });  
    
}
 
	
	$('.mydepartment').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('department_location') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mydepartment1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mydepartment1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});



</script>
<script>

function openRegional(userId) {
   $(".openRegional_" + userId).toggle();
}

function openUnit(userId) {
   $(".openUnit_" + userId).toggle();
}



//     $(".btn-regnl-1").click(function(){
        
//   $(".tab-two ").toggle();
// });
// $(".btn-unit-three").click(function(){
//   $(".tab-three").toggle();
// });



</script>


</html>
