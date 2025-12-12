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
 
<div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <!--<h5 class="align-self-center mb-0">Trainers</h5>-->
                                    <span>
                                        
                                        <a href="{{route('templates_store')}}" class="btn btn-primary px-3">+ Add New</a>
                                       
                                    </span>
                                </div>
                                <hr>
                                <div class="row row-cols-auto g-3 mb-3 p-3">
                                    <div class="col-12">
                                        <div class="col-12 align-self-center">
                                            <div class="table-responsive">
                                                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="example_length"><label>Show <select name="example_length" aria-controls="example" class="form-select form-select-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="example_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="example" class="table table-striped table-bordered data-t dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="example_info">
                                                    <thead>
                                                        <tr role="row"><th width="20" class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="#: activate to sort column ascending" style="width: 40px;">#</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 173px;">Name</th><th class="text-center sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending" style="width: 286px;">Description</th><th class="text-right sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 113px;">Action</th></tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        @php $i=1; @endphp
                                                        @foreach($list as $lists)
                                                    <tr role="row" class="odd">
                                                            <td class="">{{$i}}</td>
                                                            <td>{{$lists->template_name ?? ''}}</td>
                                                            <td class="text-center">{{$lists->template_desc ?? ''}}
                                                            </td>
                                               

                                                            <td class="text-right">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-outline-secondary"><i class="bx bx-edit me-0"></i></button>
                                                                    
                                                   <a href="{{route('template_delete',$lists->id ?? '')}}" class="btn btn-outline-danger"><i class="bx bx-trash me-0"></i></a>
                                                   <a href="{{route('template_details',$lists->id ?? '')}}" class="btn btn-outline-danger"><i class="bx bxs-show"></i></a>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                         @php $i++; @endphp
                                                        @endforeach</tbody>
                                                </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example_previous"><a href="#" aria-controls="example" data-dt-idx="0" tabindex="0" class="page-link">Prev</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="example_next"><a href="#" aria-controls="example" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
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

   