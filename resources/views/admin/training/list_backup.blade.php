@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<style>
        .step-number {
            border-top: #333 2px solid;
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            position: relative;
        }

        .step-number:before {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
        }

        .step-number:after {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
            right: 0;
        }

        .step-number span {
            margin-top: -15px;
            text-align: center;
            z-index: 1;
        }

        .step-number em {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            font-style: normal;
            line-height: 30px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .ins-t td {
            font-size: 13px;
            padding: 5px 0px;
        }

        .cam-img {
            width: 100%;
            background: #f7f7f7;
            height: 80%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .imageuploadify {
            min-height: 150px;
        }

        .imageuploadify-message {
            display: none !important;
        }

        .imageuploadify .imageuploadify-images-list i {
            font-size: 3em;
            height: 50px;
        }

        /* Template List CSS*/

        .img-profile {
            width: 8rem;
            height: 8rem;
            padding: 0px;
            flex-shrink: 0;
            -webkit-box-flex: 0;
            flex-grow: 0;
            background-color: rgb(255, 255, 255);
            border: 1px dashed rgb(191, 198, 212);
            border-radius: 12px;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            font-size: 0.875rem;
            flex-direction: row;
            align-self: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding: 1.5rem 2rem;
            font-weight: 500;
            text-align: center;
            position: relative;
            color: rgb(103, 93, 244);
            cursor: pointer;
        }

        .template-logo-hover {
            display: none;
        }

        .img-profile:hover .template-logo-hover {
            font-weight: 500;
            color: rgb(84, 95, 112);
            display: flex;
            flex-direction: column;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            align-items: center;
            gap: 1rem;
            border-radius: 12px;
            position: absolute;
            background-color: rgb(219 223 234);
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        .title-editable-block {
            font-size: 30px;
            padding: 0 0px;
            font-weight: 600;
            line-height: 1.1;
            margin-bottom: 20px;
            outline: none;
            color: rgb(55, 53, 47);
            caret-color: rgb(55, 53, 47);
            white-space: pre-wrap;
            word-break: break-word;
            cursor: text;
            display: inline-block;
        }

        .title-editable-block:empty::before {
            content: attr(placeholder);
            display: block;
            -webkit-text-fill-color: rgb(130, 142, 160);
        }

        .content-editable-block {
            line-height: 1.1;
            outline: none;
            cursor: text;
            min-height: 30px;
            line-height: 1.5;
            padding: 3px 0px;
            outline: none;
            display: inline-block;
            color: rgb(55, 53, 47);
            caret-color: rgb(55, 53, 47);
            white-space: inherit;
            word-break: break-word;
        }

        .content-editable-block:empty::before {
            content: attr(placeholder);
            display: block;
            -webkit-text-fill-color: rgb(187, 186, 184);
        }

        .accordion-button::before {
            flex-shrink: 0;
            width: 1.25rem;
            height: 1.25rem;
            margin-left: 0;
            content: "";
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-size: 1.25rem;
            margin-right: 10px;
            transition: transform .2s ease-in-out;
            transform: rotate(-90deg);
        }

        .accordion-button::after {
            display: none;
        }

        .accordion-button:focus {
            border-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0);
        }

        .accordion-button:not(.collapsed) {
            color: #333;
            background-color: #fff;
        }

        .accordion-button:not(.collapsed)::before {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transform: rotate(0deg);
        }

        .darg-icon {
            cursor: -webkit-grab;
            cursor: grab;
            width: 30px;
            height: 30px;
            position: relative;
            overflow: hidden;
            outline: none;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            text-align: center;
            border-radius: 50%;
            display: inline-flex;
            z-index: 1;
        }

        .darg-icon:hover {
            inset: 0px;
            background: rgb(191, 198, 212);
            opacity: 1;
            border-radius: 100%;
            transition: transform 500ms ease-out 0s;
        }

        .required-icon {
            width: 10px;
            text-align: center;
        }

        .arrow-icon1 {
            float: right;
            cursor: pointer;
        }

        .info {
            font-size: 0.8rem;
            font-weight: 400;
            margin-right: 0.4rem;
            display: inline-block;
            vertical-align: inherit;
            white-space: nowrap;
            line-height: initial;
            padding: 0.2rem 0.4rem;
            border-radius: 0.75rem;
            max-width: 8.75rem;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 0;
            color: rgb(19, 133, 95);
            border: 1px solid transparent;
            background-color: rgba(19, 133, 95, 0.1);
        }

        .risk {
            font-size: 0.8rem;
            font-weight: 400;
            margin-right: 0.4rem;
            display: inline-block;
            vertical-align: inherit;
            white-space: nowrap;
            line-height: initial;
            padding: 0.2rem 0.4rem;
            border-radius: 0.75rem;
            max-width: 8.75rem;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 0;
            color: rgb(198, 0, 34);
            border: 1px solid transparent;
            background-color: rgba(198, 0, 34, 0.1);
        }

        .na {
            font-size: 0.8rem;
            font-weight: 400;
            margin-right: 0.4rem;
            display: inline-block;
            vertical-align: inherit;
            white-space: nowrap;
            line-height: initial;
            padding: 0.2rem 0.4rem;
            border-radius: 0.75rem;
            max-width: 8.75rem;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 0;
            color: rgb(112, 112, 112);
            border: 1px solid transparent;
            background-color: rgba(112, 112, 112, 0.1);
        }

        .border-l {
            border-left: #dee2e6 thin solid;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: rgb(191, 198, 212);
            border-style: solid;
            border-width: thin;
        }

        .table>:not(:last-child)>:last-child>* {
            border-bottom-color: rgb(191, 198, 212);
        }

        .fr1::before {
            -webkit-text-fill-color: #000 !important
        }

        .fr1:focus {
            border: #0d6efd 2px solid;
            border-radius: 6px;
            padding: 6px;
        }

        .p-icon {
            display: block;
            background: rgb(255, 255, 255);
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            padding: 0.1rem;
            position: absolute;
            right: 4px;
            top: 22px;
            border: 1px solid rgb(171, 181, 196);
        }

        .add-p {
            display: inline-block;
            font-size: 0.875rem;
            pointer-events: auto;
            cursor: pointer;
            text-decoration: underline;
            color: rgb(130, 142, 160);
        }

        .data-t {
            border: solid rgb(191, 198, 212) thin;
            border-radius: 4px;
        }

        .data-t thead tr {
            position: relative;
            background-color: rgb(233, 238, 246);
            border-top-left-radius: 0.3rem;
            border-top-right-radius: 0.3rem;
        }

        table.data-t.table-bordered.dataTable th,
        table.table-bordered.dataTable td {
            border-left-width: 0;
            border-right-width: 0;
        }

        .data-t tr th:first-child::before,
        .data-t tr th:first-child::after,
        .data-t tr th:last-child::before,
        .data-t tr th:last-child::after {
            display: none;
        }

        .data-t tr th:first-child,
        .data-t tr td:first-child {
            padding-right: 0px !important;
            text-align: center;
            padding-left: 15px !important;
            width: 30px;
        }

        .data-t .img-logo {
            width: 30px;
            margin-right: 5px;
            border-radius: 50%;
            height: 30px;
        }

        .data-t .form-check-input[type=checkbox] {
            border-radius: .25em;
            width: 20px;
            height: 20px;
            margin-top: 0px;
        }

        .table.data-t>:not(:last-child)>:last-child>* {
            border-bottom-color: rgb(191, 198, 212);
            padding-right: 10px !important;
            /* width: 120px !important; */
        }

        .data-t tr th:nth-child(2)::before,
        .data-t tr th:nth-child(2)::after {
            display: none;
        }

        .data-t tr th:nth-child(4)::before,
        .data-t tr th:nth-child(4)::after {
            display: none;
        }

        .data-t tr th:nth-child(5)::before,
        .data-t tr th:nth-child(5)::after {
            display: none;
        }

        .data-t tr th:nth-child(6)::before,
        .data-t tr th:nth-child(6)::after {
            display: none;
        }

        .data-t .dropdown-toggle::after {
            display: none;
        }

        .data-t .dropdown-menu {
            font-weight: 400;
        }

        .data-t .dropdown-menu li {
            width: 100%;
            padding: 5px 15px;
        }

        .data-t tr {
            cursor: pointer;
        }

        .data-t.table-bordered>:not(caption)>*>* {
            border-width: 1px 1px;
        }

        /* 27/12/203 new css*/

        .input-switch {
            display: none;
        }

        .label-switch {
            display: inline-block;
            position: relative;
        }

        .label-switch::before,
        .label-switch::after {
            content: "";
            display: inline-block;
            cursor: pointer;
            transition: all 0.5s;
        }

        .label-switch::before {
            width: 3em;
            height: 1em;
            border: 1px solid #b90731;
            border-radius: 4em;
            background: #e0525d;
        }

        .label-switch::after {
            position: absolute;
            left: 0;
            top: -3px;
            width: 1.5em;
            height: 1.5em;
            border: 1px solid #b90731;
            border-radius: 4em;
            background: #e0525d;
        }

        .input-switch:checked~.label-switch::before {
            background: #00a900;
            border-color: #008e00;
        }

        .input-switch:checked~.label-switch::after {
            left: unset;
            right: 0;
            background: #00ce00;
            border-color: #009a00;
        }

        .info-text {
            display: inline-block;
        }

        .info-text::before {
            content: "Inactive";
        }

        .input-switch:checked~.info-text::before {
            content: "Active";
        }
    </style>
@section('content')
 @include('admin.popups.templates.addtemplate')
<div class="row">
                    <div class="col">
                       <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="align-self-center mb-0">Template List</h5>
                                      <span>  
                                        <button type="button" class="btn btn-outline-dark px-3 me-3">+ Add Filter</button>
                                        <a href="{{route('templates_store')}}" class="btn btn-primary px-3">+ Create</a>
                                      </span>
                                    </div>
                                    <hr>
                                    <div class="row row-cols-auto g-3 mb-3 p-3">
                                        <div class="col-12">
						             <div class="col-12 align-self-center">
                                        <div class="table-responsive">
                                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="example_length"><label>Show <select name="example_length" aria-controls="example" class="form-select form-select-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="example_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="example" class="table table-striped table-bordered data-t dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="example_info">
                                                <thead>
                                                    <tr role="row"><th width="20" class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="
                                                        
                                                            
                                                        
                                                    : activate to sort column descending" style="width: 57px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        </div>
                                                    </th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Template: activate to sort column ascending" style="width: 215px;">Template</th><th class="text-center sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Last published: activate to sort column ascending" style="width: 174px;">Last published</th><th class="text-center sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Scheduled: activate to sort column ascending" style="width: 130px;">Scheduled</th><th class="text-center sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Access: activate to sort column ascending" style="width: 108px;">Access</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 229px;"></th><th class="text-right sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="
                                                            
                                                                
                                                                    
                                                                
                                                                    
                                                                        
                                                                         Show / hide columns
                                                                    
                                                                    
                                                                        
                                                                         Last published
                                                                    
                                                                    
                                                                        
                                                                         Last modified
                                                                    
                                                                    
                                                                        
                                                                         Scheduled
                                                                    
                                                                    
                                                                        
                                                                         Access
                                                                    
                                                                
                                                            
                                                             : activate to sort column ascending" style="width: 94px;">
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-cog me-0"></i></button>
                                                                <ul class="dropdown-menu py-3" style="margin: 0px;">
                                                                    <li><div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                        <label class="form-check-label ms-2" for="flexCheckDefault"> Show / hide columns</label>
                                                                    </div></li>
                                                                    <li><div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                        <label class="form-check-label ms-2" for="flexCheckDefault"> Last published</label>
                                                                    </div></li>
                                                                    <li><div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                        <label class="form-check-label ms-2" for="flexCheckDefault"> Last modified</label>
                                                                    </div></li>
                                                                    <li><div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                        <label class="form-check-label ms-2" for="flexCheckDefault"> Scheduled</label>
                                                                    </div></li>
                                                                    <li><div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                        <label class="form-check-label ms-2" for="flexCheckDefault"> Access</label>
                                                                    </div></li>
                                                                </ul>
                                                            </div>
                                                             </th></tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    
                                                        
                                                            
                                                                
                                                                    
                                                                        
                                                                            
                                                                                
                                                                                    
                                                                                        
                                                 
                                                <tr role="row" class="odd">
                                                    <td class="sorting_1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        </div>
                                                    </td>
                                            <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                        <td class="text-center">21 hours ago</td>
                                                        <td class="text-center">No</td>
                                                        <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                        <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>

                                                        <td class="text-right">
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
        <ul class="dropdown-menu py-3" style="margin: 0px; width:220px;">
            <li><div style="margin-right: 8px; float: left;"><svg width="18" height="18" viewBox="0 0 14 14" focusable="false"><path d="M2.313 9.734v1.954h1.953l5.76-5.761-1.953-1.953-5.76 5.76zm9.223-5.318a.519.519 0 0 0 0-.734l-1.218-1.219a.519.519 0 0 0-.735 0l-.953.953 1.953 1.953.953-.953z" fill-rule="nonzero" fill="#1f2533"></path></svg></div>Edit template</li>
            <li><div style="margin-right: 8px; float: left;"><svg viewBox="0 0 24 24" width="18" height="18" focusable="false"><path d="M0 0h24v24H0z" fill="none"></path><path fill="#1f2533" d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"></path></svg></div>Schedule</li>
            <li><div style="margin-right: 8px; float: left;"><svg width="18" height="18" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.41797 4.41797C7.86328 3.97266 8.39062 3.75 9 3.75C9.60938 3.75 10.1367 3.97266 10.582 4.41797C11.0273 4.86328 11.25 5.39062 11.25 6C11.25 6.60938 11.0273 7.13672 10.582 7.58203C10.1367 8.02734 9.60938 8.25 9 8.25C8.39062 8.25 7.86328 8.02734 7.41797 7.58203C6.97266 7.13672 6.75 6.60938 6.75 6C6.75 5.39062 6.97266 4.86328 7.41797 4.41797ZM6.32812 8.67188C7.07812 9.39844 7.96875 9.76172 9 9.76172C10.0312 9.76172 10.9102 9.39844 11.6367 8.67188C12.3867 7.92188 12.7617 7.03125 12.7617 6C12.7617 4.96875 12.3867 4.08984 11.6367 3.36328C10.9102 2.61328 10.0312 2.23828 9 2.23828C7.96875 2.23828 7.07812 2.61328 6.32812 3.36328C5.60156 4.08984 5.23828 4.96875 5.23828 6C5.23828 7.03125 5.60156 7.92188 6.32812 8.67188ZM3.97266 1.92188C5.47266 0.890625 7.14844 0.375 9 0.375C10.8516 0.375 12.5273 0.890625 14.0273 1.92188C15.5273 2.95312 16.6055 4.3125 17.2617 6C16.6055 7.6875 15.5273 9.04688 14.0273 10.0781C12.5273 11.1094 10.8516 11.625 9 11.625C7.14844 11.625 5.47266 11.1094 3.97266 10.0781C2.47266 9.04688 1.39453 7.6875 0.738281 6C1.39453 4.3125 2.47266 2.95312 3.97266 1.92188Z" fill="#1f2533"></path></svg></div>Manage access</li>
            <li><div style="margin-right: 8px; float: left;"><svg width="18" height="18" viewBox="0 0 24 24"><g id="icons/nav/inspections" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><polyline id="Path" stroke="#1f2533" stroke-width="1.5" points="15.8095238 4.17391304 19.6190476 4.17391304 19.6190476 20.6086957 4.38095238 20.6086957 4.38095238 4.17391304 8.19047619 4.17391304"></polyline><polyline id="Path" stroke="#1f2533" stroke-width="1.5" points="9 14 11 16 15 12"></polyline><path d="M8.19047619,3.39130435 L8.19047619,8.08695652 L10.4761905,8.08695652 C10.4761905,7.22217391 11.1580952,6.52173913 12,6.52173913 C12.8419048,6.52173913 13.5238095,7.22217391 13.5238095,8.08695652 L15.8095238,8.08695652 L15.8095238,3.39130435 L8.19047619,3.39130435 Z" id="Path" stroke="#1f2533" stroke-width="1.5"></path></g></svg></div>View inspections</li>
            <li><hr style="margin: 0.5rem 0;"></li>
            <li><div style="margin-right: 8px; float: left;"><svg viewBox="0 0 12 12" width="18" height="18" focusable="false"><g fill="none" fill-rule="evenodd"><g transform="translate(-422 -70)"><g transform="translate(420 68)"><path id="Path" d="M0 0h16v16H0z"></path><g id="ungroup" transform="translate(2 2)" fill="#1f2533" fill-rule="nonzero"><path d="M8.25 9H.75A.75.75 0 0 1 0 8.25V.75A.75.75 0 0 1 .75 0h7.5A.75.75 0 0 1 9 .75v7.5a.75.75 0 0 1-.75.75z" id="Path"></path><path d="M11.25 12H3v-1.5h7.5V3H12v8.25a.75.75 0 0 1-.75.75z" id="Path"></path></g></g></g></g></svg></div>Duplicate template</li>
            <li><div style="margin-right: 8px; float: left;"><svg viewBox="0 0 24 24" width="18" height="18" focusable="false"><path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM12 17.5L6.5 12H10v-2h4v2h3.5L12 17.5zM5.12 5l.81-1h12l.94 1H5.12z" fill="#1f2533"></path><path d="M0 0h24v24H0z" fill="none"></path></svg></div>Archive template</li>
            <li><div style="margin-right: 8px; float: left;"><svg width="18" height="18" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"></path><path fill="#1f2533" d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"></path></svg></div>Bookmark</li>
            <li><hr style="margin: 0.5rem 0;"></li>
            <li><div style="margin-right: 8px; float: left;"><svg viewBox="0 0 16 16" fill="none" width="18" height="18" focusable="false"><path d="M4.195 5.138a.667.667 0 010-.943L7.53.862c.26-.26.682-.26.942 0l3.334 3.333a.667.667 0 11-.943.943L8.667 2.943v7.724a.667.667 0 11-1.334 0V2.943L5.138 5.138a.667.667 0 01-.943 0z" fill="#1f2533"></path><path d="M1.333 10c.369 0 .667.299.667.667v2.666c0 .369.298.667.667.667h10.666a.667.667 0 00.667-.667v-2.666a.667.667 0 011.333 0v2.666a2 2 0 01-2 2H2.667a2 2 0 01-2-2v-2.666c0-.368.298-.667.666-.667z" fill="#1f2533"></path></svg></div>Upload to Public Library</li>
            <li><div style="margin-right: 8px; float: left;"><svg viewBox="0 0 24 24" width="18" height="18" fill="#1f2533" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M15 21h-2v-2h2v2zm-2-7h-2v5h2v-5zm8-2h-2v4h2v-4zm-2-2h-2v2h2v-2zM7 12H5v2h2v-2zm-2-2H3v2h2v-2zm7-5h2V3h-2v2zm-7.5-.5v3h3v-3h-3zM9 9H3V3h6v6zm-4.5 7.5v3h3v-3h-3zM9 21H3v-6h6v6zm7.5-16.5v3h3v-3h-3zM21 9h-6V3h6v6zm-2 10v-3h-4v2h2v3h4v-2h-2zm-2-7h-4v2h4v-2zm-4-2H7v2h2v2h2v-2h2v-2zm1-1V7h-2V5h-2v4h4zM6.75 5.25h-1.5v1.5h1.5v-1.5zm0 12h-1.5v1.5h1.5v-1.5zm12-12h-1.5v1.5h1.5v-1.5z"></path></svg></div>Get QR code</li>
           
                                                                    
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr><tr role="row" class="even">
                                                        <td class="sorting_1">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                            </div>
                                                        </td>
                                                <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                            <td class="text-center">21 hours ago</td>
                                                            <td class="text-center">No</td>
                                                            <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                            <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
    
                                                            <td class="text-right">
                                                                <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                            </td>
                                                        </tr><tr role="row" class="odd">
                                                            <td class="sorting_1">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                </div>
                                                            </td>
                                                    <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                <td class="text-center">21 hours ago</td>
                                                                <td class="text-center">No</td>
                                                                <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
        
                                                                <td class="text-right">
                                                                    <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                </td>
                                                            </tr><tr role="row" class="even">
                                                                <td class="sorting_1">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                    </div>
                                                                </td>
                                                        <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                    <td class="text-center">21 hours ago</td>
                                                                    <td class="text-center">No</td>
                                                                    <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                    <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
            
                                                                    <td class="text-right">
                                                                        <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                    </td>
                                                                </tr><tr role="row" class="odd">
                                                                    <td class="sorting_1">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                        </div>
                                                                    </td>
                                                            <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                        <td class="text-center">21 hours ago</td>
                                                                        <td class="text-center">No</td>
                                                                        <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                        <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
                
                                                                        <td class="text-right">
                                                                            <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                        </td>
                                                                    </tr><tr role="row" class="even">
                                                                        <td class="sorting_1">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                            </div>
                                                                        </td>
                                                                <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                            <td class="text-center">21 hours ago</td>
                                                                            <td class="text-center">No</td>
                                                                            <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                            <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
                    
                                                                            <td class="text-right">
                                                                                <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                            </td>
                                                                        </tr><tr role="row" class="odd">
                                                                            <td class="sorting_1">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                                </div>
                                                                            </td>
                                                                    <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                                <td class="text-center">21 hours ago</td>
                                                                                <td class="text-center">No</td>
                                                                                <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                                <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
                        
                                                                                <td class="text-right">
                                                                                    <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                                </td>
                                                                            </tr><tr role="row" class="even">
                                                                                <td class="sorting_1">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                                    </div>
                                                                                </td>
                                                                        <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                                    <td class="text-center">21 hours ago</td>
                                                                                    <td class="text-center">No</td>
                                                                                    <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                                    <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
                            
                                                                                    <td class="text-right">
                                                                                        <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                                    </td>
                                                                                </tr><tr role="row" class="odd">
                                                                                    <td class="sorting_1">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                                        </div>
                                                                                    </td>
                                                                            <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                                        <td class="text-center">21 hours ago</td>
                                                                                        <td class="text-center">No</td>
                                                                                        <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                                        <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
                                
                                                                                        <td class="text-right">
                                                                                            <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                                        </td>
                                                                                    </tr><tr role="row" class="even">
                                                                                        <td class="sorting_1">
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                                                            </div>
                                                                                        </td>
                                                                                <td><img src="../admin-html/assets/images/fss_logo.png" class="img-logo"> Safe Food Mitra</td>
                                                                                            <td class="text-center">21 hours ago</td>
                                                                                            <td class="text-center">No</td>
                                                                                            <td class="text-center"><svg data-anchor="org-svg" width="14" height="14" viewBox="0 0 24 24"><g><rect fill="#3f495a" height="7" width="3" x="4" y="10"></rect><rect fill="#3f495a" height="7" width="3" x="10.5" y="10"></rect><rect fill="#3f495a" height="3" width="20" x="2" y="19"></rect><rect fill="#3f495a" height="7" width="3" x="17" y="10"></rect><polygon fill="#3f495a" points="12,1 2,6 2,8 22,8 22,6"></polygon></g></svg> All users</td>
                                                                                            <td class="text-center"><button class="btn btn-outline-primary px-3">Start inspection</button></td>
                                    
                                                                                            <td class="text-right">
                                                                                                <button class="btn btn-outline-secondary"><svg width="21" height="18" viewBox="0 0 14 14" focusable="false"><g transform="translate(5.542 1.458)" fill="#1f2533" fill-rule="nonzero"><circle transform="rotate(90 1.458 5.542)" cx="1.458" cy="5.542" r="1.458"></circle><circle transform="rotate(90 1.458 9.625)" cx="1.458" cy="9.625" r="1.458"></circle><circle transform="rotate(90 1.458 1.458)" cx="1.458" cy="1.458" r="1.458"></circle></g></svg></button>
                                                                                            </td>
                                                                                        </tr></tbody>                                                
                                            </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example_info" role="status" aria-live="polite">Showing 1 to 10 of 11 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example_previous"><a href="#" aria-controls="example" data-dt-idx="0" tabindex="0" class="page-link">Prev</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="example_next"><a href="#" aria-controls="example" data-dt-idx="3" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                                        </div>
                                            
                                        </div>
                                       
                                    </div> 
                                </div>
                                
                            </div>
                        </div>

                    </div>
                    <!--end row-->
                </div>

@endsection

   