@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<style>
        .step-number {border-top: #333 2px solid; width: 100%; display: flex; justify-content: space-between; margin-top:30px; position: relative;}
    .step-number:before{content: ""; background: #fff; display: block; position: absolute; height: 3px; width: 27px; top: -2px; z-index: 0;}
    .step-number:after{content: ""; background: #fff; display: block; position: absolute; height: 3px; width: 27px; top: -2px; z-index: 0; right: 0;}
    .step-number span{margin-top: -15px; text-align: center; z-index: 1;}
    .step-number em {width: 30px; height: 30px; border-radius: 50%; display: inline-block; text-align: center; font-style: normal; line-height: 30px; font-weight: 600; margin-bottom: 5px; }
    .ins-t td{ font-size: 13px; padding:5px 0px;}
    .cam-img {width: 100%;background: #f7f7f7;height: 80%;border-radius: 6px;display: flex;align-items: center;justify-content: center;cursor: pointer;}
    .imageuploadify {min-height: 150px;}
    .imageuploadify-message{ display: none !important;}
    .imageuploadify .imageuploadify-images-list i {font-size: 3em;height: 50px;}

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
    text-align: center; position: relative;
    color: rgb(103, 93, 244); cursor: pointer;
}

.template-logo-hover{display:none;}

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
.title-editable-block { font-size: 30px; padding: 0 0px; font-weight:600; line-height: 1.1; margin-bottom:20px; outline: none; color: rgb(55, 53, 47); caret-color: rgb(55, 53, 47); white-space: pre-wrap; word-break: break-word; cursor: text; display: inline-block;
}

.title-editable-block:empty::before {
    content: attr(placeholder);
    display: block;
    -webkit-text-fill-color: rgb(130, 142, 160);
}
.content-editable-block {  line-height: 1.1; outline: none;   cursor: text; min-height: 30px; line-height: 1.5; padding: 3px 0px; outline: none; display: inline-block;
    color: rgb(55, 53, 47); caret-color: rgb(55, 53, 47); white-space: inherit; word-break: break-word;
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
    margin-left:0;
    content: "";
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-size: 1.25rem; margin-right:10px;
    transition: transform .2s ease-in-out; transform: rotate(-90deg);
}
.accordion-button::after {display:none;}
.accordion-button:focus {
    border-color: #fff; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0);
}
.accordion-button:not(.collapsed) {
    color: #333;
    background-color: #fff;
}
.accordion-button:not(.collapsed)::before {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    transform: rotate(0deg);
}

.darg-icon{cursor: -webkit-grab;
    cursor: grab; width: 30px; height: 30px;
    position: relative;
    overflow: hidden;
    outline: none;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center; text-align: center;
    border-radius: 50%; display: inline-flex;
     z-index: 1;}

.darg-icon:hover{
    inset: 0px;
    background: rgb(191, 198, 212);
    opacity: 1;
    border-radius: 100%;
    transition: transform 500ms ease-out 0s;}  

.required-icon{ width: 10px; text-align: center;}

.arrow-icon1{ float: right; cursor: pointer;}

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
.na{
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

.war {
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
    color: rgb(255, 176, 0);
    border: 1px solid transparent;
    background-color: rgba(255, 176, 0, 0.1);
}
.border-l{border-left:#dee2e6 thin solid;}

tbody, td, tfoot, th, thead, tr {
    border-color: rgb(191, 198, 212);
    border-style: solid;
    border-width: thin;
}
.table>:not(:last-child)>:last-child>* {
    border-bottom-color: rgb(191, 198, 212);
}
.fr1::before{-webkit-text-fill-color:#000 !important}
.fr1:focus{border: #0d6efd 2px solid;
    border-radius: 6px;
    padding: 6px;}

.p-icon {
    display: block;
    background: rgb(255, 255, 255);
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    padding: 0.1rem;position: absolute;
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

.pop-arrow{ border: none; background: none;}
.pop-arrow:after{ display: none;;}

input:focus,button:focus{outline: none; box-shadow: none;}

.eUAmnn {
    font-size: 0.875rem;
    font-weight: 400;
    color: rgb(31, 37, 51);
    line-height: 1.25rem;
    cursor: pointer;
    padding: 0.6rem 0.875rem;
    min-height: 2rem;
    white-space: nowrap;
    user-select: none;
    overflow: hidden;
    background-color: rgb(236, 237, 254);
}
.djjqoz {
    margin-right: 0.7rem;
    border-radius: 50%;
    background: rgba(100, 143, 255, 0.1);
    padding: 0.3rem;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
}
.cJpwRx {
    font-size: 0.875rem;
    font-weight: 400;
    color: rgb(31, 37, 51);
    line-height: 1.25rem;
    cursor: pointer;
    padding: 0.6rem 0.875rem;
    min-height: 2rem;
    white-space: nowrap;
    user-select: none;
    overflow: hidden;
    background-color: inherit;
}
.bhYnZk {
    margin-right: 0.7rem;
    border-radius: 50%;
    background: rgba(254, 133, 0, 0.1);
    padding: 0.3rem;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
}
.cJpwRx {
    font-size: 0.875rem;
    font-weight: 400;
    color: rgb(31, 37, 51);
    line-height: 1.25rem;
    cursor: pointer;
    padding: 0.6rem 0.875rem;
    min-height: 2rem;
    white-space: nowrap;
    user-select: none;
    overflow: hidden;
    background-color: inherit;
}
.jpgcYH {
    margin-right: 0.7rem;
    border-radius: 50%;
    background: rgba(94, 156, 255, 0.1);
    padding: 0.3rem;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
}
.iDhWfr {
    -webkit-box-align: center;
    align-items: center;
}
.flVgHp {
    margin-right: 0.7rem;
    border-radius: 50%;
    background: rgba(129, 181, 50, 0.1);
    padding: 0.3rem;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
}
.ipAtGo {
    margin-right: 0.7rem;
    border-radius: 50%;
    background: rgba(0, 182, 203, 0.1);
    padding: 0.3rem;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
}
.imuKGG {
    margin-right: 0.7rem;
    border-radius: 50%;
    background: rgba(30, 207, 147, 0.1);
    padding: 0.3rem;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
}











body{
    background-color: #e9edf6 !important;
}
ul {
  list-style: none;
  padding-left: 0px;
}
ol, ul{
  padding-left: 5px !important;
}
a{
  text-decoration: none !important;
}
section.top-head { padding: 50px 0; }
section.top-head {
    padding: 0px 0;
}

.title-box form {
    display: flex;
    flex-flow: column;
}
.title-box  input {
  background: #e9edf6;
  
}
.title-box textarea {
  background: #e9edf6;
}
.title-box input[type="text"]:focus {
  background-color: #fff;
}
.title-box textarea:focus {
  background-color: #fff;
}

.title-box form input {
    font-size: 40px;
    border: none;
    margin-bottom: 4px;
    padding: 0 10px;
}

.title-box textarea {
    font-size: 22px;
    border: none;
    padding: 10px;
    height: 54px;
}
.uplod-img { height: 120px; width: 120px; border: 1px solid #ccc; border-radius: 10px; margin-right: 16px; overflow: hidden;} 
.img-title-box { display: flex; align-items: center; }

/* upload img */

.file-wrapper { width: 100%; height: 100%; position: relative; }
.file-wrapper:after { content: ''; position: absolute; top: 0; right: 0; margin: auto; display: block; width: 100%; height: 100%; max-height: 100%; font-size: 100%; background-size: cover; background-image: url(https://cdn.vectorstock.com/i/1000x1000/33/23/green-upload-icon-or-logo-vector-42783323.webp); font-weight: bolder; background-position: top; }
  .file-wrapper:before{
    content: '';
    display: block;
    position: absolute;
    left: 0; right: 0;
    margin: auto;
    bottom: 35px;
    width: max-content;
    height: max-content;
    font-size: 0.75em;
    color: gray;
  }
  .file-wrapper:hover:after{font-size: 73px;}
  .file-wrapper .close-btn{display: none;}
  input[type="file"]{
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 99999;
    cursor: pointer;
  }
  .file-set{
    background-size: cover;
    background-repeat: no-repeat;
    color: transparent;
    padding: 10px;
    border-width: 0px;
  }
  .file-set:hover{
    transition: all 0.5s ease-out;
    filter:brightness(110%);
  }
  .file-set:before{color: transparent;}
  .file-set:after{color: transparent;}
  .file-set .close-btn{
    position: absolute;
    width: 35px;
    height: 35px;
    display: block;
    background: #000;
    color: #fff;
    top: 0; right: 0;
    font-size: 25px;
    text-align: center;
    line-height: 1.5;
    cursor: pointer;
    opacity: 0.8;
  }
  .file-set > input{pointer-events: none;}
  .title-sec button { border: none; font-size: 1.5rem; margin-top: 20px; width: 100%; text-align: left; background: none; padding-bottom: 10px; }
  .title-full-contant h4 {
    font-size: 16px;
    padding-left: 34px;
}
.input-sec{
  display: flex;
  width: 100%;
}
.question-type button.accordion-button {
  margin-top: 0px;
  position: relative;
}
.question-type{
  margin-top: 30px;
}
.input-sec .q-left {
  width: 70%;
}

.input-sec .section-right {
  width: 30%;
  border-left: 1px solid #ccc;
  padding: 8px 8px 8px 8px;
  font-size: 18px;
}
.question-type button {
  padding: 0px;
}
.input-sec .q-left {
  width: 70%;
  padding: 10px 8px 8px 8px;
  font-size: 18px;
}

.input-sec .star{
  padding-right: 8px;
}
button.accordion-button.collapsed {
  padding-right: 10px;
}
.accordion-button:not(.collapsed) {
  color: #000000;
  background-color: #dbdfe5;
  box-shadow: none;
}
.accordion-button:focus {
  z-index: 3;
  border-color: #000000 !important;
  outline: 0;
  box-shadow: none !important;
  padding-right: 10px;
  color: #000 !important;
  background-color: #e9edf6;
}
.q-left svg {filter: grayscale(1);height: 32px;width: 32px;padding: 5px;}
.section-right svg {height: 36px;width: 36px;padding: 10px;}
.q-left svg:hover,.section-right svg:hover {
    background: #f3f3f3;
    filter: none;
    border-radius: 50px;
}
.top-q-res {
  display: flex;
  width: 100%;
}

.top-q-res .q-headings {
  width: 70%;
}

.top-q-res .res-headings {
  width: 30%;
}
.question-type {
  border: 1px solid #dddada;
  background: #f8f9fc;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.top-q-res .q-headings p {
  font-size: 16px;
  padding: 8px 11px 8px 12px;
  margin-bottom: 0px;
}

.top-q-res .res-headings p{
  font-size: 16px;
  padding: 8px 11px 8px 12px;
  margin-bottom: 0px;

}
.acord-btm {
  display: flex;
}
.acord-btm .fast-btm {
  padding: 0px 20px 0px 15px;
  border-right: 1px solid #c7c7c7;
}

.acord-btm .second-btm {
  padding: 0px 20px 0px 20px;
  border-right: 1px solid #c7c7c7;
}

.acord-btm .thrd-btm {
  padding: 0px 10px 0px 20px;
}
button.accordion-button:focus {
  background: #f7f7ff !important;
}
button.title-btn svg {
  transform: rotate(90deg);
}
button.title-btn:focus svg {
  transform: rotate(0deg);
}
.drop-contant {
  
  right: 20px;
  top: 20px;
  background: rgb(248, 242, 242);

  width: 300px;
}
.drop-contant p {
  font-size: 16px;
  padding-top: 20px;
}

.drop-contant {
 
  color: #000;
}

.drop-contant ul li {
  font-size: 16px;
  font-weight: 600;
 
}
.drop-contant ul li a {
  color: #141414;
}


.title-page-box p {
  padding: 10px 0px 10px 10px;
  margin: 0;
  font-size: 13px;
  
}

.title-page-box li {
  padding: 15px;
}

.title-page-box li:hover, .title-page-box li.active {
  background: #e9edf6;
}

.title-page-box ul {
  padding-left: 0 !IMPORTANT;
  margin-bottom: 0;
}

.title-page-box {
  border-bottom: 1px solid #ccc;
}
.drop-contant {

  overflow-y: auto;
  max-height: 400px;
  background-color: #fff;
}
.show-hide-box{
  display: none;
}
.two-drop {
  display: flex;
  position: absolute;
  right: 27%;
  box-shadow: 0 0 12px -6px #000;
  background: #fff !important;
  overflow: hidden;
  border-radius: 8px;
  z-index: 99;
}
.left-form-top {position: relative;}

.left-form-top input.form-control {
    padding: 10px 10px 10px 50px;
}

.left-form-top .search-btn {
    position: absolute;
    top: 0;
    left: 0;
    padding: 10px;
}
.drop-contant.second-opn {
  border-right: 1px solid #d5d3d3;
  padding: 15px;
  
}
a.btn.btn-outline-success.search-btn {
  border: none;
}
.btn-outline-success:hover {
  color: #fff;
  background-color: #ffffff !important;
  border-color: none;
  margin: 1px;
}

.form-control:focus {
  border-color: #afafaf !important;
  box-shadow: none !important;
}
.second-opn .title-page-box li {
  display: flex;
  justify-content: space-between;
}
span.good1 {
  color: #13855f;
  background: #157a1538;
  padding: 2px 7px 2px 7px;
  border-radius: 15px;
  font-weight: 400;
  font-size: 15px;
  margin: 5px;
}
span.fair1 {
  color: #ffb000;
  background: #ffae0046;
  padding: 2px 7px 2px 7px;
  border-radius: 15px;
  font-weight: 400;
  font-size: 15px;
  margin: 5px;
}

span.poor1 {
  color: #c60022;
  background: #c600213b;
  padding: 2px 7px 2px 7px;
  border-radius: 15px;
  font-weight: 400;
  font-size: 15px;
  margin: 5px;
}

span.na-1 {
  color: #707070;
  background: #70707041;
  padding: 2px 7px 2px 7px;
  border-radius: 15px;
  font-weight: 400;
  font-size: 15px;
  margin: 5px;
}
.search-box-ftr p.text-center {
  padding-top: 0px;
}
.search-box-ftr a{
  display: block;
  padding: 10px 20px;
  border: 1px solid rgb(208, 209, 209);
  font-size: 16px;
  border-radius: 5px;
  color: #3f3e3e !important;
}
.search-box-ftr a:hover{
  background-color: #eaeaeb;
}
.title-page-btns {
  display: flex;
  width: 30%;
}

.title-page-btns button.title-btn1 {
  font-size: 17px;
  color: #0a0ab3;
  padding: 5px 7px;
  border: 1px solid #c3c0ce;
  text-align: center;
  background-color: #fff;
  border-radius: 10px;
}
.title-page-btns button.title-btn1:hover {
  background-color: #e9edf6e8;
}
.title-page-btns button.title-btn2 {
  font-size: 17px;
  color: #0a0ab3;
  padding: 5px 7px;
  border: 1px solid #c3c0ce;
  text-align: center;
  margin-left: 20px;
  background-color: #fff;
  border-radius: 10px;
}
.title-page-btns button.title-btn2:hover {
  background-color: #e9edf6e8;
}
.title-page-box-sidebar {
  display: flex;
}

.title-page-box-sidebar a {
  font-size: 13px;
  padding: 10px 0px 0px 20px;
}

input.adpage-inpt {
  width: 100%;
  border: none;
  padding: 9px 20px;
  background-color: #e9edf6;

}

input.adpage-inpt:focus {
  background-color: #e9edf6;
  border-color: blue;
}

.q-left {
  display: flex;
}
.thrd-btm .flagged-txtno {
  color: #fc4b00;
  background-color: #fc4b0033;
  padding: 5px;
  border-radius: 8px;
}
.thrd-btm  .form-check-label {
  color: #000;
}

/* rightside bar code start */
div#offcanvasRight {
  width: 511px;
  background-color: #f8f9fc;
}
.sidebar-top-sec {
  display: flex;
  justify-content: space-between;
}
.form-check-input:checked {
  background-color: #4740d4 !important;
  border-color: #4740d4 !important;
}
.form-check-input:focus {
  border-color: #4740d44f;
  outline: 0;
  box-shadow: none !important;
}
.sidebar-top-sec {
  color: #827f7f;
}
.responce-input {
  display: flex;
  align-items: center;
}
.responce-input input[type="text"] {
  width: 95%;
  margin-left: 7px;
  padding: 2px;
}
.responce-input {
    position: relative;
}
.sidebar-form-first {
 margin-top: 50px;
}
.side-bar-btm {
  display: flex;
  justify-content: end;
  padding-top: 10px;
}
.side-bar-btm .side-br-btm1 {
  padding-right: 8px;
  border-right: 1px solid #9da0a8;
  color: #616369;
}
.side-bar-btm .side-br-btm2{
  padding-right: 8px;
  border-right: 1px solid #9da0a8;
  color: #616369;
  padding-left: 8px;
}
.side-bar-btm .side-br-btm3 {
  padding-left: 8px;
  color: #616369;
}
.color-picker input[type="color"] {
  border: none;
  width: 20px;
  height: 20px;
  cursor: pointer;
  border-radius: 30px;
 }

.color-picker code {
 font-size: 0rem;
 color: #000;
 border-radius: 3px;
 padding: 5px;
}
.color-picker {
  position: absolute;
  right: -8px;
  top: 5px;
}
.side-br-btm2 input[type="number"] {
  width: 70px;
  padding-left: 7px;
  margin-left: 3px;
}
.side-br-btm3 svg {
  color: #6559ff;
}
.form-check label.form-check-label {
  cursor: pointer;
}
.form-check input#flexCheckDefault {
  cursor: pointer;
}
.sidebar-box-input {
  background-color: #fff;
  padding: 15px 10px 20px 10px;
  border-bottom: 1px solid #6f636359;
  border-top: 1px solid #6f636359;
}
.popup-rsp-btn {
  border: none;
  background: transparent;
  margin-top: 15px;
}
.close-btn-popup {
  margin-top: 40px;
}

.close-btn-popup button.text-reset {
  border: 1px solid #acacb3;
  border-radius: 7px;
  padding: 5px 15px;
  background-color: #fff;
  color: #1717a6 !important;
  margin-left: 29px;
}
.close-btn-popup a {
  color: #67696e;
  cursor: no-drop;
}
.close-btn-popup a:hover {
  color: #67696e;
  
}
.question-type {
  position: relative;
}

.pls-btm-form {
  position: absolute;
  right: -12px;
  top: 10px;
  background-color: #fff;
  border-radius: 40px;
  width: 30px;
  height: 30px;
  text-align: center;
  box-shadow: 0px 0px 3px gray;
  line-height: 26px;
}
.pls-btm-form:hover {
   box-shadow: 2px 2px 10px gray;
 
}
.delt-btm-form {
  position: absolute;
  top: 60px;
  right: -56px;
  background-color: #fff;
  border: 1px solid #b1b1dd;
  width: 38px;
  height: 40px;
  text-align: center;
  line-height: 30px;
  border-radius: 8px;
}
.delt-btm-form svg{
  color: #6559ff;
}
.delt-btm-form:hover{
  background-color: #e9edf6b0;
}
button.title-btn svg {
  transform: rotate(0deg);
}
.img-title-box {
  padding-top: 60px;
}


/* rightside bar code end */

/* top-prewive page css start */
.prewive-top-sec {
  display: flex;
  justify-content: space-between;
  padding: 0px 28px;
}
.prewive-right {
  display: flex;
}
.prewive-right a.publish-btn {
  
  display: block;
  width: 75px;
  height: 35px;
  background: #0060d0;
  border-radius: 5px;
  padding: 5px 10px;
  color: #fff;
  margin: -5px 10px;
  text-align: center;
}

.prewive-top-sec {
  background-color: #fff;
  padding-top: 20px;
  border-top: 1px solid #b7a9a9;
}
.prewive-left a.seen-prewive1 {
  border: 1px solid #0060c5;
  padding: 8px 14px;
  color: #0060c5;
  border-radius: 5px;
}
.prewive-left a.seen-prewive2 {
  border: 1px solid #0060c5;
  padding: 8px 14px;
  color: #0060c5;
  border-radius: 5px;
  margin-left: 10px;
}
.prewive-left a.seen-prewive3 {
  padding-left: 15px;
}
.prewive-left a.seen-prewive4 {
  padding-left: 15px;
}




body.bulk-show .bulk-right-pop{
  position: fixed;
  top: 0;
  right: 0;
  height: 100vh;
  width: 400px;
  background: #e9edf6;
  z-index: 101;
  transition: 0.3s;
  display: block;
}

body.bulk-show:before {
  position: fixed;
  width: 100%;
  height: 100%;
  background: #00000040;
  z-index: 100;
  top: 0;
  left: 0;
  content: "";
}

.bulk-right-pop {
  right: -400px;
  transition: 0.3s;
}
body.bulk-show { overflow: hidden; }
.prewive-left .seen-prewive2 {
  border: 1px solid #0060d0;
  padding: 6px;
  background: #fff;
  border-radius: 5px;
  color: #0060d0;
  margin-left: 10px;
}
.prewive-top-sec {
  background-color: #fff;
  padding-top: 20px;
  padding-bottom: 15px;
  border-top: 1px solid #b7a9a9;
}

.bulk-right-pop {
  padding: 30px 20px;
  display: none;
}
.edit-more-box h3 {
  color: #000;
  font-size: 23px;
}
.edit-more-box p {
  font-size: 15px;
}
.req-action {
  padding-left: 28px;
  padding-top: 8px;
}
button.btn.btn-primary.bulk-page-btna {
  background: #6559ff;
  border: none;
  border-radius: 14px;
  padding: 8px 15px;
}
button.btn.btn-primary.bulk-page-btna:focus {
  box-shadow: none;
}
.btn-close-bulk {
  background: #fff;
  border: 1px solod #000;
  border: 1px solid #6559ff;
  padding: 8px 15px;
  border-radius: 14px;
  margin-left: 12px;
  margin-top: 29px;
}

.btn-close-bulk:hover {
  background: #e9edf6;
  
}
.modal-prewive .modal-dialog.popup-show-height { width: 100% !important; max-width: 100%; border-radius: 0px !important; border: none; margin: 0; }

.prewive-clik-bdy { width: 768px; margin: 0px auto; }
.btn-add-1-2 { padding: 16px; border: 1px solid #ccc; border-top: none; position: sticky; z-index: 99;
  top: 63px;
  background: #f8f9fc;}
.btn-drop-pre1 a#dropdownMenuLink { background: transparent; border: none; font-family: "Noto Sans", sans-serif; font-size: 0.8rem; font-weight: 400; color: rgb(84, 95, 112); line-height: 1rem; }
.btn-drop-pre1 a#dropdownMenuLink:focus {
  box-shadow: none;
}
.btn-drop-pre2 a#dropdownMenuLink {
  background: transparent;
  border: none;
}
.popup-show-height .modal-body { padding: 0; }
.btn-drop-pre2 a#dropdownMenuLink:focus {
  box-shadow: none;
}

.modal-prewive .modal-dialog.popup-show-height .modal-content { border-radius: 0; border: none; min-height: 100vh; background: rgb(248, 249, 252); }
.btn-add-1-2 a { color: rgb(84, 95, 112); } 
.btn-add-1-2 #dropdownMenuLink { padding: 0; margin: 0; } 
.btn-drop-pre1 { margin-bottom: 10px; }
.popup-show-height .modal-header { background: #fff; position: sticky; top: 0; z-index: 999;  }
.popup-show-height .modal-header button { background: none; border: none; font-family: "Noto Sans", sans-serif; font-size: 1.3rem; font-weight: 500; color: rgb(31, 37, 51); line-height: 1.75rem; display: flex; align-items: center; } .popup-show-height .modal-header button svg { margin-right: 10px; }
.btn-drop-pre2 h4 { font-family: "Noto Sans", sans-serif; font-size: 1rem; font-weight: 400; color: rgb(31, 37, 51); line-height: 1.5rem; margin-right: 1rem; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; overflow: hidden; margin: 0; }
.list-conducted { background: #fff; border: 1px solid #ccc; border-radius: 10px; padding: 16px; margin: 10px 0; } 
.list-conducted h3 { font-family: "Noto Sans", sans-serif; font-size: 1rem; line-height: 1.5rem; font-weight: 400; letter-spacing: 0.025rem; color: rgb(63, 73, 90); -webkit-font-smoothing: antialiased; margin: 0; padding-bottom: 16px; }
.list-conducted input[type="datetime"] { width: 50%; border: 1px solid #ccc; padding: 8px; border-radius: 6px; }
.list-conducted ul { display: flex; justify-content: end; margin: 0; } 
.list-conducted ul a,.list-conducted ul input { margin: 0px; border: 1px solid transparent; display: inline-flex; -webkit-box-pack: center; justify-content: center; -webkit-box-align: center; align-items: center; font-size: 0.875rem; line-height: 22px; transition: background-color 200ms; user-select: none; border-radius: 0.5rem; padding: 0.25rem 0.75rem; gap: 0.25rem; min-height: 2rem; min-width: 2rem; color: rgb(71, 64, 212); background: transparent; } 
.list-conducted ul input { width: 100px; }
.list-conducted ul li.attach-media { position: relative; width: 120px; } 
.list-conducted ul li.attach-media span { position: absolute; top: 0; left: 0; margin: 0px; border: 1px solid transparent; display: inline-flex; -webkit-box-pack: center; justify-content: center; -webkit-box-align: center; align-items: center; font-size: 0.875rem; line-height: 22px; transition: background-color 200ms; user-select: none; border-radius: 0.5rem; padding: 0.25rem 0.75rem; gap: 0.25rem; min-height: 2rem; min-width: 2rem; color: rgb(71, 64, 212); background: transparent; }.prewive-left .prewiv-popup-new {
  border: 1px solid #0060d0;
  padding: 6px;
  background: #fff;
  border-radius: 5px;
  color: #0060d0;
  margin-left: 10px;
}
.int-click-btn input[type="datetime"] {
  width: 100%;
  margin-top: 15px;
}
.int-btn-pre-page .butn-pre-1 {
  border: 1px solid #4740d4;
  background-color: #4740d4;
  color: #fff;
  padding: 8px 20px;
  font-size: 18px;
  border-radius: 8px;
}
.int-btn-pre-page .butn-pre-2 {
  border: 1px solid #4740d4;
  background-color: #ffffff;
  color: #4740d4;
  padding: 8px 20px;
  font-size: 18px;
  border-radius: 8px;
  margin-left: 10px;
}
.int-btn-pre-page {
  margin-top: 15px;
}
.pre-next-btn {
  display: flex;
  justify-content: end;
  margin-top: 40px;
  margin-bottom: 60px;
}
.pre-next-btn .pre-page-next {
  border: 1px solid #4740d4;
  background-color: #4740d4;
  padding: 8px 15px;
  color: #fff;
  border-radius: 8px;
}
.full-width-inbtn button {
  border: 1px solid #4740d4;
  background-color: #4740d4;
  padding: 8px 10px;
  border-radius: 8px;
  color: #fff;
}
.full-width-inbtn input.full-wd-form {
  width: 87%;
}
.add-show-hide-box{
  display: block;
}
.add-section-acord input[type="text"] {
  width: 65%;
  border: none;
}
.accordion-button:not(.collapsed) {
   background-color: #e9edf6 !important;
  
}
.section-right.first-row.scnd-rdo-btn {
  padding-top: 15px;
  padding-left: 20px;
  display: none;
}
.input-sec:hover .scnd-rdo-btn{
  display: block;
}
.q-left svg.defrent-clr {
  border-radius: 50px;
  background: #6559ff;
  filter: none;
}

.add-section-acord input[type="text"] {
  font-size: 18px;
  padding: 5px 10px;
}
.accordion-body.btm-clr-input {
  background-color: #e9edf6;
}
.accordion-body.btm-clr-input {
  background-color: #e9edf6;
  padding: 9px 10px;
}
.add-section-acord input[type="text"] {
  font-size: 18px;
  padding: 5px 10px;
  margin-left: 14px;
  background-color: #e9edf6;
}
button.accordion-button.man-type-qsn.collapsed {
  background: #e9edf6;
}
.add-section-acord svg {
 filter: brightness(0.5);
}
.btn-with-preview-page-in .batn-full-size {
  width: 100%;
  display: flex;
  justify-content: space-between;
  border: none;
  background-color: #4740d4;
  color: #fff;
  padding: 20px 20px;
  border-radius: 10px;
}
.inputbtn-btm-btn {
  display: flex;
  justify-content: space-between;
  margin-top: 50px;
  margin-bottom: 20px;
}
.inputbtn-btm-btn .btn-yes-point-1 {
  width: 33.3333%;
  border: 1px solid #4740d4;
  color: #4740d4;
  height: 42px;
  border-radius: 10px;
  background-color: #fff;
  margin: 10px;
}
.inputbtn-btm-btn .btn-yes-point-1:focus {
  border: 1px solid #13855f;
  background-color: #13855f;
  color: #fff;
  
}
.inputbtn-btm-btn .btn-yes-point-2 {
  width: 33.3333%;
  border: 1px solid #4740d4;
  color: #4740d4;
  height: 42px;
  border-radius: 10px;
  background-color: #fff;
  margin: 10px;
}
.inputbtn-btm-btn .btn-yes-point-2:focus {
  border: 1px solid #c60022;
  background-color: #c60022;
  color: #fff;
  
}
.inputbtn-btm-btn .btn-yes-point-3 {
  width: 33.3333%;
  border: 1px solid #4740d4;
  color: #4740d4;
  height: 42px;
  border-radius: 10px;
  background-color: #fff;
  margin: 10px;
}
.inputbtn-btm-btn .btn-yes-point-3:focus {
  border: 1px solid #707070;
  background-color: #707070;
  color: #fff;
}
.pre-next-btn.pre-btn-maneges {
  justify-content: left;
}
.prewive-clik-bdy.page-untitle-hidn {
  display: none;
}
.popup-show-height.show-next .page-untitle-hidn{display: block;}
.popup-show-height.show-next .fst-pre-click {display: none;}
/* top-prewive page css end */

/* responsive media code start */


@media (max-width: 767px) {
  .img-title-box {
    display: block;
}
.title-page-btns {
  display: flex;
  width: 100%;
}
.delt-btm-form {
  top: 38px;
  right: 5px;
  width: 25px;
  height: 25px;
  line-height: 16px;
  
}

.two-drop {
  display: block;
  
}
.title-box form input {
  font-size: 30px;
  }
.title-full-contant h4 {
    font-weight: 400;
}
div#offcanvasRight {
  width: 90%;
  background-color: #f8f9fc;
}
.acord-btm .thrd-btm {
  padding: 0px 10px 0px 10px;
}
.acord-btm .second-btm {
  padding: 0px 10px 0px 10px;
}
.fast-btm .form-check {
  padding-left: 0em;
}
.side-bar-btm a {
  display: flex;
}
.int-click-btn input[type="datetime"] {
  width: 43%;
  
}
.list-conducted input[type="datetime"] {
  width: 43%;
  
}
.full-width-inbtn input.full-wd-form {
  width: 32%;
}
.pre-next-btn {
  display: flex;
  justify-content: flex-start;
 }
 .prewive-top-sec {
  padding: 20px 2px;
}
.prewive-right p {
  display: none;
}
.prewive-left {
  display: flex;
}
.prewive-right a.publish-btn {
 margin: 0px 10px;
}
.btn-with-preview-page-in .batn-full-size {
  width: 43%;
  
}
.inputbtn-btm-btn {
  flex-direction: column;
}
.list-conducted ul {
 justify-content: flex-start;
  
}


}

tbody, td, tfoot, th, thead, tr {
    border-color: inherit;
    border-style: solid;
    border-width: 1px !important;
}

table {
  border-collapse: separate;
  border-spacing: 0; /* To avoid gaps between table cells */
  border-radius: 10px; /* Adjust as needed */
  overflow: hidden; /* Ensures the corners are clipped */
}

.two-drop {
    display: none;
}

li.selected {
    border: 2px solid #648fff; /* Example styling for selection */
    background-color: #f0f8ff;
}

input[type="radio"] {
        /* Hides the radio button but keeps it functional */
        opacity: 1;
    }
    
    li.active {
    background-color: #f0f0f0; /* Highlight the background */
}

button.delete-question {
    border: 1px solid rgb(191, 198, 212);
    display: inline-flex;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    font-size: 0.875rem;
    line-height: 22px;
    transition: background-color 200ms;
    user-select: none;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    gap: 0.25rem;
    min-height: 2.5rem;
    min-width: 2.5rem;
    color: rgb(71, 64, 212);
    background: rgb(255, 255, 255);
}

button.delete-section {
    border: 1px solid rgb(191, 198, 212);
    display: inline-flex;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    font-size: 0.875rem;
    line-height: 22px;
    transition: background-color 200ms;
    user-select: none;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    gap: 0.25rem;
    min-height: 2.5rem;
    min-width: 2.5rem;
    color: rgb(71, 64, 212);
    background: rgb(255, 255, 255);
}
button.title-btn3.delete-page {
    border: 1px solid rgb(191, 198, 212);
    display: inline-flex;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    font-size: 0.875rem;
    line-height: 22px;
    transition: background-color 200ms;
    user-select: none;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    gap: 0.25rem;
    min-height: 2.5rem;
    min-width: 2.5rem;
    color: rgb(71, 64, 212);
    background: rgb(255, 255, 255);
}

.pagetemplate {
border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px;
}

.fRTxQu {
    border: 1px solid rgb(191, 198, 212);
    border-radius: 0.35rem;
    box-shadow: rgb(191, 198, 212) 0px 0px 1rem 0px;
    background-color: rgb(255, 255, 255);
    user-select: none;
    word-break: normal;
    position: absolute;
    left: 24px;
    padding: 10px;
    font-size: 10px;
        display: none !important;
}

.fRTxQu::before {
    content: "";
    position: absolute;
    top: 50%;
    margin-top: -0.5rem;
    border-width: 0.5rem;
    border-style: solid;
    border-color: transparent transparent transparent rgb(255, 255, 255);
    border-image: initial;
    right: -1rem;
    margin-right: 0.1rem;
    display: none;
}

.modal.left .modal-dialog {
        position: fixed;
        margin: auto;
        width: 320px;
        height: 100%;
        left: 0;
        transform: translateX(-100%);
        transition: transform 0.3s ease-out;
    }

    .modal.left.show .modal-dialog {
        transform: translateX(0);
    }

    /* Modal slide-in from the right */
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 320px;
        height: 100%;
        right: 0;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
    }

    .modal.right.show .modal-dialog {
        transform: translateX(0);
    }

    /* Full height modal content */
    .modal-content {
        height: 100%;
        overflow-y: auto;
    }
    
    .color-picker-styled__Container {
  position: relative;
  display: inline-block;
}

.color-picker-styled__InputContainer {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.color-picker-styled__SelectedColorBox {
  width: 24px;
  height: 24px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-right: 10px;
}

.color-picker-styled__ColorBoxesContainer {
  position: absolute;
  top: 40px;
  left: 0;
  background: white;
  padding: 10px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #ddd;
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  z-index: 1000;
}

.color-picker-styled__ColorBox {
  width: 30px;
  height: 30px;
  cursor: pointer;
  border: 1px solid transparent;
  border-radius: 4px;
  transition: border 0.2s ease;
}

.color-picker-styled__ColorBox:hover {
  border: 1px solid #000;
}

.title-page-box span {
    padding: 2px 7px 2px 7px;
    border-radius: 15px;
    font-weight: 400;
    font-size: 15px;
}

.page .plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0.fRTxQu {
    position: absolute;
    left: -72px;
}

.sidebar-box-input.response-item input.form-control {
    width: 514px;
    display: table-caption;
}

 .butn-pre-1 {
    border: 1px solid #4740d4;
    background-color: #4740d4;
    color: #fff;
    padding: 8px 20px;
    font-size: 18px;
    border-radius: 8px;
    margin: 20px 0;
}
    </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
 @include('admin.popups.templates.addtemplate')
 
     <!-- right sidebar section with click code start -->


   
<div class="row">
                    <div class="col">
                      <div class="card">
                                <div class="card-body">
                                    <div>
                                        <h5 class="mb-3">Template List</h5>
                                        <hr>
                                    </div>
                                    <div class="row row-cols-auto g-3 mb-0 p-3">
                                        <div class="col-2">
                                           <div class="uplod-img">
                                           <div class="file-wrapper">
                                               
                                               @if($template_details->image)
                                               <img src="https://efsm.safefoodmitra.com/admin/public/template/{{$template_details->image}}" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
                                               @else
                                               <img src="https://cdn.vectorstock.com/i/1000x1000/33/23/green-upload-icon-or-logo-vector-42783323.webp" alt="Image Preview" style="max-width: 200px; max-height: 200px;">
                                               @endif

                                            <div class="template-logo-hover">
                                                
                                                
                                                
                                                <form id="imageUploadForm" enctype="multipart/form-data">
                                                    
                                                    
                                                    
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image">
        <div id="imagePreview"></div>
    </form>
    
    


                                           </div>
                                           </div>

                                           </div>  
                                        </div>
                                        <div class="col-8 align-self-center title-box">
                                           

                                            <div data-bs-toggle="tooltip" data-bs-placement="top" title="" class="title-editable-block"  contenteditable="true" placeholder="Enter template title" tabindex="0" data-bs-original-title="Edit the title of your template" aria-label="Edit the title of your template" id="templatename">{{$template_details->template_name ?? ''}}</div> 
                                            <div class="clearfix"></div>
                                        </div>
                                       
                                    </div> 
                                    
            
                                    <div class="row row-cols-auto g-3 mb-3 p-3">
                                        
                              
                                                
                                        <div class="col-12 p-3 m-5">

                                                
                                                

                                                
                                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                           <div class="row" style="background: #e9edf6;padding: 10px;">
                                                                 <div class="col-2">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-controls="flush-collapseOne">
                                                           <b>Cleaning  Checklist <label class="radio-inline">
            <input type="radio" name="cleaningchecklist" value="yes" checked>Yes
            </label>
            <label class="radio-inline">
            <input type="radio" name="cleaningchecklist" value="no">No
            </label></b> 
                                                        </button>
                                                        </div>
                                                        
                                                         @php 
                                                         $result = DB::table('template_question')->where('template_id', $template_details->id)->where('type', 1)->first();
                                                         $equpiments1 = $result->responsibilitys;
                                                         @endphp
                      
                                                                   <div class="col-2">
                                                    <select class="form-select" aria-label="Default select example" name="responsibilitys" onchange="updatetemplate('{{$template_details->id ?? ''}}','1')">
                                                        <option value="">Responsibility</option>
                                                             @foreach($authority as $responsibilitys)
                                    <option value="{{$responsibilitys->id ?? ''}}" @if($equpiments1==$responsibilitys->id) selected @endif>{{$responsibilitys->name ?? ''}}({{Helper::userInfoShortName($responsibilitys->unit_id ?? '')}})</option>
                                    @endforeach
                                                    </select>
                                                </div>
                                                
                                                                                                           <div class="col-2">
            <input type="text" name="cleaning_frequency" class="form-control"  placeholder="Cleaning Frequency(In Days)" onkeyup="updatetemplate('{{$template_details->id ?? ''}}','1')" value="{{$result->cleaning_frequency ?? ''}}">

</div>
</div>
                                                    </h2>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse show cleaningchecklist" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                          <div class="col-md-9">
                                                              
        

<!-- Text input-->
<div  class="form-group">
 <table class="table mb-0" border="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" style="border-bottom: 1px solid #ddd;padding: 15px 11px 8px 12px;">Questions</th>
                                                                            <th scope="col" style="border-bottom: 1px solid #ddd;padding: 15px 11px 8px 12px;" width="300">Type of responce</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="items">
                                                                        
                                                                        @foreach($questionlist as $questionlists)
                                                                        <tr id="squestion_{{$questionlists->id ?? ''}}">
                                                                            <td class="d-flex align-items-center" style="border:none;">
                                                                             <div class="darg-icon"><svg viewBox="0 0 24 24" width="24" height="24" focusable="false"><path fill="none" d="M0 0h24v24H0V0z"></path><path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg></div>    
                                                                             
                                                                             <div class="content-editable-block w-100 fr1" id="updatequestion_{{$questionlists->id ?? ''}}" onkeyup="updateQuestion('{{$questionlists->id ?? ''}}','1')" contenteditable="true" value="{{$questionlists->question ?? ''}}" placeholder="{{$questionlists->question ?? ''}}" tabindex="0">{{$questionlists->question ?? ''}}</div>
                                                                            </td>
                                                                         <td>
                                                                 
                                                                             @php 
                                                                             $questionoption = DB::table('template_question')->where('id',$questionlists->id)->first();
                                                                     
                                                                             
                                                                             @endphp
                                                    
                                                    
                                                    @if(!empty($questionoption->option_id))  
                                                    
                                                    
                                                    @php
                                                    
                                                    $multipleoptionList1 = DB::table('multiple_choice_response')
                        ->where('unique_id',$questionoption->option_id)
                        ->get();
                        
                        @endphp
                                                                <!-- Default options initially displayed -->
    <div class="defaultbox" style="float: left;">
        
        @foreach($multipleoptionList1 as $multipleoptionList1s)
         <span class="option-span"
                              style="color: {{ $multipleoptionList1s->color ?? '' }}; background: {{ $multipleoptionList1s->bg_color ?? '' }}; padding: 2px 7px; border-radius: 15px; font-weight: 400; font-size: 15px;">
                            {{ $multipleoptionList1s->name ?? '' }}
                        </span>
                        
                        @endforeach

    </div>
                                                    @else
                                                            <!-- Default options initially displayed -->
    <div class="defaultbox" style="float: left;">
        <span class="info">Safe</span>
        <span class="risk">At Risk</span>
        <span class="na">N/A</span>
    </div>
                                                    @endif


    <!-- Button to open dropdown -->
    <button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">
        <span class="arrow-icon1">
            <svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">
                <path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>
            </svg>
        </span>
    </button>

    <!-- Dropdown list -->
    <div class="two-drop" style="display:none;">
        <div class="drop-contant second-opn">
                     <div class="left-form-top">
                                                                    <input class="form-control me-2" type="search"
                                                                        placeholder="Search" aria-label="Search">
                                                                    <a class="btn btn-outline-success search-btn"
                                                                        type="submit"><svg viewBox="0 0 267 267"
                                                                            width="20" height="20" focusable="false">
                                                                            <defs>
                                                                                <clipPath id="a">
                                                                                    <path d="M0 0h267v267H0z"></path>
                                                                                </clipPath>
                                                                            </defs>
                                                                            <g clip-path="url(#a)">
                                                                                <path fill="#1f2533"
                                                                                    d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z">
                                                                                </path>
                                                                                <path d="M0 0h267v267H0V0z" fill="none">
                                                                                </path>
                                                                            </g>
                                                                        </svg></a>
                                                                </div>
            <div class="title-page-box">
                <div class="title-page-box-sidebar">
                    <p>Multiple choice responses</p>
                    
                    
                    <a href="" data-bs-toggle="offcanvas" data-bs-target="#rightSlide">+Responses</a>
                </div>
<ul id="optionsList">
    @foreach($multipleoptionList as $multipleoptionLists)
        @php $list = Helper::multipleOptions($multipleoptionLists->unique_id); @endphp

        <li onclick="selectResponse(this, '{{ $multipleoptionLists->id }}','{{ $multipleoptionLists->unique_id }}','{{$questionlists->id ?? ''}}')"
            data-response-class="{{ $multipleoptionLists->id }}">

            <label>
                <input type="radio" name="response" value="{{ $multipleoptionLists->id }}">
                <div class="fair-sec">
                    @foreach($list as $lists)
                        <span class="option-span"
                              style="color: {{ $lists->color ?? '' }}; background: {{ $lists->bg_color ?? '' }}; padding: 2px 7px; border-radius: 15px; font-weight: 400; font-size: 15px;">
                            {{ $lists->name }}
                        </span>
                        
                        
                    @endforeach
                </div>
            </label>
        </li>
        
        <div class="pena-sec"><a href="" data-bs-toggle="offcanvas" data-bs-target="#rightSlide{{$multipleoptionLists->unique_id}}"><i class="bx bx-edit me-0"></i></a></div>
        
        
   <!-- Right Sidebar Blind Slide -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="rightSlide{{$multipleoptionLists->unique_id}}" aria-labelledby="rightSlideLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="rightSlideLabel">Multiple choice responses</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <form id="multipleChoiceForm{{$multipleoptionLists->unique_id}}">
        @csrf
        <div class="offcanvas-body">
            <div class="sidebar-top-sec">
                <div>e.g. Yes, No, N/A</div>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckScoring" name="scoring">
                        <label class="form-check-label" for="flexCheckScoring">Scoring</label>
                    </div>
                </div>
            </div>
            <div class="sidebar-form-first">
                <div id="responseContainer">
                    <!-- Dynamic response inputs will be appended here -->
                    <div class="sidebar-box-input response-item">
@foreach($list as $index => $lists)
    <div class="responce-input d-flex align-items-center">
        <input type="text" name="responses1[{{ $index }}][text]" class="form-control" placeholder="Response 1" value="{{ $lists->name }}">
        <input type="hidden" name="responses1[{{ $index }}][id]" class="form-control" value="{{ $lists->id }}">
        <input type="hidden" name="responses1[{{ $index }}][unique_id]" class="form-control" value="{{ $multipleoptionLists->unique_id }}">

        <div class="color-picker-styled__Container ms-2" style="display: flex; width: 300px; padding: 8px;">
            <div class="color-picker-styled__InputContainer">
                <div
                    class="color-picker-styled__SelectedColorBox"
                    style="background-color: {{ $lists->bg_color ?? '#648fff' }};"
                    onclick="toggleColorPicker(this)"
                ></div>
                <input
                    type="hidden"
                    name="responses1[{{ $index }}][color]"
                    value="{{ $lists->bg_color ?? '#648fff' }}"
                />
            </div>

            <div class="color-picker-styled__ColorBoxesContainer" style="display: none;">
                @php
                    $colors = ['#c60022', '#9c6d1e', '#fe8500', '#ffb000', '#81b532', '#13855f', '#00b6cb', '#648fff', '#0044a3', '#c22dd5', '#dc267f', '#707070'];
                @endphp
                @foreach ($colors as $color)
                    <div 
                        class="color-picker-styled__ColorBox {{ $lists->bg_color == $color ? 'selected' : '' }}" 
                        style="background-color: {{ $color }};" 
                        data-color="{{ $color }}"
                    ></div>
                @endforeach 
            </div>
        </div>
        <input type="number" name="responses1[{{ $index }}][score]" class="form-control" placeholder="Score" value="1">

        <button type="button" class="btn btn-danger ms-2 remove-response"><i class="bx bx-trash me-0"></i></button>
    </div>
@endforeach
                    </div>
                </div>
                <button type="button" id="addResponseBtn" class="btn btn-primary mt-3">+ Add Response</button>
            </div>

            <div class="close-btn-popup mt-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-success" onclick="submitForm1('multipleChoiceForm{{$multipleoptionLists->unique_id}}')">Save and Apply</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </div>
    </form>
</div>
          
    @endforeach
</ul>
            </div>
        </div>
        

    </div>
    <td>    <button class="delete-question" data-id="{{$questionlists->id}}"><i class="font-20 bx bxs-trash"></i></button></td>


</td>



                                                                        </tr>
                                                                        @endforeach
                                                                        
                                                  
                                                                    
                                                                    </tbody>
                                                                </table>
</div>



                                                            <div class="card-body position-relative">
                                                                <svg class="p-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="" viewBox="0 0 24 24" width="14" height="14" focusable="false" data-anchor="plus-svg" style="cursor: pointer;" data-bs-original-title="View score column" aria-label="View score column"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#545f70"></path></svg>
                                                                
                                                                
                                                                <div class="mt-3 title-page-btns">
                                                                    


                                                                    <button id="add" class="title-btn1 add"><svg width="1.125rem" height="1.125rem" viewBox="0 0 24 24" color="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5V11H5C4.44772 11 4 11.4477 4 12C4 12.5523 4.44772 13 5 13H11V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13H19C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11H13V5Z" fill="currentColor"></path>
                                    </svg> Add Question</button>
                                                     
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                                                                           

                                                        </div>
                                                                    
                                                    </div>
                    
                                                </div>
                                            </div>
                                            
                                            <!--<a class="butn-pre-1" href="{{route('templatetypelist',Request::segment(4) ?? '')}}">Save</a>-->
                       
                                                                             <!--<div class="mt-3 addpage" style="cursor:pointer;">Add Page</div>-->
                                        </div>
                                        
                                         <div class="col-1">
                                             </div>
         
            

                                        
                                        
                                                            <div class="col-12 p-3 m-5">

                                            <div class="accordion accordion-flush" id="accordionFlushExample22">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                            <div class="row" style="    background: #e9edf6;
    padding: 10px;">
                                                                
                                                                <div class="col-2">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-controls="flush-collapseOne">
                                                           <b>PM  Checklist</b>
            <label class="radio-inline">
            <input type="radio" name="pmradio" value="yes" checked>Yes
            </label>
            <label class="radio-inline">
            <input type="radio" name="pmradio" value="no">No
            </label>
                                                        </button>
                                                        </div>
                                                        
                                                        
                                                                    
                                                                   <div class="col-2">
                                                    <select class="form-select" aria-label="Default select example">
                                                             <option value="144" seledted>Engineering(C)</option>
                                                    </select>
                                                </div>
                                                
                                        
                                                        
                                                                                                                               <div class="col-2">
 <select class="form-select" aria-label="Default select example" name="pm_frequency" onchange="updatetemplate('{{$template_details->id ?? ''}}','2')">
    <option value="">PM Frequency(In Month)</option>
    @for ($i = 0; $i < 25; $i++)
        <option value="{{$i}}" {{ ($result->pm_frequency ?? '') == $i ? 'selected' : '' }}>
            {{$i}}
        </option>
    @endfor
</select>
</div>
</div>
                                                    </h2>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse show pmsection" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample22">
                                                        <div class="accordion-body">
                                                          <div class="col-md-9">
                                                              
        

<!-- Text input-->
<div  class="form-group">
 <table class="table mb-0" border="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" style="border-bottom: 1px solid #ddd;padding: 15px 11px 8px 12px;">Questions</th>
                                                                            <th scope="col" style="border-bottom: 1px solid #ddd;padding: 15px 11px 8px 12px;" width="300">Type of responce</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="items1">
                                                                        
                                                                        @foreach($questionlist1 as $questionlists)
                                                                        <tr id="squestion_{{$questionlists->id ?? ''}}">
                                                                            <td class="d-flex align-items-center" style="border:none;">
                                                                             <div class="darg-icon"><svg viewBox="0 0 24 24" width="24" height="24" focusable="false"><path fill="none" d="M0 0h24v24H0V0z"></path><path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg></div>    
                                                                             
                                                                             <div class="content-editable-block w-100 fr1" id="updatequestion_{{$questionlists->id ?? ''}}" onkeyup="updateQuestion('{{$questionlists->id ?? ''}}','2')" contenteditable="true" value="{{$questionlists->question ?? ''}}" placeholder="{{$questionlists->question ?? ''}}" tabindex="0">{{$questionlists->question ?? ''}}</div>
                                                                            </td>
                                                                         <td>
                                                                 
                                                                             @php 
                                                                             $questionoption = DB::table('template_question')->where('id',$questionlists->id)->first();
                                                                     
                                                                             
                                                                             @endphp
                                                    
                                                    
                                                    @if(!empty($questionoption->option_id))  
                                                    
                                                    
                                                    @php
                                                    
                                                    $multipleoptionList1 = DB::table('multiple_choice_response')
                        ->where('unique_id',$questionoption->option_id)
                        ->get();
                        
                        @endphp
                                                                <!-- Default options initially displayed -->
    <div class="defaultbox" style="float: left;">
        
        @foreach($multipleoptionList1 as $multipleoptionList1s)
         <span class="option-span"
                              style="color: {{ $multipleoptionList1s->color ?? '' }}; background: {{ $multipleoptionList1s->bg_color ?? '' }}; padding: 2px 7px; border-radius: 15px; font-weight: 400; font-size: 15px;">
                            {{ $multipleoptionList1s->name ?? '' }}
                        </span>
                        
                        @endforeach

    </div>
                                                    @else
                                                            <!-- Default options initially displayed -->
    <div class="defaultbox" style="float: left;">
        <span class="info">Safe</span>
        <span class="risk">At Risk</span>
        <span class="na">N/A</span>
    </div>
                                                    @endif


    <!-- Button to open dropdown -->
    <button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">
        <span class="arrow-icon1">
            <svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">
                <path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>
            </svg>
        </span>
    </button>

    <!-- Dropdown list -->
    <div class="two-drop" style="display:none;">
        <div class="drop-contant second-opn">
                     <div class="left-form-top">
                                                                    <input class="form-control me-2" type="search"
                                                                        placeholder="Search" aria-label="Search">
                                                                    <a class="btn btn-outline-success search-btn"
                                                                        type="submit"><svg viewBox="0 0 267 267"
                                                                            width="20" height="20" focusable="false">
                                                                            <defs>
                                                                                <clipPath id="a">
                                                                                    <path d="M0 0h267v267H0z"></path>
                                                                                </clipPath>
                                                                            </defs>
                                                                            <g clip-path="url(#a)">
                                                                                <path fill="#1f2533"
                                                                                    d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z">
                                                                                </path>
                                                                                <path d="M0 0h267v267H0V0z" fill="none">
                                                                                </path>
                                                                            </g>
                                                                        </svg></a>
                                                                </div>
            <div class="title-page-box">
                <div class="title-page-box-sidebar">
                    <p>Multiple choice responses</p>
                    
                    
                    <a href="" data-bs-toggle="offcanvas" data-bs-target="#rightSlide">+Responses</a>
                </div>
<ul id="optionsList">
    @foreach($multipleoptionList as $multipleoptionLists)
        @php $list = Helper::multipleOptions($multipleoptionLists->unique_id); @endphp

        <li onclick="selectResponse(this, '{{ $multipleoptionLists->id }}','{{ $multipleoptionLists->unique_id }}','{{$questionlists->id ?? ''}}')"
            data-response-class="{{ $multipleoptionLists->id }}">

            <label>
                <input type="radio" name="response" value="{{ $multipleoptionLists->id }}">
                <div class="fair-sec">
                    @foreach($list as $lists)
                        <span class="option-span"
                              style="color: {{ $lists->color ?? '' }}; background: {{ $lists->bg_color ?? '' }}; padding: 2px 7px; border-radius: 15px; font-weight: 400; font-size: 15px;">
                            {{ $lists->name }}
                        </span>
                        
                        
                    @endforeach
                </div>
            </label>
        </li>
        
        <div class="pena-sec"><a href="" data-bs-toggle="offcanvas" data-bs-target="#rightSlide{{$multipleoptionLists->unique_id}}"><i class="bx bx-edit me-0"></i></a></div>
        
        
   <!-- Right Sidebar Blind Slide -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="rightSlide{{$multipleoptionLists->unique_id}}" aria-labelledby="rightSlideLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="rightSlideLabel">Multiple choice responses</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <form id="multipleChoiceForm{{$multipleoptionLists->unique_id}}">
        @csrf
        <div class="offcanvas-body">
            <div class="sidebar-top-sec">
                <div>e.g. Yes, No, N/A</div>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckScoring" name="scoring">
                        <label class="form-check-label" for="flexCheckScoring">Scoring</label>
                    </div>
                </div>
            </div>
            <div class="sidebar-form-first">
                <div id="responseContainer">
                    <!-- Dynamic response inputs will be appended here -->
                    <div class="sidebar-box-input response-item">
@foreach($list as $index => $lists)
    <div class="responce-input d-flex align-items-center">
        <input type="text" name="responses1[{{ $index }}][text]" class="form-control" placeholder="Response 1" value="{{ $lists->name }}">
        <input type="hidden" name="responses1[{{ $index }}][id]" class="form-control" value="{{ $lists->id }}">
        <input type="hidden" name="responses1[{{ $index }}][unique_id]" class="form-control" value="{{ $multipleoptionLists->unique_id }}">

        <div class="color-picker-styled__Container ms-2" style="display: flex; width: 300px; padding: 8px;">
            <div class="color-picker-styled__InputContainer">
                <div
                    class="color-picker-styled__SelectedColorBox"
                    style="background-color: {{ $lists->bg_color ?? '#648fff' }};"
                    onclick="toggleColorPicker(this)"
                ></div>
                <input
                    type="hidden"
                    name="responses1[{{ $index }}][color]"
                    value="{{ $lists->bg_color ?? '#648fff' }}"
                />
            </div>

            <div class="color-picker-styled__ColorBoxesContainer" style="display: none;">
                @php
                    $colors = ['#c60022', '#9c6d1e', '#fe8500', '#ffb000', '#81b532', '#13855f', '#00b6cb', '#648fff', '#0044a3', '#c22dd5', '#dc267f', '#707070'];
                @endphp
                @foreach ($colors as $color)
                    <div 
                        class="color-picker-styled__ColorBox {{ $lists->bg_color == $color ? 'selected' : '' }}" 
                        style="background-color: {{ $color }};" 
                        data-color="{{ $color }}"
                    ></div>
                @endforeach 
            </div>
        </div>
        <input type="number" name="responses1[{{ $index }}][score]" class="form-control" placeholder="Score" value="1">

        <button type="button" class="btn btn-danger ms-2 remove-response"><i class="bx bx-trash me-0"></i></button>
    </div>
@endforeach
                    </div>
                </div>
                <button type="button" id="addResponseBtn" class="btn btn-primary mt-3">+ Add Response</button>
            </div>

            <div class="close-btn-popup mt-4 d-flex justify-content-between">
                            <button type="button" class="btn btn-success" onclick="submitForm1('multipleChoiceForm{{$multipleoptionLists->unique_id}}')">Save and Apply</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </div>
    </form>
</div>
          
    @endforeach
</ul>
            </div>
        </div>
        
   
    </div>
    <td>    <button class="delete-question" data-id="{{$questionlists->id}}"><i class="font-20 bx bxs-trash"></i></button></td>


</td>



                                                                        </tr>
                                                                        @endforeach
                                                                        
                                                  
                                                                    
                                                                    </tbody>
                                                                </table>
</div>



                                                            <div class="card-body position-relative">
                                                                <svg class="p-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="" viewBox="0 0 24 24" width="14" height="14" focusable="false" data-anchor="plus-svg" style="cursor: pointer;" data-bs-original-title="View score column" aria-label="View score column"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#545f70"></path></svg>
                                                                
                                                                
                                                                <div class="mt-3 title-page-btns">
                                                                    


                                                                    <button id="add" class="title-btn1 add1"><svg width="1.125rem" height="1.125rem" viewBox="0 0 24 24" color="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5V11H5C4.44772 11 4 11.4477 4 12C4 12.5523 4.44772 13 5 13H11V19C11 19.5523 11.4477 20 12 20C12.5523 20 13 19.5523 13 19V13H19C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11H13V5Z" fill="currentColor"></path>
                                    </svg> Add Question</button>
                                                     
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                                                                           

                                                        </div>
                                                                    
                                                    </div>
                    
                                                </div>
                                            </div>
                                            
                       
                                                                             <!--<div class="mt-3 addpage" style="cursor:pointer;">Add Page</div>-->
                                        </div>
                                        <div class="col-12 align-self-center">
                                                                                        <a class="butn-pre-1" href="{{route('templatetypelist',Request::segment(4) ?? '')}}">Save</a>

                                            
                                        </div>
                                       
                                    </div> 
                                </div>
                                
                            </div>

                    </div>
                    <!--end row-->
                    
                    
                </div>
<!-- Button trigger modal -->
<div class="container">



   <!-- Right Sidebar Blind Slide -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="rightSlide" aria-labelledby="rightSlideLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="rightSlideLabel">Multiple choice responses</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <form id="multipleChoiceForm">
        @csrf
        <div class="offcanvas-body">
            <div class="sidebar-top-sec">
                <div>e.g. Yes, No, N/A</div>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckScoring" name="scoring">
                        <label class="form-check-label" for="flexCheckScoring">Scoring</label>
                    </div>
                </div>
            </div>
            <div class="sidebar-form-first">
                <div id="responseContainer">
                    <!-- Dynamic response inputs will be appended here -->
                    <div class="sidebar-box-input response-item">
                        <div class="responce-input d-flex align-items-center">
                            <input type="text" name="responses[0][text]" class="form-control" placeholder="Response 1">
                            <input type="number" name="responses[0][score]" class="form-control" placeholder="Score" value="1">
                            <div class="color-picker-styled__Container ms-2" style="display: flex; width: 300px; padding: 8px;">
                                <div class="color-picker-styled__InputContainer">
                                    <div
                                        class="color-picker-styled__SelectedColorBox"
                                        style="background-color: #648fff;"
                                        onclick="toggleColorPicker(this)"
                                    ></div>
                                    <input
                                        type="hidden"
                                        name="responses[0][color]"
                                        value="#648fff"
                                    />
                                </div>
                                <div
                                    class="color-picker-styled__ColorBoxesContainer"
                                    style="display: none;"
                                >
                                    <div class="color-picker-styled__ColorBox" style="background-color: #c60022;" data-color="#c60022"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #9c6d1e;" data-color="#9c6d1e"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #fe8500;" data-color="#fe8500"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #ffb000;" data-color="#ffb000"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #81b532;" data-color="#81b532"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #13855f;" data-color="#13855f"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #00b6cb;" data-color="#00b6cb"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #648fff;" data-color="#648fff"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #0044a3;" data-color="#0044a3"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #c22dd5;" data-color="#c22dd5"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #dc267f;" data-color="#dc267f"></div>
                                    <div class="color-picker-styled__ColorBox" style="background-color: #707070;" data-color="#707070"></div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger ms-2 remove-response"><i class="bx bx-trash me-0"></i></button>
                        </div>
                    </div>
                </div>
                <button type="button" id="addResponseBtn" class="btn btn-primary mt-3">+ Add Response</button>
            </div>

            <div class="close-btn-popup mt-4 d-flex justify-content-between">
                <button type="button" class="btn btn-success" onclick="submitForm()">Save and Apply</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </div>
    </form>
</div>


@endsection


<script>


function submitForm() {
    // Define the route URL
    const url = "{{ route('template_add_multiple_choice') }}";

    // Create a new FormData object
    const form = document.getElementById('multipleChoiceForm');
    const formData = new FormData(form);

    // Send AJAX request
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
        },
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse JSON response
    })
    .then(data => {
        console.log('Success:', data);
// Trigger the "Cancel" button to close the offcanvas
        const cancelButton = document.querySelector('[data-bs-dismiss="offcanvas"]');
        if (cancelButton) {
            cancelButton.click(); // Trigger the click event to close the offcanvas
        }
        updateOptionsList(data.data);
        
        // Clear the form fields after successful submission
        form.reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting the form.');
    });
}

function submitForm1(formId) {
    // Get the form using the passed ID
    const form = document.getElementById(formId);
    if (!form) {
        console.error("Form not found:", formId);
        return;
    }

    // Define the route URL
    const url = "{{ route('edit_multiple_choice') }}";

    // Create FormData object
    const formData = new FormData(form);

    // Send AJAX request
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
        },
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json(); // Parse JSON response
    })
    .then(data => {
        console.log('Success:', data);

        // Close the offcanvas popup
        const cancelButton = document.querySelector('[data-bs-dismiss="offcanvas"]');
        if (cancelButton) {
            cancelButton.click();
        }

        // Update response list if needed
        updateOptionsList(data.data);

        // Clear the form fields after successful submission
        form.reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting the form.');
    });
}

// Function to update the <ul> dynamically
function updateOptionsList(newResponses) {
    const ul = document.querySelector("#optionsList"); // Get the <ul> element

    newResponses.forEach(response => {
        let li = document.createElement("li");
        li.setAttribute("onclick", `selectResponse(this, '${response.unique_id}')`);
        li.setAttribute("data-response-class", response.unique_id);

        li.innerHTML = `
            <label>
                <input type="radio" name="response" value="${response.unique_id}">
                <div class="fair-sec">
                    <span class="option-span" 
                          style="color: #fff; background: ${response.bg_color}; padding: 2px 7px; border-radius: 15px; font-weight: 400; font-size: 15px;">
                        ${response.name}
                    </span>
                </div>
            </label>
        `;

        ul.appendChild(li); // Append the new item to the list
    });
}

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
  const colorPickerInput = document.getElementById("colorPicker");
  const colorBoxesContainer = document.getElementById("colorBoxesContainer");
  const selectedColorBox = document.getElementById("selectedColor");

  // Open custom color picker on input click
  selectedColorBox.addEventListener("click", () => {
    colorBoxesContainer.style.display =
      colorBoxesContainer.style.display === "none" ? "flex" : "none";
  });

  // Close the custom color picker when clicking outside
  document.addEventListener("click", (e) => {
    if (!colorBoxesContainer.contains(e.target) && !selectedColorBox.contains(e.target)) {
      colorBoxesContainer.style.display = "none";
    }
  });

  // Handle color selection
  colorBoxesContainer.addEventListener("click", (e) => {
    if (e.target.classList.contains("color-picker-styled__ColorBox")) {
      const selectedColor = e.target.getAttribute("color");
      selectedColorBox.style.backgroundColor = selectedColor;
      colorPickerInput.value = selectedColor; // Update the hidden color input
      colorBoxesContainer.style.display = "none";
    }
  });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#image').on('change', function () {
            let formData = new FormData($('#imageUploadForm')[0]);
            var id = '{{ $template_id }}'; // Capture the template ID
            formData.append('template_id', id); // Add template ID to form data

            $.ajax({
                url: '{{ route('templates_uploadImage') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // Use the URL received in the response
                        let imageUrl = 'https://efsm.safefoodmitra.com/admin/public/template/' + response.image; // Adjust based on your actual URL structure
                        $('.img-profile').html('<img src="' + imageUrl + '" alt="Image Preview" style="max-width: 200px; max-height: 200px;">');
                    } else {
                        alert(response.error);
                    }
                },
                error: function (response) {
                    alert('An error occurred while uploading the image.');
                }
            });
        });
    });
    

</script>
<script>

<?php

$result = DB::table('template_question')->orderBy('id', 'desc')->first();
$newId = $result->id + 1;
// Generate options in PHP first
$optionListHtml = '';
foreach ($multipleoptionList as $multipleoptionLists) {
    $list = Helper::multipleOptions($multipleoptionLists->unique_id);
    
    // Escape variables to prevent XSS vulnerabilities
    $escapedUniqueId = htmlspecialchars($multipleoptionLists->unique_id, ENT_QUOTES, 'UTF-8');
    $escapedId = htmlspecialchars($multipleoptionLists->id, ENT_QUOTES, 'UTF-8');
    
    $optionListHtml .= "<li onclick=\"selectResponse(this, '{$escapedId}', '{$escapedUniqueId}','{$newId}')\" 
                            data-response-class=\"{$escapedId}\">
                            <label>
                                <input type='radio' name='response' value='{$escapedId}'>
                                <div class='fair-sec'>";
    
    // Loop through the options
    foreach ($list as $lists) {
        // Escape colors and names to prevent injection attacks
        $color = htmlspecialchars($lists->color ?? '', ENT_QUOTES, 'UTF-8');
        $bgColor = htmlspecialchars($lists->bg_color ?? '', ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($lists->name, ENT_QUOTES, 'UTF-8');
        
        $optionListHtml .= "<span class='option-span' 
                            style='color: {$color}; background: {$bgColor}; padding: 2px 7px; 
                            border-radius: 15px; font-weight: 400; font-size: 15px;'>
                            {$name}
                            </span>";
    }
    
    $optionListHtml .= "    </div>
                            </label>
                        </li>
                        <div class='pena-sec'>
                            <a href='' data-bs-toggle='offcanvas' data-bs-target='#rightSlide{$escapedUniqueId}'>
                                <i class='bx bx-edit me-0'></i>
                            </a>
                        </div>";
}
?>


    $(document).ready(function() {
        $(".delete").hide();
        //when the Add Field button is clicked
$(".add").click(function(e) {
    $(".delete").fadeIn(1500);

    var id = '{{ $template_id }}'; 
    $.ajax({
        url: '{{ route('templates_addquestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            var id = response.id;
var type = 1;
            // Append a new row of code to the "#items" div
            $("#items").append(
                '<tr id="squestion_' + id + '">' +
                    '<td class="d-flex align-items-center" style="border:none;">' +
                        '<div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" class="add-question2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" class="add-section2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">' +
                            '<svg viewBox="0 0 24 24" width="24" height="24" focusable="false">' +
                                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                                '<path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>' +
                            '</svg>' +
                        '</div>' +
                        '<span class="required-icon">*</span>' +
                        '<div class="content-editable-block w-100 fr1" id="updatequestion_' + id + '" onkeyup="updateQuestion(' + id + ',' + type + ')" contenteditable="true" placeholder="Type Question" tabindex="0"></div>' +
                    '</td>' +
                    '<td>' +
                        // Default options initially displayed
                        '<div class="defaultbox" style="float: left;">' +
                            '<span class="info">Safe</span>' +
                            '<span class="risk">At Risk</span>' +
                            '<span class="na">N/A</span>' +
                        '</div>' +

                        // Button to open dropdown
                        '<button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">' +
                            '<span class="arrow-icon1">' +
                                '<svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">' +
                                    '<path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>' +
                                '</svg>' +
                            '</span>' +
                        '</button>' +

                        // Dropdown list
                        '<div class="two-drop" style="display:none;">' +
                            '<div class="drop-contant second-opn">' +
                                '<div class="left-form-top">' +
                                    '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">' +
                                    '<a class="btn btn-outline-success search-btn" type="submit">' +
                                        '<svg viewBox="0 0 267 267" width="20" height="20" focusable="false">' +
                                            '<defs>' +
                                                '<clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>' +
                                            '</defs>' +
                                            '<g clip-path="url(#a)">' +
                                                '<path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>' +
                                            '</g>' +
                                        '</svg>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="title-page-box">' +
                                    '<div class="title-page-box-sidebar">' +
                                        '<p>Multiple choice responses</p>' +
                                        '<a href="" data-bs-toggle="offcanvas" data-bs-target="#rightSlide">+Responses</a>' +
                                    '</div>' +
                        '<ul>' +
                                `<?php echo $optionListHtml; ?>` + // Inject pre-generated PHP content
                            '</ul>' +
                                '</div>' +
                            '</div>' +
                            '<div class="drop-contant">'+
                            '<div class="title-page-box">'+
                        '<p>Site conducted</p>'+
                        '<ul>'+
                            '<li class="active"><a href=""> <svg data-anchor="sell-black-svg" viewBox="0 0 24 24" width="15" height="15" fill="#648fff" focusable="false"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z" fill="#648fff"></path></svg> Site</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false"><g fill="#fe8500" fill-rule="nonzero"><path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path></g></svg> Document number</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 24 24" color="#5e9cff" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z" fill="currentColor"></path></svg> Asset</a></li>'+
                        '</ul>'+
                    '</div>'+
                     '<div class="title-page-box">'+
            '<p>Other responses</p>'+
            '<ul>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<path d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z" fill="#fe8500" fill-rule="nonzero"></path>'+
                '</svg> Text answer</a></li>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<g fill="#ffb000" fill-rule="nonzero">'+
                        '<path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path>'+
                    '</g>'+
                '</svg> Number</a></li>'+
                '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" data-anchor="checked-checkbox-svg">'+
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>'+
                    '<path fill="#5e9cff" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z"></path>'+
                '</svg> checkbox</a></li>'+
            '</ul>'+
        '</div>'+
        '<div class="title-page-box">' +
        '<ul>' +
            '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false">' +
                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                '<path fill="#81b532" d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z"></path>' +
            '</svg> Date & Time</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 16 16" focusable="false" fill="none">' +
                '<path d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z" fill="#00b6cb"></path>' +
            '</svg> Media</a></li>' +
            '<li><a href=""> <svg viewBox="0 0 14 14" width="15" height="15" focusable="false">' +
                '<g id="icon_slider_v2" fill="none" fill-rule="evenodd">' +
                    '<g id="Group" transform="translate(1.5 1)" fill="#1ecf93">' +
                        '<g id="Group-3">' +
                            '<g id="Group-2">' +
                                '<path d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z" id="Combined-Shape"></path>' +
                                '<rect id="Rectangle-Copy-2" x="2.25" y="0.5" width="3" height="5" rx="0.5"></rect>' +
                            '</g>' +
                        '</g>' +
                    '</g>' +
                '</g>' +
            '</svg> Slider</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<g id="icon_annotate_2" fill="none" fill-rule="evenodd">' +
                    '<path d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z" id="Shape" fill="#ffb000" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Annotation</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z" fill="#00b6cb" fill-rule="nonzero"></path>' +
            '</svg> Signature</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14">' +
                '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                    '<path d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z" fill="#fe8500" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Location</a></li>' +
        '</ul>' +
    '</div>' +
    '<div class="title-page-box">' +
        '<ul>' +
            '<li class="active"><a href=""><svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z" fill="#648fff" fill-rule="nonzero"></path>' +
            '</svg> Instruction</a></li>' +
        '</ul>' +
    '</div>' +
                        '</div>' +
                        
                        '</div>' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-question" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>'
            );
            
        $('td .fRTxQu').hide();
        
        // Show only the specific tr with dynamic ID
        $('#question_' + id + ' .fRTxQu').show();
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
});

$(".add1").click(function(e) {
    $(".delete").fadeIn(1500);

    var id = '{{ $template_id }}'; 
    $.ajax({
        url: '{{ route('templates_addquestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            var id = response.id;
var type = 2;
            // Append a new row of code to the "#items" div
            $("#items1").append(
                '<tr id="squestion_' + id + '">' +
                    '<td class="d-flex align-items-center" style="border:none;">' +
                        '<div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" class="add-question2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" class="add-section2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">' +
                            '<svg viewBox="0 0 24 24" width="24" height="24" focusable="false">' +
                                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                                '<path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>' +
                            '</svg>' +
                        '</div>' +
                        '<span class="required-icon">*</span>' +
                        '<div class="content-editable-block w-100 fr1" id="updatequestion_' + id + '" onkeyup="updateQuestion(' + id + ',' + type + ')" contenteditable="true" placeholder="Type Question" tabindex="0"></div>' +
                    '</td>' +
                    '<td>' +
                        // Default options initially displayed
                        '<div class="defaultbox" style="float: left;">' +
                            '<span class="info">Safe</span>' +
                            '<span class="risk">At Risk</span>' +
                            '<span class="na">N/A</span>' +
                        '</div>' +

                        // Button to open dropdown
                        '<button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">' +
                            '<span class="arrow-icon1">' +
                                '<svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">' +
                                    '<path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>' +
                                '</svg>' +
                            '</span>' +
                        '</button>' +

                        // Dropdown list
                        '<div class="two-drop" style="display:none;">' +
                            '<div class="drop-contant second-opn">' +
                                '<div class="left-form-top">' +
                                    '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">' +
                                    '<a class="btn btn-outline-success search-btn" type="submit">' +
                                        '<svg viewBox="0 0 267 267" width="20" height="20" focusable="false">' +
                                            '<defs>' +
                                                '<clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>' +
                                            '</defs>' +
                                            '<g clip-path="url(#a)">' +
                                                '<path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>' +
                                            '</g>' +
                                        '</svg>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="title-page-box">' +
                                    '<div class="title-page-box-sidebar">' +
                                        '<p>Multiple choice responses</p>' +
                                        '<a href="" data-bs-toggle="offcanvas" data-bs-target="#rightSlide">+Responses</a>' +
                                    '</div>' +
                        '<ul>' +
                                `<?php echo $optionListHtml; ?>` + // Inject pre-generated PHP content
                            '</ul>' +
                                '</div>' +
                            '</div>' +
                            '<div class="drop-contant">'+
                            '<div class="title-page-box">'+
                        '<p>Site conducted</p>'+
                        '<ul>'+
                            '<li class="active"><a href=""> <svg data-anchor="sell-black-svg" viewBox="0 0 24 24" width="15" height="15" fill="#648fff" focusable="false"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z" fill="#648fff"></path></svg> Site</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false"><g fill="#fe8500" fill-rule="nonzero"><path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path></g></svg> Document number</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 24 24" color="#5e9cff" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z" fill="currentColor"></path></svg> Asset</a></li>'+
                        '</ul>'+
                    '</div>'+
                     '<div class="title-page-box">'+
            '<p>Other responses</p>'+
            '<ul>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<path d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z" fill="#fe8500" fill-rule="nonzero"></path>'+
                '</svg> Text answer</a></li>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<g fill="#ffb000" fill-rule="nonzero">'+
                        '<path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path>'+
                    '</g>'+
                '</svg> Number</a></li>'+
                '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" data-anchor="checked-checkbox-svg">'+
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>'+
                    '<path fill="#5e9cff" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z"></path>'+
                '</svg> checkbox</a></li>'+
            '</ul>'+
        '</div>'+
        '<div class="title-page-box">' +
        '<ul>' +
            '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false">' +
                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                '<path fill="#81b532" d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z"></path>' +
            '</svg> Date & Time</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 16 16" focusable="false" fill="none">' +
                '<path d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z" fill="#00b6cb"></path>' +
            '</svg> Media</a></li>' +
            '<li><a href=""> <svg viewBox="0 0 14 14" width="15" height="15" focusable="false">' +
                '<g id="icon_slider_v2" fill="none" fill-rule="evenodd">' +
                    '<g id="Group" transform="translate(1.5 1)" fill="#1ecf93">' +
                        '<g id="Group-3">' +
                            '<g id="Group-2">' +
                                '<path d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z" id="Combined-Shape"></path>' +
                                '<rect id="Rectangle-Copy-2" x="2.25" y="0.5" width="3" height="5" rx="0.5"></rect>' +
                            '</g>' +
                        '</g>' +
                    '</g>' +
                '</g>' +
            '</svg> Slider</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<g id="icon_annotate_2" fill="none" fill-rule="evenodd">' +
                    '<path d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z" id="Shape" fill="#ffb000" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Annotation</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z" fill="#00b6cb" fill-rule="nonzero"></path>' +
            '</svg> Signature</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14">' +
                '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                    '<path d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z" fill="#fe8500" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Location</a></li>' +
        '</ul>' +
    '</div>' +
    '<div class="title-page-box">' +
        '<ul>' +
            '<li class="active"><a href=""><svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z" fill="#648fff" fill-rule="nonzero"></path>' +
            '</svg> Instruction</a></li>' +
        '</ul>' +
    '</div>' +
                        '</div>' +
                        
                        '</div>' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-question" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>'
            );
            
        $('td .fRTxQu').hide();
        
        // Show only the specific tr with dynamic ID
        $('#1question_' + id + ' .fRTxQu').show();
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
});
$(".Addsection").click(function(e) {
    $(".delete").fadeIn("1500");
    
    var id = '{{ $template_id }}'; 
    $.ajax({
        url: '{{ route('templates_addquestionsection') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            var id = response.id;

            // Append a new row of code to the "#items" div
            $("#items").append(
                '<tr id="section_' + id + '" class="sectionbox">' +
                    '<td colspan="2">' +
                    
                        '<input class="content-editable-block w-100 fr1 adpage-inpt" id="sectionname_' + id + '" onkeyup="updateSection(' + id + ')" placeholder="Type Section Title">' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-section" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>' +
                 '<tr id="question_' + id + '">' +
                    '<td class="d-flex align-items-center" style="border:none;">' +
                    '<div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" class="add-question2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" class="add-section2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">' +
                            '<svg viewBox="0 0 24 24" width="24" height="24" focusable="false">' +
                                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                                '<path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>' +
                            '</svg>' +
                        '</div>' +
                        '<span class="required-icon">*</span>' +
                        '<div class="content-editable-block w-100 fr1" id="question_' + id + '" onkeyup="updateQuestion(' + id + ')" contenteditable="true" placeholder="Type Question" tabindex="0"></div>' +
                    '</td>' +
                    '<td>' +
                        // Default options initially displayed
                        '<div class="defaultbox" style="float: left;">' +
                            '<span class="info">Safe</span>' +
                            '<span class="risk">At Risk</span>' +
                            '<span class="na">N/A</span>' +
                        '</div>' +

                        // Button to open dropdown
                        '<button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">' +
                            '<span class="arrow-icon1">' +
                                '<svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">' +
                                    '<path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>' +
                                '</svg>' +
                            '</span>' +
                        '</button>' +

                        // Dropdown list
                        '<div class="two-drop" style="display:none;">' +
                            '<div class="drop-contant second-opn">' +
                                '<div class="left-form-top">' +
                                    '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">' +
                                    '<a class="btn btn-outline-success search-btn" type="submit">' +
                                        '<svg viewBox="0 0 267 267" width="20" height="20" focusable="false">' +
                                            '<defs>' +
                                                '<clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>' +
                                            '</defs>' +
                                            '<g clip-path="url(#a)">' +
                                                '<path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>' +
                                            '</g>' +
                                        '</svg>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="title-page-box">' +
                                    '<div class="title-page-box-sidebar">' +
                                        '<p>Multiple choice responses</p>' +
                                    '</div>' +
                   '<ul>' +
                                `<?php echo $optionListHtml; ?>` + // Inject pre-generated PHP content
                            '</ul>' +
                                '</div>' +
                            '</div>' +
                             '<div class="drop-contant">'+
                            '<div class="title-page-box">'+
                        '<p>Site conducted</p>'+
                        '<ul>'+
                            '<li class="active"><a href=""> <svg data-anchor="sell-black-svg" viewBox="0 0 24 24" width="15" height="15" fill="#648fff" focusable="false"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z" fill="#648fff"></path></svg> Site</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false"><g fill="#fe8500" fill-rule="nonzero"><path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path></g></svg> Document number</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 24 24" color="#5e9cff" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z" fill="currentColor"></path></svg> Asset</a></li>'+
                        '</ul>'+
                    '</div>'+
                     '<div class="title-page-box">'+
            '<p>Other responses</p>'+
            '<ul>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<path d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z" fill="#fe8500" fill-rule="nonzero"></path>'+
                '</svg> Text answer</a></li>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<g fill="#ffb000" fill-rule="nonzero">'+
                        '<path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path>'+
                    '</g>'+
                '</svg> Number</a></li>'+
                '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" data-anchor="checked-checkbox-svg">'+
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>'+
                    '<path fill="#5e9cff" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z"></path>'+
                '</svg> checkbox</a></li>'+
            '</ul>'+
        '</div>'+
        '<div class="title-page-box">' +
        '<ul>' +
            '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false">' +
                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                '<path fill="#81b532" d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z"></path>' +
            '</svg> Date & Time</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 16 16" focusable="false" fill="none">' +
                '<path d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z" fill="#00b6cb"></path>' +
            '</svg> Media</a></li>' +
            '<li><a href=""> <svg viewBox="0 0 14 14" width="15" height="15" focusable="false">' +
                '<g id="icon_slider_v2" fill="none" fill-rule="evenodd">' +
                    '<g id="Group" transform="translate(1.5 1)" fill="#1ecf93">' +
                        '<g id="Group-3">' +
                            '<g id="Group-2">' +
                                '<path d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z" id="Combined-Shape"></path>' +
                                '<rect id="Rectangle-Copy-2" x="2.25" y="0.5" width="3" height="5" rx="0.5"></rect>' +
                            '</g>' +
                        '</g>' +
                    '</g>' +
                '</g>' +
            '</svg> Slider</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<g id="icon_annotate_2" fill="none" fill-rule="evenodd">' +
                    '<path d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z" id="Shape" fill="#ffb000" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Annotation</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z" fill="#00b6cb" fill-rule="nonzero"></path>' +
            '</svg> Signature</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14">' +
                '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                    '<path d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z" fill="#fe8500" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Location</a></li>' +
        '</ul>' +
    '</div>' +
    '<div class="title-page-box">' +
        '<ul>' +
            '<li class="active"><a href=""><svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z" fill="#648fff" fill-rule="nonzero"></path>' +
            '</svg> Instruction</a></li>' +
        '</ul>' +
    '</div>' +
                        '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-question" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>'
            );
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
});
        $("body").on("click", ".delete", function(e) {
            $(".next-referral").last().remove();
        });
        
        
        let id = 1;
        $(document).ready(function() {
    var id = '{{ $template_id }}'; // Initialize the template ID

   
    
    
    
});

        $("body").on("click", ".delete", function(e) {
            $(".next-referral").last().remove();
        });
        
        
        
    });
</script>








<script>

<?php
// Generate options in PHP first
$optionListHtml = '';
foreach ($multipleoptionList as $multipleoptionLists) {
    $list = Helper::multipleOptions($multipleoptionLists->unique_id);
    $optionListHtml .= "<li onclick=\"selectResponse(this, '{$multipleoptionLists->id}')\" 
                            data-response-class=\"{$multipleoptionLists->id}\">
                            <label>
                                <input type='radio' name='response' value='{$multipleoptionLists->id}'>
                                <div class='fair-sec'>";
    foreach ($list as $lists) {
        $color = $lists->color ?? '';
        $bgColor = $lists->bg_color ?? '';
        $optionListHtml .= "<span class='option-span' 
                            style='color: {$color}; background: {$bgColor}; padding: 2px 7px; 
                            border-radius: 15px; font-weight: 400; font-size: 15px;'>
                            {$lists->name}
                            </span>";
    }
    $optionListHtml .= "    </div>
                            </label>
                        </li>";
}
?>
$(document).ready(function () {
    let id = 0; // Initialize id if needed

    // Add Page functionality
    $(".addpage").click(function (e) {
        e.preventDefault(); // Prevent default button behavior
        $(".delete").fadeIn(1500);
        id++; // Increment ID for each new item

        $.ajax({
            url: '{{ route('templates_addpage') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function (response) {
                var newId = response.id;

                // Append a new accordion item
                $("#accordionFlushExample").append(`
                    <div class="accordion-item page" id="page_${newId}">
                        <h2 class="accordion-header" id="flush-heading${newId}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse${newId}" aria-controls="flush-collapse${newId}">
                            </button>
                            <input type="text" class="pagetemplate" id="templatepage_${newId}" onkeyup="updatepage(${newId})" value="Untitled Page" placeholder="Untitled Page">
                        </h2>
                        <div id="flush-collapse${newId}" class="accordion-collapse collapse show" aria-labelledby="flush-heading${newId}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>The Title Page is the first page of your inspection report. You can customize the Title Page below.</p>
                                <div class="card col-md-9">
                                    <div class="form-group">
                                        <table class="table mb-0" border="1">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Questions</th>
                                                    <th scope="col" width="300">Type of response</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="items_${newId}">
                                                <!-- Questions will be appended here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-body position-relative">
                                        <div class="mt-3 title-page-btns">
                                            <button class="title-btn1 add-question" data-id="${newId}">Add Question</button>
                                            <button class="title-btn2 add-section" data-id="${newId}">Add Section</button>
                                            <button class="title-btn3 delete-page" data-id="${newId}"><i class="font-20 bx bxs-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            },
            error: function (xhr, status, error) {
                console.error('Error updating template:', error);
                console.error(xhr.responseText);
            }
        });
    });

    // Event delegation for dynamically added Add Question button
    $("#accordionFlushExample").on("click", ".add-question", function () {
        let currentId = $(this).data("id"); // Get the accordion page ID

        $.ajax({
            url: '{{ route('templates_addquestion') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: currentId // Send the page ID for which the question is being added
            },
            success: function (response) {
                let questionId = response.id;

                // Append the new question to the corresponding table body based on page ID
                $(`#items_${currentId}`).append(`
                    <tr id="question_${questionId}">
                        <td class="d-flex align-items-center" style="border:none;">
                           <div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" onclick="addquestion(${currentId})" class="add-question1 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" onclick="addsection(${currentId})" class="add-section3 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">
                            <svg viewBox="0 0 24 24" width="24" height="24" focusable="false">
                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                <path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                            </svg>
                        </div>
                            <span class="required-icon">*</span>
                            <div class="content-editable-block w-100 fr1" id="question_${questionId}" onkeyup="updateQuestion(${questionId})" contenteditable="true" placeholder="Type Question" tabindex="0"></div>
                        </td>
                        <td>
    <!-- Default options initially displayed -->
    <div class="defaultbox" style="float: left;">
        <span class="info">Safe</span>
        <span class="risk">At Risk</span>
        <span class="na">N/A</span>
    </div>

    <!-- Button to open dropdown -->
    <button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">
        <span class="arrow-icon1">
            <svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">
                <path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>
            </svg>
        </span>
    </button>

    <!-- Dropdown list -->
    <div class="two-drop" style="display:none;">
        <div class="drop-contant second-opn">
                     <div class="left-form-top">
                                                                    <input class="form-control me-2" type="search"
                                                                        placeholder="Search" aria-label="Search">
                                                                    <a class="btn btn-outline-success search-btn"
                                                                        type="submit"><svg viewBox="0 0 267 267"
                                                                            width="20" height="20" focusable="false">
                                                                            <defs>
                                                                                <clipPath id="a">
                                                                                    <path d="M0 0h267v267H0z"></path>
                                                                                </clipPath>
                                                                            </defs>
                                                                            <g clip-path="url(#a)">
                                                                                <path fill="#1f2533"
                                                                                    d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z">
                                                                                </path>
                                                                                <path d="M0 0h267v267H0V0z" fill="none">
                                                                                </path>
                                                                            </g>
                                                                        </svg></a>
                                                                </div>
            <div class="title-page-box">
                <div class="title-page-box-sidebar">
                    <p>Multiple choice responses</p>
                </div>
                
<ul><?php echo $optionListHtml; ?></ul>
            </div>
        </div>
        
        <div class="drop-contant">
                                                                <div class="title-page-box">
                                                                    <p>Site conducted</p>
                                                                    <ul>
                                                                        <li class="active"><a href=""> <svg
                                                                                    data-anchor="sell-black-svg"
                                                                                    viewBox="0 0 24 24" width="15"
                                                                                    height="15" fill="#648fff"
                                                                                    focusable="false">
                                                                                    <path d="M0 0h24v24H0V0z"
                                                                                        fill="none"></path>
                                                                                    <path
                                                                                        d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z"
                                                                                        fill="#648fff"></path>
                                                                                </svg> Site</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <g fill="#fe8500"
                                                                                        fill-rule="nonzero">
                                                                                        <path
                                                                                            d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z">
                                                                                        </path>
                                                                                    </g>
                                                                                </svg> Document number</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 24 24" color="#5e9cff"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd"
                                                                                        clip-rule="evenodd"
                                                                                        d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z"
                                                                                        fill="currentColor"></path>
                                                                                </svg> Asset</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="title-page-box">
                                                                    <p>Other responses</p>
                                                                    <ul>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <path
                                                                                        d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z"
                                                                                        fill="#fe8500"
                                                                                        fill-rule="nonzero"></path>
                                                                                </svg> Text answer</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <g fill="#ffb000"
                                                                                        fill-rule="nonzero">
                                                                                        <path
                                                                                            d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z">
                                                                                        </path>
                                                                                    </g>
                                                                                </svg> Number</a></li>
                                                                        <li><a href=""> <svg viewBox="0 0 24 24"
                                                                                    width="15" height="15"
                                                                                    focusable="false"
                                                                                    data-anchor="checked-checkbox-svg">
                                                                                    <path fill="none"
                                                                                        d="M0 0h24v24H0V0z"></path>
                                                                                    <path fill="#5e9cff"
                                                                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z">
                                                                                    </path>
                                                                                </svg> checkbox</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="title-page-box">
                                                                    <!-- <p>Site conducted</p> -->
                                                                    <ul>
                                                                        <li><a href=""> <svg viewBox="0 0 24 24"
                                                                                    width="15" height="15"
                                                                                    focusable="false">
                                                                                    <path fill="none"
                                                                                        d="M0 0h24v24H0V0z"></path>
                                                                                    <path fill="#81b532"
                                                                                        d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z">
                                                                                    </path>
                                                                                </svg> Date & Time</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 16 16"
                                                                                    focusable="false" fill="none">
                                                                                    <path
                                                                                        d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z"
                                                                                        fill="#00b6cb"></path>
                                                                                </svg> Media</a></li>
                                                                        <li><a href=""> <svg viewBox="0 0 14 14"
                                                                                    width="15" height="15"
                                                                                    focusable="false">
                                                                                    <g id="icon_slider_v2" fill="none"
                                                                                        fill-rule="evenodd">
                                                                                        <g id="Group"
                                                                                            transform="translate(1.5 1)"
                                                                                            fill="#1ecf93">
                                                                                            <g id="Group-3">
                                                                                                <g id="Group-2">
                                                                                                    <path
                                                                                                        d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z"
                                                                                                        id="Combined-Shape">
                                                                                                    </path>
                                                                                                    <rect
                                                                                                        id="Rectangle-Copy-2"
                                                                                                        x="2.25" y="0.5"
                                                                                                        width="3"
                                                                                                        height="5"
                                                                                                        rx="0.5"></rect>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g id="Group-3-Copy"
                                                                                                transform="matrix(-1 0 0 1 11 6)">
                                                                                                <g id="Group-2">
                                                                                                    <path
                                                                                                        d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z"
                                                                                                        id="Combined-Shape">
                                                                                                    </path>
                                                                                                    <rect
                                                                                                        id="Rectangle-Copy-2"
                                                                                                        x="2.25" y="0.5"
                                                                                                        width="3"
                                                                                                        height="5"
                                                                                                        rx="0.5"></rect>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </svg> Slider</a></li>
                                                                        <li><a href=""> <svg viewBox="0 0 14 14"
                                                                                    width="15" height="15"
                                                                                    focusable="false">
                                                                                    <g id="icon_annotate_2" fill="none"
                                                                                        fill-rule="evenodd">
                                                                                        <path
                                                                                            d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z"
                                                                                            id="Shape" fill="#ffb000"
                                                                                            fill-rule="nonzero"></path>
                                                                                    </g>
                                                                                </svg> Annotation</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <path
                                                                                        d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z"
                                                                                        fill="#00b6cb"
                                                                                        fill-rule="nonzero"></path>
                                                                                </svg> Signature</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14">
                                                                                    <g stroke="none" stroke-width="1"
                                                                                        fill="none" fill-rule="evenodd">
                                                                                        <path
                                                                                            d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z"
                                                                                            fill="#fe8500"
                                                                                            fill-rule="nonzero"></path>
                                                                                    </g>
                                                                                </svg> Location</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="title-page-box">

                                                                    <ul>
                                                                        <li class="active"><a href=""><svg width="15"
                                                                                    height="15" viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <path
                                                                                        d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z"
                                                                                        fill="#648fff"
                                                                                        fill-rule="nonzero"></path>
                                                                                </svg> Instruction</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
    </div>
</td>
                        <td>
                            <button class="delete-question" data-id="${questionId}"><i class="font-20 bx bxs-trash"></i></button>
                        </td>
                    </tr>
                `);
                
                $('td .fRTxQu').hide();

// Show only the specific tr with dynamic ID
$('#question_' + questionId + ' .fRTxQu').show();
            },
            error: function (xhr, status, error) {
                console.error('Error adding question:', error);
                console.error(xhr.responseText);
            }
        });
    });

    // Event delegation for dynamically added Add Section button
    $("#accordionFlushExample").on("click", ".add-section", function () {
    let currentId = $(this).data("id"); // Get the accordion page ID

    $.ajax({
        url: '{{ route('templates_addquestionsection') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: currentId // Send the page ID for which the section is being added
        },
        success: function (response) {
            let sectionId = response.id;

            // Append the new section input field to the corresponding table body based on page ID
            $(`#items_${currentId}`).append(`
                <tr class="sectionbox" id="section_${sectionId}">
                    <td colspan="2">
                        <input class="content-editable-block w-100 fr1 adpage-inpt" id="sectionname_${sectionId}" onkeyup="updateSection(${sectionId})" placeholder="Type Section Title">
                    </td>
                    <td>
                        <button class="delete-section" data-id="${sectionId}"><i class="font-20 bx bxs-trash"></i></button>
                    </td>
                </tr>
                <tr id="question_${sectionId}">
                    <td class="d-flex align-items-center" style="border:none;">
                        <div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" onclick="addquestion(${currentId})" class="add-question1 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" onclick="addsection(${currentId})" class="add-section3 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">
                            <svg viewBox="0 0 24 24" width="24" height="24" focusable="false">
                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                <path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                            </svg>
                        </div>
                        <span class="required-icon">*</span>
                        <div class="content-editable-block w-100 fr1" id="question_${sectionId}" onkeyup="updateQuestion(${sectionId})" contenteditable="true" placeholder="Type Question" tabindex="0"></div>
                    </td>
                    <td>
                        <div class="defaultbox" style="float: left;">
                            <span class="info">Safe</span>
                            <span class="risk">At Risk</span>
                            <span class="na">N/A</span>
                        </div>
                        <button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">
                            <span class="arrow-icon1">
                                <svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">
                                    <path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="two-drop" style="display:none;">
                            <div class="drop-contant second-opn">
                                <div class="left-form-top">
                                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                    <a class="btn btn-outline-success search-btn" type="submit">
                                        <svg viewBox="0 0 267 267" width="20" height="20" focusable="false">
                                            <defs>
                                                <clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>
                                            </defs>
                                            <g clip-path="url(#a)">
                                                <path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                                <div class="title-page-box">
                                    <div class="title-page-box-sidebar">
                                        <p>Multiple choice responses</p>
                                    </div>
                                    <ul>
                                       <?php echo $optionListHtml; ?>
                                    </ul>
                                </div>
                                
                            </div>
                               <div class="drop-contant">
                                                                <div class="title-page-box">
                                                                    <p>Site conducted</p>
                                                                    <ul>
                                                                        <li class="active"><a href=""> <svg
                                                                                    data-anchor="sell-black-svg"
                                                                                    viewBox="0 0 24 24" width="15"
                                                                                    height="15" fill="#648fff"
                                                                                    focusable="false">
                                                                                    <path d="M0 0h24v24H0V0z"
                                                                                        fill="none"></path>
                                                                                    <path
                                                                                        d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z"
                                                                                        fill="#648fff"></path>
                                                                                </svg> Site</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <g fill="#fe8500"
                                                                                        fill-rule="nonzero">
                                                                                        <path
                                                                                            d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z">
                                                                                        </path>
                                                                                    </g>
                                                                                </svg> Document number</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 24 24" color="#5e9cff"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd"
                                                                                        clip-rule="evenodd"
                                                                                        d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z"
                                                                                        fill="currentColor"></path>
                                                                                </svg> Asset</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="title-page-box">
                                                                    <p>Other responses</p>
                                                                    <ul>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <path
                                                                                        d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z"
                                                                                        fill="#fe8500"
                                                                                        fill-rule="nonzero"></path>
                                                                                </svg> Text answer</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <g fill="#ffb000"
                                                                                        fill-rule="nonzero">
                                                                                        <path
                                                                                            d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z">
                                                                                        </path>
                                                                                    </g>
                                                                                </svg> Number</a></li>
                                                                        <li><a href=""> <svg viewBox="0 0 24 24"
                                                                                    width="15" height="15"
                                                                                    focusable="false"
                                                                                    data-anchor="checked-checkbox-svg">
                                                                                    <path fill="none"
                                                                                        d="M0 0h24v24H0V0z"></path>
                                                                                    <path fill="#5e9cff"
                                                                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z">
                                                                                    </path>
                                                                                </svg> checkbox</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="title-page-box">
                                                                    <!-- <p>Site conducted</p> -->
                                                                    <ul>
                                                                        <li><a href=""> <svg viewBox="0 0 24 24"
                                                                                    width="15" height="15"
                                                                                    focusable="false">
                                                                                    <path fill="none"
                                                                                        d="M0 0h24v24H0V0z"></path>
                                                                                    <path fill="#81b532"
                                                                                        d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z">
                                                                                    </path>
                                                                                </svg> Date & Time</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 16 16"
                                                                                    focusable="false" fill="none">
                                                                                    <path
                                                                                        d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z"
                                                                                        fill="#00b6cb"></path>
                                                                                </svg> Media</a></li>
                                                                        <li><a href=""> <svg viewBox="0 0 14 14"
                                                                                    width="15" height="15"
                                                                                    focusable="false">
                                                                                    <g id="icon_slider_v2" fill="none"
                                                                                        fill-rule="evenodd">
                                                                                        <g id="Group"
                                                                                            transform="translate(1.5 1)"
                                                                                            fill="#1ecf93">
                                                                                            <g id="Group-3">
                                                                                                <g id="Group-2">
                                                                                                    <path
                                                                                                        d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z"
                                                                                                        id="Combined-Shape">
                                                                                                    </path>
                                                                                                    <rect
                                                                                                        id="Rectangle-Copy-2"
                                                                                                        x="2.25" y="0.5"
                                                                                                        width="3"
                                                                                                        height="5"
                                                                                                        rx="0.5"></rect>
                                                                                                </g>
                                                                                            </g>
                                                                                            <g id="Group-3-Copy"
                                                                                                transform="matrix(-1 0 0 1 11 6)">
                                                                                                <g id="Group-2">
                                                                                                    <path
                                                                                                        d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z"
                                                                                                        id="Combined-Shape">
                                                                                                    </path>
                                                                                                    <rect
                                                                                                        id="Rectangle-Copy-2"
                                                                                                        x="2.25" y="0.5"
                                                                                                        width="3"
                                                                                                        height="5"
                                                                                                        rx="0.5"></rect>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </svg> Slider</a></li>
                                                                        <li><a href=""> <svg viewBox="0 0 14 14"
                                                                                    width="15" height="15"
                                                                                    focusable="false">
                                                                                    <g id="icon_annotate_2" fill="none"
                                                                                        fill-rule="evenodd">
                                                                                        <path
                                                                                            d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z"
                                                                                            id="Shape" fill="#ffb000"
                                                                                            fill-rule="nonzero"></path>
                                                                                    </g>
                                                                                </svg> Annotation</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <path
                                                                                        d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z"
                                                                                        fill="#00b6cb"
                                                                                        fill-rule="nonzero"></path>
                                                                                </svg> Signature</a></li>
                                                                        <li><a href=""> <svg width="15" height="15"
                                                                                    viewBox="0 0 14 14">
                                                                                    <g stroke="none" stroke-width="1"
                                                                                        fill="none" fill-rule="evenodd">
                                                                                        <path
                                                                                            d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z"
                                                                                            fill="#fe8500"
                                                                                            fill-rule="nonzero"></path>
                                                                                    </g>
                                                                                </svg> Location</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="title-page-box">

                                                                    <ul>
                                                                        <li class="active"><a href=""><svg width="15"
                                                                                    height="15" viewBox="0 0 14 14"
                                                                                    focusable="false">
                                                                                    <path
                                                                                        d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z"
                                                                                        fill="#648fff"
                                                                                        fill-rule="nonzero"></path>
                                                                                </svg> Instruction</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                        </div>
                    </td>
                    <td>
                        <button class="delete-question" data-id="${sectionId}"><i class="font-20 bx bxs-trash"></i></button>
                    </td>
                </tr>
            `);
        },
        error: function (xhr, status, error) {
            console.error('Error adding section:', error);
            console.error(xhr.responseText);
        }
    });
});


    // Delete question
$("#accordionFlushExample").on("click", ".delete-question", function () {
    
    let questionId = $(this).data("id"); // Get the question ID
    console.log('Delete button clicked with ID:', questionId); // Debugging log

    $.ajax({
        url: '{{ route('deletequestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: questionId
        },
        success: function (response) {
            $(`#squestion_${questionId}`).remove(); // Corrected the string interpolation
        },
        error: function (xhr, status, error) {
            console.error('Error deleting question:', error);
            console.error(xhr.responseText);
        }
    });
});
$("#accordionFlushExample22").on("click", ".delete-question", function () {
    
 
    let questionId = $(this).data("id"); // Get the question ID
    console.log('Delete button clicked with ID:', questionId); // Debugging log

    $.ajax({
        url: '{{ route('deletequestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: questionId
        },
        success: function (response) {
            $(`#squestion_${questionId}`).remove(); // Corrected the string interpolation
        },
        error: function (xhr, status, error) {
            console.error('Error deleting question:', error);
            console.error(xhr.responseText);
        }
    });
});

    // Delete section
    $("#accordionFlushExample").on("click", ".delete-section", function () {
        let sectionId = $(this).data("id"); // Get the section ID

        $.ajax({
            url: '{{ route('templates_addquestionsection') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: sectionId
            },
            success: function (response) {
                $(`#section_${sectionId}`).remove(); // Remove the section row from the table
            },
            error: function (xhr, status, error) {
                console.error('Error deleting section:', error);
                console.error(xhr.responseText);
            }
        });
    });

    // Delete page
    $("#accordionFlushExample").on("click", ".delete-page", function () {
        let pageId = $(this).data("id"); // Get the page ID

        $.ajax({
            url: '{{ route('templates_addquestionsection') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: pageId
            },
            success: function (response) {
                $(`#page_${pageId}`).remove(); // Remove the page from the accordion
            },
            error: function (xhr, status, error) {
                console.error('Error deleting page:', error);
                console.error(xhr.responseText);
            }
        });
    });

});

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>




</script>
<script>
    $(document).ready(function() {
        $('#templatename, #templatedesc').on('keyup', function() {
            var id = '{{ $template_id }}'; // Assuming you have the template ID available in your view
            var templatename = $('#templatename').text();
            var templatedesc = $('#templatedesc').text();

            $.ajax({
                url: '{{ route('templates_update_meta') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    templatename: templatename,
                    templatedesc: templatedesc,
                    type: '{{ Request::segment(4) ?? '' }}'
                },
                success: function(response) {
                    console.log('Template updated successfully.');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating template:', error);
                    console.error(xhr.responseText);
                }
            });
        });
    });
    
    
    
function updateQuestion(id,type) {
    var question = $('#updatequestion_' + id).text();
    var responsibilitys = $('select[name="responsibilitys"]').val();
    var cleaning_frequency = $('input[name="cleaning_frequency"]').val();
    var pm_frequency = $('select[name="pm_frequency"]').val();
    var id = id;
    $.ajax({
        url: '{{ route('templates_updatequestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            question: question,
            type: type,
            responsibilitys: responsibilitys,
            cleaning_frequency: cleaning_frequency,
            pm_frequency: pm_frequency,
        },
        success: function(response) {
            console.log('Template updated successfully.');
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
}


function updatetemplate(id,type) {

    var question = $('#updatequestion_' + id).text();
    var responsibilitys = $('select[name="responsibilitys"]').val();
    var cleaning_frequency = $('input[name="cleaning_frequency"]').val();
    var pm_frequency = $('select[name="pm_frequency"]').val();
    var id = id;
    $.ajax({
        url: '{{ route('templates_updatequestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            question: question,
            type: type,
            responsibilitys: responsibilitys,
            cleaning_frequency: cleaning_frequency,
            pm_frequency: pm_frequency,
        },
        success: function(response) {
            console.log('Template updated successfully.');
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
}


function updatepage(id) {
    var name = $('#templatepage_' + id).val();
    var id = id;
  

    $.ajax({
        url: '{{ route('templates_updatepage') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            name: name,
        },
        success: function(response) {
            console.log('Template updated successfully.');
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
}



    
function updateSection(id) {
    var question = $('#section_' + id).text();
    var sectionname = $('#sectionname_' + id).val();
    var id = id;
    $.ajax({
        url: '{{ route('templates_updatequestionsection') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            question: question,
            sectionname: sectionname,
        },
        success: function(response) {
            console.log('Template updated successfully.');
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
}
    


function showDiv(button) {
    // Hide all content-div elements
    const allDivs = document.querySelectorAll('.two-drop');
    allDivs.forEach(div => {
        if (div !== button.nextElementSibling) {
            div.style.display = 'none';  // Hide other divs
        }
    });

    // Toggle the visibility of the current div
    const currentDiv = button.nextElementSibling;
    currentDiv.style.display = currentDiv.style.display === 'flex' ? 'none' : 'flex';
}

// Close the dropdown if clicking anywhere outside of it
document.addEventListener('click', function(event) {
    const allDivs = document.querySelectorAll('.two-drop');
    const allButtons = document.querySelectorAll('[onclick="showDiv(this)"]');

    // Check if the click was outside of the dropdown and button
    if (!event.target.closest('.two-drop') && !event.target.closest('[onclick="showDiv(this)"]')) {
        allDivs.forEach(div => {
            div.style.display = 'none';  // Hide all dropdowns
        });
    }
});



function selectResponse(listItem, value,unique_id,questionID) {
    const td = listItem.closest('td'); // Get the closest <td>

    // Get the default box where we need to replace spans
    const defaultBox = td.querySelector('.defaultbox');

    // Clear existing spans
    defaultBox.innerHTML = '';

    // Get all span elements from the clicked list item
    const selectedSpans = listItem.querySelectorAll('.option-span');

    // Create a new div to hold the selected spans
    const newSpanContainer = document.createElement('div');
    newSpanContainer.className = 'fair-sec';

    // Append all selected spans into the new container
    selectedSpans.forEach(span => {
        const newSpan = document.createElement('span');
        newSpan.style.color = span.style.color;
        newSpan.style.background = span.style.background;
        newSpan.style.padding = "2px 7px";
        newSpan.style.borderRadius = "15px";
        newSpan.style.fontWeight = "400";
        newSpan.style.fontSize = "15px";
        newSpan.textContent = span.textContent;
        newSpanContainer.appendChild(newSpan);
    });

    // Append the new span container to the default box
    defaultBox.appendChild(newSpanContainer);

    // Remove 'active' class from all list items inside this <td>
    const allListItems = td.querySelectorAll('li');
    allListItems.forEach(item => item.classList.remove('active'));

    // Add 'active' class to the clicked list item
    listItem.classList.add('active');

    // Hide the dropdown after selection (if applicable)
    const dropdown = td.querySelector('.two-drop');
    if (dropdown) {
        dropdown.style.display = 'none';
    }
    
    
        $.ajax({
        url: '{{ route('templates_updatequestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: questionID,
            unique_id: unique_id,
        },
        success: function(response) {
            console.log('Template updated successfully.');
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
}

<?php
// Generate options in PHP first
$optionListHtml = '';
foreach ($multipleoptionList as $multipleoptionLists) {
    $list = Helper::multipleOptions($multipleoptionLists->unique_id);
    $optionListHtml .= "<li onclick=\"selectResponse(this, '{$multipleoptionLists->id}')\" 
                            data-response-class=\"{$multipleoptionLists->id}\">
                            <label>
                                <input type='radio' name='response' value='{$multipleoptionLists->id}'>
                                <div class='fair-sec'>";
    foreach ($list as $lists) {
        $color = $lists->color ?? '';
        $bgColor = $lists->bg_color ?? '';
        $optionListHtml .= "<span class='option-span' 
                            style='color: {$color}; background: {$bgColor}; padding: 2px 7px; 
                            border-radius: 15px; font-weight: 400; font-size: 15px;'>
                            {$lists->name}
                            </span>";
    }
    $optionListHtml .= "    </div>
                            </label>
                        </li>";
}
?>
$(document).on('click', '.add-question2', function(e) {
    
 
    e.preventDefault(); // Prevent default action if necessary
    $(".delete").fadeIn(1500);

    var id = '{{ $template_id }}'; // Use appropriate template ID
    $.ajax({
        url: '{{ route('templates_addquestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            var id = response.id;

            // Append new row to the "#items" table
     $("#items").append(
    '<tr id="question_' + id + '">' +
        '<td class="d-flex align-items-center" style="border:none;">' +
            '<div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu">' +
                '<div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" class="add-question2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE">' +
                    '<svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg">' +
                        '<path d="M0 0h24v24H0z" fill="none"></path>' +
                        '<path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path>' +
                    '</svg>' +
                    '<div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div>' +
                '</div>' +
                '<div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" class="add-section2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE">' +
                    '<svg width="21" height="21" viewBox="0 0 14 14" focusable="false">' +
                        '<g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero">' +
                            '<rect width="12" height="4.066" rx="0.733"></rect>' +
                            '<path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path>' +
                        '</g>' +
                    '</svg>' +
                    '<div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div>' +
                '</div>' +
            '</div>' +
            '<div class="darg-icon">' +
                '<svg viewBox="0 0 24 24" width="24" height="24" focusable="false">' +
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                    '<path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c1.1 0 2-.9 2 2s.9 2 2-2-.9-2-2-2z"></path>' +
                '</svg>' +
            '</div>' +
            '<span class="required-icon">*</span>' +
            '<div class="content-editable-block w-100 fr1" id="question_' + id + '" onkeyup="updateQuestion(' + id + ')" contenteditable="true" placeholder="Type Question" tabindex="0"></div>' +
        '</td>' +
        '<td>' +
            '<div class="defaultbox" style="float: left;">' +
                '<span class="info">Safe</span>' +
                '<span class="risk">At Risk</span>' +
                '<span class="na">N/A</span>' +
            '</div>' +
            '<button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">' +
                '<span class="arrow-icon1">' +
                    '<svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">' +
                        '<path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>' +
                    '</svg>' +
                '</span>' +
            '</button>' +
            '<div class="two-drop" style="display:none;">' +
                '<div class="drop-contant second-opn">' +
                    '<div class="left-form-top">' +
                        '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">' +
                        '<a class="btn btn-outline-success search-btn" type="submit">' +
                            '<svg viewBox="0 0 267 267" width="20" height="20" focusable="false">' +
                                '<defs>' +
                                    '<clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>' +
                                '</defs>' +
                                '<g clip-path="url(#a)">' +
                                    '<path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>' +
                                '</g>' +
                            '</svg>' +
                        '</a>' +
                    '</div>' +
                    '<div class="title-page-box">' +
                        '<div class="title-page-box-sidebar">' +
                            '<p>Multiple choice responses</p>' +
                        '</div>' +
        '<ul>' +
                                `<?php echo $optionListHtml; ?>` + // Inject pre-generated PHP content
                            '</ul>' +
                    '</div>' +
                '</div>' +
                 '<div class="drop-contant">'+
                            '<div class="title-page-box">'+
                        '<p>Site conducted</p>'+
                        '<ul>'+
                            '<li class="active"><a href=""> <svg data-anchor="sell-black-svg" viewBox="0 0 24 24" width="15" height="15" fill="#648fff" focusable="false"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z" fill="#648fff"></path></svg> Site</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false"><g fill="#fe8500" fill-rule="nonzero"><path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path></g></svg> Document number</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 24 24" color="#5e9cff" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z" fill="currentColor"></path></svg> Asset</a></li>'+
                        '</ul>'+
                    '</div>'+
                     '<div class="title-page-box">'+
            '<p>Other responses</p>'+
            '<ul>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<path d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z" fill="#fe8500" fill-rule="nonzero"></path>'+
                '</svg> Text answer</a></li>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<g fill="#ffb000" fill-rule="nonzero">'+
                        '<path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path>'+
                    '</g>'+
                '</svg> Number</a></li>'+
                '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" data-anchor="checked-checkbox-svg">'+
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>'+
                    '<path fill="#5e9cff" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z"></path>'+
                '</svg> checkbox</a></li>'+
            '</ul>'+
        '</div>'+
        '<div class="title-page-box">' +
        '<ul>' +
            '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false">' +
                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                '<path fill="#81b532" d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z"></path>' +
            '</svg> Date & Time</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 16 16" focusable="false" fill="none">' +
                '<path d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z" fill="#00b6cb"></path>' +
            '</svg> Media</a></li>' +
            '<li><a href=""> <svg viewBox="0 0 14 14" width="15" height="15" focusable="false">' +
                '<g id="icon_slider_v2" fill="none" fill-rule="evenodd">' +
                    '<g id="Group" transform="translate(1.5 1)" fill="#1ecf93">' +
                        '<g id="Group-3">' +
                            '<g id="Group-2">' +
                                '<path d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z" id="Combined-Shape"></path>' +
                                '<rect id="Rectangle-Copy-2" x="2.25" y="0.5" width="3" height="5" rx="0.5"></rect>' +
                            '</g>' +
                        '</g>' +
                    '</g>' +
                '</g>' +
            '</svg> Slider</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<g id="icon_annotate_2" fill="none" fill-rule="evenodd">' +
                    '<path d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z" id="Shape" fill="#ffb000" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Annotation</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z" fill="#00b6cb" fill-rule="nonzero"></path>' +
            '</svg> Signature</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14">' +
                '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                    '<path d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z" fill="#fe8500" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Location</a></li>' +
        '</ul>' +
    '</div>' +
    '<div class="title-page-box">' +
        '<ul>' +
            '<li class="active"><a href=""><svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z" fill="#648fff" fill-rule="nonzero"></path>' +
            '</svg> Instruction</a></li>' +
        '</ul>' +
    '</div>' +
                        '</div>' +
            '</div>' +
        '</td>' +
        '<td>' +
            '<button class="delete-question" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
        '</td>' +
    '</tr>'
);

$('td .fRTxQu').hide();



// Show only the specific tr with dynamic ID
$('#question_' + id + ' .fRTxQu').show();

        },
        error: function(xhr, status, error) {
            console.error('Error adding question:', error);
            console.error(xhr.responseText);
        }
    });
});




function addquestion(question_id) {
   
    
      
    $(".delete").fadeIn(1500);

    var id = '{{ $template_id }}'; // Use appropriate template ID
    $.ajax({
        url: '{{ route('templates_addquestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            var id = response.id;

            // Append new row to the "#items" table
    $(`#items_${question_id}`).append(
                 '<tr id="question_' + id + '">' +
                    '<td class="d-flex align-items-center" style="border:none;">' +
                        '<div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" onclick="addquestion(' + question_id + ')" class="add-question1 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical"  onclick="addsection(' + question_id + ')" class="add-section3 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">' +
                            '<svg viewBox="0 0 24 24" width="24" height="24" focusable="false">' +
                                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                                '<path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>' +
                            '</svg>' +
                        '</div>' +
                        '<span class="required-icon">*</span>' +
                        '<div class="content-editable-block w-100 fr1" id="question_' + id + '" onkeyup="updateQuestion(' + id + ')" contenteditable="true" placeholder="Type Question" tabindex="0"></div>' +
                    '</td>' +
                    '<td>' +
                        // Default options initially displayed
                        '<div class="defaultbox" style="float: left;">' +
                            '<span class="info">Safe</span>' +
                            '<span class="risk">At Risk</span>' +
                            '<span class="na">N/A</span>' +
                        '</div>' +

                        // Button to open dropdown
                        '<button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">' +
                            '<span class="arrow-icon1">' +
                                '<svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">' +
                                    '<path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>' +
                                '</svg>' +
                            '</span>' +
                        '</button>' +

                        // Dropdown list
                        '<div class="two-drop" style="display:none;">' +
                            '<div class="drop-contant second-opn">' +
                                '<div class="left-form-top">' +
                                    '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">' +
                                    '<a class="btn btn-outline-success search-btn" type="submit">' +
                                        '<svg viewBox="0 0 267 267" width="20" height="20" focusable="false">' +
                                            '<defs>' +
                                                '<clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>' +
                                            '</defs>' +
                                            '<g clip-path="url(#a)">' +
                                                '<path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>' +
                                            '</g>' +
                                        '</svg>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="title-page-box">' +
                                    '<div class="title-page-box-sidebar">' +
                                        '<p>Multiple choice responses</p>' +
                                    '</div>' +
               '<ul>' +
                                `<?php echo $optionListHtml; ?>` + // Inject pre-generated PHP content
                            '</ul>' +
                                '</div>' +
                            '</div>' +
                            '<div class="drop-contant">'+
                            '<div class="title-page-box">'+
                        '<p>Site conducted</p>'+
                        '<ul>'+
                            '<li class="active"><a href=""> <svg data-anchor="sell-black-svg" viewBox="0 0 24 24" width="15" height="15" fill="#648fff" focusable="false"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z" fill="#648fff"></path></svg> Site</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false"><g fill="#fe8500" fill-rule="nonzero"><path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path></g></svg> Document number</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 24 24" color="#5e9cff" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z" fill="currentColor"></path></svg> Asset</a></li>'+
                        '</ul>'+
                    '</div>'+
                     '<div class="title-page-box">'+
            '<p>Other responses</p>'+
            '<ul>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<path d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z" fill="#fe8500" fill-rule="nonzero"></path>'+
                '</svg> Text answer</a></li>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<g fill="#ffb000" fill-rule="nonzero">'+
                        '<path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path>'+
                    '</g>'+
                '</svg> Number</a></li>'+
                '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" data-anchor="checked-checkbox-svg">'+
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>'+
                    '<path fill="#5e9cff" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z"></path>'+
                '</svg> checkbox</a></li>'+
            '</ul>'+
        '</div>'+
        '<div class="title-page-box">' +
        '<ul>' +
            '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false">' +
                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                '<path fill="#81b532" d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z"></path>' +
            '</svg> Date & Time</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 16 16" focusable="false" fill="none">' +
                '<path d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z" fill="#00b6cb"></path>' +
            '</svg> Media</a></li>' +
            '<li><a href=""> <svg viewBox="0 0 14 14" width="15" height="15" focusable="false">' +
                '<g id="icon_slider_v2" fill="none" fill-rule="evenodd">' +
                    '<g id="Group" transform="translate(1.5 1)" fill="#1ecf93">' +
                        '<g id="Group-3">' +
                            '<g id="Group-2">' +
                                '<path d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z" id="Combined-Shape"></path>' +
                                '<rect id="Rectangle-Copy-2" x="2.25" y="0.5" width="3" height="5" rx="0.5"></rect>' +
                            '</g>' +
                        '</g>' +
                    '</g>' +
                '</g>' +
            '</svg> Slider</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<g id="icon_annotate_2" fill="none" fill-rule="evenodd">' +
                    '<path d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z" id="Shape" fill="#ffb000" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Annotation</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z" fill="#00b6cb" fill-rule="nonzero"></path>' +
            '</svg> Signature</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14">' +
                '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                    '<path d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z" fill="#fe8500" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Location</a></li>' +
        '</ul>' +
    '</div>' +
    '<div class="title-page-box">' +
        '<ul>' +
            '<li class="active"><a href=""><svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z" fill="#648fff" fill-rule="nonzero"></path>' +
            '</svg> Instruction</a></li>' +
        '</ul>' +
    '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-question" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>'
            );
            
            $('td .fRTxQu').hide();

// Show only the specific tr with dynamic ID
$('#question_' + id + ' .fRTxQu').show();

        },
        error: function(xhr, status, error) {
            console.error('Error adding question:', error);
            console.error(xhr.responseText);
        }
    });  
}

$(document).on('click', '.add-section2', function(e) {
    $(".delete").fadeIn("1500");
    
    var id = '{{ $template_id }}'; 
    $.ajax({
        url: '{{ route('templates_addquestionsection') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            var id = response.id;

            // Append a new row of code to the "#items" div
            $("#items").append(
                '<tr id="section_' + id + '" class="sectionbox">' +
                    '<td colspan="2">' +
                    
                        '<input class="content-editable-block w-100 fr1 adpage-inpt" id="sectionname_' + id + '" onkeyup="updateSection(' + id + ')" placeholder="Type Section Title">' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-section" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>' +
                 '<tr id="question_' + id + '">' +
                    '<td class="d-flex align-items-center" style="border:none;">' +
                    '<div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" class="add-question2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" class="add-section2 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">' +
                            '<svg viewBox="0 0 24 24" width="24" height="24" focusable="false">' +
                                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                                '<path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>' +
                            '</svg>' +
                        '</div>' +
                        '<span class="required-icon">*</span>' +
                        '<div class="content-editable-block w-100 fr1" id="question_' + id + '" onkeyup="updateQuestion(' + id + ')" contenteditable="true" placeholder="Type Question" tabindex="0"></div>' +
                    '</td>' +
                    '<td>' +
                        // Default options initially displayed
                        '<div class="defaultbox" style="float: left;">' +
                            '<span class="info">Safe</span>' +
                            '<span class="risk">At Risk</span>' +
                            '<span class="na">N/A</span>' +
                        '</div>' +

                        // Button to open dropdown
                        '<button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">' +
                            '<span class="arrow-icon1">' +
                                '<svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">' +
                                    '<path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>' +
                                '</svg>' +
                            '</span>' +
                        '</button>' +

                        // Dropdown list
                        '<div class="two-drop" style="display:none;">' +
                            '<div class="drop-contant second-opn">' +
                                '<div class="left-form-top">' +
                                    '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">' +
                                    '<a class="btn btn-outline-success search-btn" type="submit">' +
                                        '<svg viewBox="0 0 267 267" width="20" height="20" focusable="false">' +
                                            '<defs>' +
                                                '<clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>' +
                                            '</defs>' +
                                            '<g clip-path="url(#a)">' +
                                                '<path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>' +
                                            '</g>' +
                                        '</svg>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="title-page-box">' +
                                    '<div class="title-page-box-sidebar">' +
                                        '<p>Multiple choice responses</p>' +
                                    '</div>' +
                            '<ul>' +
                                `<?php echo $optionListHtml; ?>` + // Inject pre-generated PHP content
                            '</ul>' +
                                '</div>' +
                            '</div>' +
                            '<div class="drop-contant">'+
                            '<div class="title-page-box">'+
                        '<p>Site conducted</p>'+
                        '<ul>'+
                            '<li class="active"><a href=""> <svg data-anchor="sell-black-svg" viewBox="0 0 24 24" width="15" height="15" fill="#648fff" focusable="false"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z" fill="#648fff"></path></svg> Site</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false"><g fill="#fe8500" fill-rule="nonzero"><path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path></g></svg> Document number</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 24 24" color="#5e9cff" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z" fill="currentColor"></path></svg> Asset</a></li>'+
                        '</ul>'+
                    '</div>'+
                     '<div class="title-page-box">'+
            '<p>Other responses</p>'+
            '<ul>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<path d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z" fill="#fe8500" fill-rule="nonzero"></path>'+
                '</svg> Text answer</a></li>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<g fill="#ffb000" fill-rule="nonzero">'+
                        '<path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path>'+
                    '</g>'+
                '</svg> Number</a></li>'+
                '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" data-anchor="checked-checkbox-svg">'+
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>'+
                    '<path fill="#5e9cff" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z"></path>'+
                '</svg> checkbox</a></li>'+
            '</ul>'+
        '</div>'+
        '<div class="title-page-box">' +
        '<ul>' +
            '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false">' +
                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                '<path fill="#81b532" d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z"></path>' +
            '</svg> Date & Time</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 16 16" focusable="false" fill="none">' +
                '<path d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z" fill="#00b6cb"></path>' +
            '</svg> Media</a></li>' +
            '<li><a href=""> <svg viewBox="0 0 14 14" width="15" height="15" focusable="false">' +
                '<g id="icon_slider_v2" fill="none" fill-rule="evenodd">' +
                    '<g id="Group" transform="translate(1.5 1)" fill="#1ecf93">' +
                        '<g id="Group-3">' +
                            '<g id="Group-2">' +
                                '<path d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z" id="Combined-Shape"></path>' +
                                '<rect id="Rectangle-Copy-2" x="2.25" y="0.5" width="3" height="5" rx="0.5"></rect>' +
                            '</g>' +
                        '</g>' +
                    '</g>' +
                '</g>' +
            '</svg> Slider</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<g id="icon_annotate_2" fill="none" fill-rule="evenodd">' +
                    '<path d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z" id="Shape" fill="#ffb000" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Annotation</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z" fill="#00b6cb" fill-rule="nonzero"></path>' +
            '</svg> Signature</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14">' +
                '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                    '<path d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z" fill="#fe8500" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Location</a></li>' +
        '</ul>' +
    '</div>' +
    '<div class="title-page-box">' +
        '<ul>' +
            '<li class="active"><a href=""><svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z" fill="#648fff" fill-rule="nonzero"></path>' +
            '</svg> Instruction</a></li>' +
        '</ul>' +
    '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-question" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>'
            );
            $('td .fRTxQu').hide();

// Show only the specific tr with dynamic ID
$('#question_' + id + ' .fRTxQu').show();
        },
        error: function(xhr, status, error) {
            console.error('Error updating template:', error);
            console.error(xhr.responseText);
        }
    });
});

function addsection(question_id) {
    
   

    $(".delete").fadeIn(1500);

    var id = '{{ $template_id }}'; // Use appropriate template ID
    $.ajax({
        url: '{{ route('templates_addquestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            var id = response.id;

            // Append new row to the "#items" table
     $(`#items_${question_id}`).append(
                '<tr id="section_' + id + '" class="sectionbox">' +
                    '<td colspan="2">' +
                    
                        '<input class="content-editable-block w-100 fr1 adpage-inpt" id="sectionname_' + id + '" onkeyup="updateSection(' + id + ')" placeholder="Type Section Title">' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-section" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>' +
                 '<tr id="question_' + id + '">' +
                    '<td class="d-flex align-items-center" style="border:none;">' +
                    '<div class="plus-button-vertical-styled__Container-iauditor__sc-xf9h0w-0 fRTxQu"><div role="button" aria-label="Question" data-anchor="question-plus-button-vertical" onclick="addquestion(' + question_id + ')" class="add-question3 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg viewBox="0 0 24 24" width="21" height="21" focusable="false" data-anchor="plus-svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#17966c"></path></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Question</div></div><div role="button" aria-label="Section" data-anchor="section-plus-button-vertical" onclick="addsection(' + id + ')" class="add-section3 plus-button-vertical-styled__PlusButton-iauditor__sc-xf9h0w-1 iEscAE"><svg width="21" height="21" viewBox="0 0 14 14" focusable="false"><g transform="translate(1 1)" fill="#4740d4" fill-rule="nonzero"><rect width="12" height="4.066" rx="0.733"></rect><path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path></g></svg><div class="typography__Overline-iauditor__sc-rmkozr-9 haIhjz">Section</div></div></div><div class="darg-icon">' +
                            '<svg viewBox="0 0 24 24" width="24" height="24" focusable="false">' +
                                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                                '<path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>' +
                            '</svg>' +
                        '</div>' +
                        '<span class="required-icon">*</span>' +
                        '<div class="content-editable-block w-100 fr1" id="question_' + id + '" onkeyup="updateQuestion(' + id + ')" contenteditable="true" placeholder="Type Question" tabindex="0"></div>' +
                    '</td>' +
                    '<td>' +
                        // Default options initially displayed
                        '<div class="defaultbox" style="float: left;">' +
                            '<span class="info">Safe</span>' +
                            '<span class="risk">At Risk</span>' +
                            '<span class="na">N/A</span>' +
                        '</div>' +

                        // Button to open dropdown
                        '<button class="pop-arrow" onclick="showDiv(this)" type="button" style="float: left;">' +
                            '<span class="arrow-icon1">' +
                                '<svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">' +
                                    '<path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>' +
                                '</svg>' +
                            '</span>' +
                        '</button>' +

                        // Dropdown list
                        '<div class="two-drop" style="display:none;">' +
                            '<div class="drop-contant second-opn">' +
                                '<div class="left-form-top">' +
                                    '<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">' +
                                    '<a class="btn btn-outline-success search-btn" type="submit">' +
                                        '<svg viewBox="0 0 267 267" width="20" height="20" focusable="false">' +
                                            '<defs>' +
                                                '<clipPath id="a"><path d="M0 0h267v267H0z"></path></clipPath>' +
                                            '</defs>' +
                                            '<g clip-path="url(#a)">' +
                                                '<path fill="#1f2533" d="M172.438 155.75h-8.789l-3.115-3.004A71.993 71.993 0 0 0 178 105.688c0-39.938-32.375-72.313-72.312-72.313-39.938 0-72.313 32.375-72.313 72.313 0 39.937 32.375 72.312 72.312 72.312 17.912 0 34.377-6.564 47.059-17.466l3.004 3.115v8.789l55.625 55.513 16.576-16.576-55.513-55.625zm-66.75 0c-27.702 0-50.063-22.361-50.063-50.062 0-27.702 22.361-50.063 50.063-50.063 27.701 0 50.062 22.361 50.062 50.063 0 27.701-22.361 50.062-50.062 50.062z"></path>' +
                                            '</g>' +
                                        '</svg>' +
                                    '</a>' +
                                '</div>' +
                                '<div class="title-page-box">' +
                                    '<div class="title-page-box-sidebar">' +
                                        '<p>Multiple choice responses</p>' +
                                    '</div>' +
    '<ul>' +
                                `<?php echo $optionListHtml; ?>` + // Inject pre-generated PHP content
                            '</ul>' +
                                '</div>' +
                            '</div>' +
                            '<div class="drop-contant">'+
                            '<div class="title-page-box">'+
                        '<p>Site conducted</p>'+
                        '<ul>'+
                            '<li class="active"><a href=""> <svg data-anchor="sell-black-svg" viewBox="0 0 24 24" width="15" height="15" fill="#648fff" focusable="false"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M21.41 11.41l-8.83-8.83c-.37-.37-.88-.58-1.41-.58H4c-1.1 0-2 .9-2 2v7.17c0 .53.21 1.04.59 1.41l8.83 8.83c.78.78 2.05.78 2.83 0l7.17-7.17c.78-.78.78-2.04-.01-2.83zM6.5 8C5.67 8 5 7.33 5 6.5S5.67 5 6.5 5 8 5.67 8 6.5 7.33 8 6.5 8z" fill="#648fff"></path></svg> Site</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false"><g fill="#fe8500" fill-rule="nonzero"><path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path></g></svg> Document number</a></li>'+
                            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 24 24" color="#5e9cff" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.4033 1.18505C12.1375 1.13038 11.8633 1.13038 11.5975 1.18505C11.2902 1.24824 11.0156 1.40207 10.7972 1.52436L10.7377 1.55761L3.3377 5.66872L3.27456 5.7036C3.04343 5.8309 2.75281 5.99097 2.52963 6.23315C2.33668 6.44253 2.19066 6.69069 2.10134 6.96105C1.99802 7.27375 1.99923 7.60553 2.00019 7.8694L2.00037 7.94153V16.0586L2.00019 16.1308C1.99923 16.3946 1.99802 16.7264 2.10134 17.0391C2.19066 17.3095 2.33668 17.5576 2.52964 17.767C2.7528 18.0092 3.0434 18.1692 3.27452 18.2966L3.3377 18.3314L10.7377 22.4426L10.7972 22.4758C11.0155 22.5981 11.2902 22.7519 11.5975 22.8151C11.8633 22.8698 12.1375 22.8698 12.4033 22.8151C12.7106 22.7519 12.9852 22.5981 13.2035 22.4758L13.263 22.4426L20.663 18.3314L20.7262 18.2966C20.9573 18.1693 21.2479 18.0092 21.4711 17.767C21.6641 17.5576 21.8101 17.3095 21.8994 17.0391C22.0027 16.7264 22.0015 16.3946 22.0005 16.1308L22.0004 16.0586V7.94153L22.0005 7.8694C22.0015 7.60553 22.0027 7.27375 21.8994 6.96105C21.8101 6.69069 21.6641 6.44253 21.4711 6.23315C21.2479 5.99097 20.9573 5.8309 20.7262 5.7036L20.663 5.66872L13.263 1.55761L13.2035 1.52436C12.9852 1.40207 12.7105 1.24824 12.4033 1.18505ZM11.709 3.30592C11.8605 3.22173 11.9379 3.1792 11.9956 3.15136L12.0004 3.14907L12.0051 3.15136C12.0629 3.1792 12.1402 3.22173 12.2918 3.30592L18.9408 6.99986L12.0002 10.8558L5.05971 6.99997L11.709 3.30592ZM4.00037 8.69937V16.0586C4.00037 16.2416 4.00078 16.3353 4.00487 16.4031L4.00523 16.4088L4.01007 16.4119C4.06737 16.4484 4.14903 16.4943 4.30898 16.5831L11 20.3004V12.588L4.00037 8.69937ZM13 20.3008L19.6918 16.5831C19.8517 16.4943 19.9334 16.4484 19.9907 16.4119L19.9955 16.4088L19.9959 16.4031C20 16.3353 20.0004 16.2416 20.0004 16.0586V8.69916L13 12.5883V20.3008Z" fill="currentColor"></path></svg> Asset</a></li>'+
                        '</ul>'+
                    '</div>'+
                     '<div class="title-page-box">'+
            '<p>Other responses</p>'+
            '<ul>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<path d="M2.33333333,2.33333333 L2.33333333,4.97716191 L3.7929974,4.97716191 L3.7929974,4.28724799 C3.7929974,4.03503038 3.985625,3.82984264 4.22242188,3.82984264 L6.11229427,3.82984264 L6.11229427,9.52966171 C6.11229427,9.88941502 5.83754427,10.1820993 5.49979427,10.1820993 L4.8983776,10.1820993 L4.8983776,11.6666667 L9.11447396,11.6666667 L9.11447396,10.1820993 L8.51305729,10.1820993 C8.17534375,10.1820993 7.90055729,9.88941502 7.90055729,9.52966171 L7.90055729,3.82982322 L9.77757813,3.82982322 C10.0143568,3.82982322 10.2070026,4.03501096 10.2070026,4.28722858 L10.2070026,4.97714249 L11.6666667,4.97714249 L11.6666667,2.33333333 L2.33333333,2.33333333 Z" fill="#fe8500" fill-rule="nonzero"></path>'+
                '</svg> Text answer</a></li>'+
                '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">'+
                    '<g fill="#ffb000" fill-rule="nonzero">'+
                        '<path d="M2.21 9.682a.637.637 0 0 1-.637-.636V4.985l-.352.175a.636.636 0 1 1-.568-1.138l1.272-.636a.635.635 0 0 1 .921.57v5.09a.637.637 0 0 1-.636.636zM7.937 9.682H4.755a.637.637 0 0 1-.45-1.086l2.546-2.545a.85.85 0 0 0 .25-.605.849.849 0 0 0-.25-.604.874.874 0 0 0-1.21 0 .846.846 0 0 0-.25.604.637.637 0 0 1-1.272 0c0-.569.221-1.103.623-1.504.805-.804 2.205-.804 3.009 0 .402.402.623.937.623 1.504 0 .568-.222 1.103-.623 1.505L6.29 8.41h1.646a.637.637 0 0 1 0 1.272zM13 6.104c.214-.29.346-.646.346-1.035 0-.966-.785-1.75-1.75-1.75-.656 0-1.251.362-1.553.944a.636.636 0 1 0 1.13.586.477.477 0 1 1 .423.697.637.637 0 0 0 0 1.273.797.797 0 0 1 0 1.59.797.797 0 0 1-.795-.795.637.637 0 0 0-1.273 0 2.07 2.07 0 0 0 2.068 2.068 2.07 2.07 0 0 0 2.068-2.068c0-.597-.258-1.132-.665-1.51z"></path>'+
                    '</g>'+
                '</svg> Number</a></li>'+
                '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" data-anchor="checked-checkbox-svg">'+
                    '<path fill="none" d="M0 0h24v24H0V0z"></path>'+
                    '<path fill="#5e9cff" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.29 13.29a.996.996 0 0 1-1.41 0L5.71 12.7a.996.996 0 1 1 1.41-1.41L10 14.17l6.88-6.88a.996.996 0 1 1 1.41 1.41l-7.58 7.59z"></path>'+
                '</svg> checkbox</a></li>'+
            '</ul>'+
        '</div>'+
        '<div class="title-page-box">' +
        '<ul>' +
            '<li><a href=""> <svg viewBox="0 0 24 24" width="15" height="15" focusable="false">' +
                '<path fill="none" d="M0 0h24v24H0V0z"></path>' +
                '<path fill="#81b532" d="M20 3h-1V2c0-.55-.45-1-1-1s-1 .45-1 1v1H7V2c0-.55-.45-1-1-1s-1 .45-1 1v1H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 18H5c-.55 0-1-.45-1-1V8h16v12c0 .55-.45 1-1 1z"></path>' +
            '</svg> Date & Time</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 16 16" focusable="false" fill="none">' +
                '<path d="M16 11.2V1.6c0-.88-.72-1.6-1.6-1.6H4.8c-.88 0-1.6.72-1.6 1.6v9.6c0 .88.72 1.6 1.6 1.6h9.6c.88 0 1.6-.72 1.6-1.6zM7.52 8.424l1.304 1.744 2.064-2.576a.4.4 0 0 1 .624 0l2.368 2.96a.399.399 0 0 1-.312.648H5.6a.4.4 0 0 1-.32-.64l1.6-2.136a.406.406 0 0 1 .64 0zM0 4v10.4c0 .88.72 1.6 1.6 1.6H12c.44 0 .8-.36.8-.8 0-.44-.36-.8-.8-.8H2.4c-.44 0-.8-.36-.8-.8V4c0-.44-.36-.8-.8-.8-.44 0-.8.36-.8.8z" fill="#00b6cb"></path>' +
            '</svg> Media</a></li>' +
            '<li><a href=""> <svg viewBox="0 0 14 14" width="15" height="15" focusable="false">' +
                '<g id="icon_slider_v2" fill="none" fill-rule="evenodd">' +
                    '<g id="Group" transform="translate(1.5 1)" fill="#1ecf93">' +
                        '<g id="Group-3">' +
                            '<g id="Group-2">' +
                                '<path d="M1.75 2v2H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 2h1.25zm4 0h4.75a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H5.75V2z" id="Combined-Shape"></path>' +
                                '<rect id="Rectangle-Copy-2" x="2.25" y="0.5" width="3" height="5" rx="0.5"></rect>' +
                            '</g>' +
                        '</g>' +
                    '</g>' +
                '</g>' +
            '</svg> Slider</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<g id="icon_annotate_2" fill="none" fill-rule="evenodd">' +
                    '<path d="M1.524 11.854c.141.239.753 1.21 1.345 1.143.151-.017.324-.165.546-.424.268-.315 1.098-.73 2.353-.827 1.072-.082 1.973-.866 2.537-2.206.156-.37.285-.768.383-1.183l.066-.263 4.13-3.605a.316.316 0 0 0 .028-.465l-2.854-2.933a.298.298 0 0 0-.452.029L6.122 5.376c-.55-.05-1.119.027-1.69.23a5.627 5.627 0 0 0-2.195 1.45c-.662.713-1.077 1.552-1.203 2.426-.114.8.06 1.642.49 2.372zm3.368-5.2c-.002-.518.744-.656 1.172-.611.024.002.276.025.33.046L7.873 7.67c-.01.055-.06.245-.067.276a6.957 6.957 0 0 1-.333 1.073c-.3.74-.854 1.598-1.773 1.712-1.561.192-.8-1.501-.808-4.077z" id="Shape" fill="#ffb000" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Annotation</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M9.513 5.581l1.958.695-1.628 4.284c-.153.403-.98 1.663-1.555 1.92l-.14.368a.24.24 0 0 1-.306.138.229.229 0 0 1-.142-.297l.132-.348c-.292-.548-.074-2.14.054-2.476L9.513 5.58zm2.834-4.532c-.538-.19-1.169.203-1.35.679L9.819 4.832l1.958.694 1.178-3.104c.149-.389-.067-1.182-.607-1.373zM8.804 5.421a.478.478 0 0 0 .614-.272l1.245-3.243a.457.457 0 0 0-.282-.593.483.483 0 0 0-.615.272L8.522 4.828a.457.457 0 0 0 .282.593zM7.13 11.286c-.125-.117-.296-.5-.42-.35-.124.15-.035.094-.182.09h-.051c-.093-.251-.28-.41-.562-.471-.372-.078-.67.096-.875.23.018-.103.048-.225.07-.314.072-.284.145-.579.09-.855a.494.494 0 0 0-.452-.395c-.576-.032-1.047.276-1.461.554-.436.292-.715.466-.993.368-.34-.12-.374-1.031-.21-1.843.145-.731.417-2.093 1.113-2.71.234-.209.573-.434.852-.325.328.128.599.664.66 1.302.025.27.261.467.538.443a.491.491 0 0 0 .446-.535c-.098-1.04-.59-1.854-1.282-2.124-.415-.16-1.075-.203-1.875.507-.87.773-1.19 2.084-1.424 3.251-.116.583-.4 2.517.85 2.959.76.269 1.38-.147 1.876-.48.091-.06.181-.12.268-.174-.083.356-.134.737.083 1.058.322.482.779.534 1.356.157l.072-.047c.053.11.148.233.32.316.207.101.415.106.566.11.065.002.153.004.18.015.093.041-.228-.1-.121.001.08.075.165.153.272.234a.496.496 0 0 0 .692-.099.488.488 0 0 0-.1-.687c-.308-.19-.241-.134-.296-.186z" fill="#00b6cb" fill-rule="nonzero"></path>' +
            '</svg> Signature</a></li>' +
            '<li><a href=""> <svg width="15" height="15" viewBox="0 0 14 14">' +
                '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
                    '<path d="M7,2 C5.065,2 3.5,3.60760144 3.5,5.59527478 C3.5,7.73703133 5.71,10.6902928 6.62,11.8151002 C6.82,12.0616333 7.185,12.0616333 7.385,11.8151002 C8.29,10.6902928 10.5,7.73703133 10.5,5.59527478 C10.5,3.60760144 8.935,2 7,2 Z M7,6.87930149 C6.31,6.87930149 5.75,6.30405752 5.75,5.59527478 C5.75,4.88649204 6.31,4.31124807 7,4.31124807 C7.69,4.31124807 8.25,4.88649204 8.25,5.59527478 C8.25,6.30405752 7.69,6.87930149 7,6.87930149 Z" fill="#fe8500" fill-rule="nonzero"></path>' +
                '</g>' +
            '</svg> Location</a></li>' +
        '</ul>' +
    '</div>' +
    '<div class="title-page-box">' +
        '<ul>' +
            '<li class="active"><a href=""><svg width="15" height="15" viewBox="0 0 14 14" focusable="false">' +
                '<path d="M12.763 12.316c-.148-.086-1.049-.644-1.53-1.653a5.528 5.528 0 0 0 1.765-4.015c0-3.101-2.704-5.648-6-5.648C3.705 1 1 3.547 1 6.648c0 3.102 2.704 5.648 5.999 5.648.442 0 .917-.041 1.573-.179 1.723.916 3.269.89 3.857.88.262-.003.452.045.55-.226a.357.357 0 0 0-.216-.455zM7.702 9.484a.703.703 0 1 1-1.406 0V6.648a.703.703 0 1 1 1.406 0v2.836zm-.703-4.617a.703.703 0 1 1 0-1.406.703.703 0 0 1 0 1.406z" fill="#648fff" fill-rule="nonzero"></path>' +
            '</svg> Instruction</a></li>' +
        '</ul>' +
    '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td>' +
                        '<button class="delete-question" data-id="' + id + '"><i class="font-20 bx bxs-trash"></i></button>' +
                    '</td>' +
                '</tr>'
            );
            
            $('td .fRTxQu').hide();

// Show only the specific tr with dynamic ID
$('#question_' + id + ' .fRTxQu').show();

        },
        error: function(xhr, status, error) {
            console.error('Error adding question:', error);
            console.error(xhr.responseText);
        }
    });  
}
</script>

<script>
    let responseIndex = 1; // Keeps track of input indexes

    document.addEventListener("DOMContentLoaded", () => {
        const responseContainer = document.getElementById("responseContainer");
        const addResponseBtn = document.getElementById("addResponseBtn");

        // Add new response input
        addResponseBtn.addEventListener("click", () => {
            const responseItem = document.createElement("div");
            responseItem.classList.add("sidebar-box-input", "response-item");
            responseItem.innerHTML = `
                <div class="responce-input d-flex align-items-center">
                    <input type="text" name="responses[${responseIndex}][text]" class="form-control" placeholder="Response ${responseIndex + 1}">
                    <div class="color-picker-styled__Container ms-2" style="display: flex; width: 300px; padding: 8px;">
                        <div class="color-picker-styled__InputContainer">
                            <div
                                class="color-picker-styled__SelectedColorBox"
                                style="background-color: #648fff;"
                                onclick="toggleColorPicker(this)"
                            ></div>
                            <input
                                type="hidden"
                                name="responses[${responseIndex}][color]"
                                value="#648fff"
                            />
                        </div>
                        <div
                            class="color-picker-styled__ColorBoxesContainer"
                            style="display: none;"
                        >
                            <div class="color-picker-styled__ColorBox" style="background-color: #c60022;" data-color="#c60022"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #9c6d1e;" data-color="#9c6d1e"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #fe8500;" data-color="#fe8500"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #ffb000;" data-color="#ffb000"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #81b532;" data-color="#81b532"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #13855f;" data-color="#13855f"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #00b6cb;" data-color="#00b6cb"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #648fff;" data-color="#648fff"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #0044a3;" data-color="#0044a3"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #c22dd5;" data-color="#c22dd5"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #dc267f;" data-color="#dc267f"></div>
                            <div class="color-picker-styled__ColorBox" style="background-color: #707070;" data-color="#707070"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger ms-2 remove-response">Delete</button>
                </div>
            `;
            responseContainer.appendChild(responseItem);
            responseIndex++;
        });

        // Remove a response input
        responseContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("remove-response")) {
                e.target.closest(".response-item").remove();
            }
        });
    });

    // Toggle color picker visibility
    function toggleColorPicker(element) {
        const colorPickerContainer = element.closest(".color-picker-styled__Container");
        const colorBoxesContainer = colorPickerContainer.querySelector(".color-picker-styled__ColorBoxesContainer");
        colorBoxesContainer.style.display = colorBoxesContainer.style.display === "none" ? "block" : "none";

        // Add color selection logic
        colorBoxesContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("color-picker-styled__ColorBox")) {
                const selectedColor = e.target.getAttribute("data-color");
                colorPickerContainer.querySelector(".color-picker-styled__SelectedColorBox").style.backgroundColor = selectedColor;
                colorPickerContainer.querySelector("input[type='hidden']").value = selectedColor;
                colorBoxesContainer.style.display = "none"; // Hide picker after selection
            }
        });
    }
    
    
    
    // AJAX form submission
        const form = document.getElementById('multipleChoiceForm');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            fetch('{{ route("template_add_multiple_choice") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert('Responses saved successfully!');
                // Close the offcanvas
                const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('rightSlide'));
                offcanvas.hide();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving responses.');
            });
        });
        
document.addEventListener('DOMContentLoaded', function () {
    // Get the dropdown and toggle button
    const dropdown = document.querySelector('.two-drop');
    const toggleButton = document.querySelector('.your-toggle-button');

    // Show the dropdown when the toggle button is clicked
    if (toggleButton) {
        toggleButton.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent event from propagating to the document
            dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
        });
    }

    // Hide the dropdown if clicking outside
    document.addEventListener('click', function (event) {
        // Check if the click is outside the dropdown and the toggle button
        if (!dropdown.contains(event.target) && event.target !== toggleButton) {
            dropdown.style.display = 'none'; // Hide the dropdown
        }
    });
});
</script>


<script>
    $(document).ready(function(){
        $("input[name='pmradio']").change(function(){
            if ($(this).val() === "yes") {
                $(".pmsection").show();
            } else {
                $(".pmsection").hide();
            }
        });
    });  
    $(document).ready(function(){
        $("input[name='cleaningchecklist']").change(function(){
            if ($(this).val() === "yes") {
                $(".cleaningchecklist").show();
            } else {
                $(".cleaningchecklist").hide();
            }
        });
    });
</script>
   