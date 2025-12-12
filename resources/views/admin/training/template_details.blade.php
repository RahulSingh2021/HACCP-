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
        position: absolute;
        opacity: 0;
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
    </style>
@section('content')
 @include('admin.popups.templates.addtemplate')
<div class="row">
                    <div class="col">
                      <div class="card">
                                <div class="card-body">
                                    <div>
                                        
                                        @if($type)
                                        <h5 class="mb-3 " style="text-align: center;">{{$template_details->template_name ?? ''}} (@if($type==1) Cleaning Checklist @else PM Checklist @endif)</h5>
                                        @else
                                        <h5 class="mb-3 " style="text-align: center;">{{$template_details->template_name ?? ''}}</h5>
                                        @endif
                                        
                                        <p>{{$template_details->template_desc ?? ''}}</p>
                                        <hr>
                                    </div>
                                    <div class="row row-cols-auto g-3 mb-0 p-3" style="margin: 0 auto;
    display: block;">
                                        
                                            <div class="prewive-btn-click-show" >
        <div class="modal111">
            <div class="gdfg">
                <div class="modal-content">
    
                    <div class="modal-body">
                        <div class="container">
                            
                             @if($cleaningQuestions->isNotEmpty())
                             
                                             
                                                
                                                @php  $responbalityName = DB::table('authority')->where('id',$cleaningQuestions->first()->responsibilitys ?? '')->value('name'); @endphp
                                                   <h2 class="" >Cleaning Checklist <span style="float: right;color: #121010;">Responsibility: {{ $responbalityName ?? 'N/A' }}</span></h2>
                                                
                                            @endif
                                            
                            @php $i=1; @endphp
                            @foreach($cleaningQuestions as $questionlists)
                            @php  $questionoption = DB::table('template_question')->where('id',$questionlists->id)->first(); @endphp
                            <strong><p>{{$i}}.{{$questionlists->question ?? $questionlists->placeholder}}</p></strong>
                             @if(!empty($questionoption->option_id))  
                                                    @php $multipleoptionList1 = DB::table('multiple_choice_response')->where('unique_id',$questionoption->option_id)->get(); @endphp
                                                                <!-- Default options initially displayed -->
                                                    <div class="list-conducted togl-btn-prev">
                                                    <div class="inputbtn-btm-btn">
                                                    @foreach($multipleoptionList1 as $multipleoptionList1s)
                                                    <button class="btn-yes-point-1"
                                                    style="color: {{ $multipleoptionList1s->color ?? '' }}; background: {{ $multipleoptionList1s->bg_color ?? '' }}; padding: 2px 7px; border-radius: 15px; font-weight: 400; font-size: 15px;">
                                                    {{ $multipleoptionList1s->name ?? '' }}
                                                    </button>
                                                    
                                                    @endforeach
                                                    
                                                    </div>
                                                    </div>
                                                    @else
                                                                        <div class="list-conducted togl-btn-prev">
                                                                        <div class="inputbtn-btm-btn">
                                                                        <button class="btn-yes-point-1">Yes</button>
                                                                        <button class="btn-yes-point-2">No</button>
                                                                        <button class="btn-yes-point-3">N/A</button>
                                                                        </div>
                                                                        </div>
                                                    @endif
                                                    
                                                    
        
                                @php $i++; @endphp
                                @endforeach
                    
                    
                                                 @if($pmQuestions->isNotEmpty())
                                                <h2 class="">PM Checklist <span style="float: right;color: #121010;">Responsibility: Engineering</span></h2>
                                            @endif
                                            
                            @php $i=1; @endphp
                            @foreach($pmQuestions as $questionlists)
                            @php  $questionoption = DB::table('template_question')->where('id',$questionlists->id)->first(); @endphp
                            <strong><p>{{$i}}.{{$questionlists->question ?? $questionlists->placeholder}}</p></strong>
                             @if(!empty($questionoption->option_id))  
                                                    @php $multipleoptionList1 = DB::table('multiple_choice_response')->where('unique_id',$questionoption->option_id)->get(); @endphp
                                                                <!-- Default options initially displayed -->
                                                    <div class="list-conducted togl-btn-prev">
                                                    <div class="inputbtn-btm-btn">
                                                    @foreach($multipleoptionList1 as $multipleoptionList1s)
                                                    <button class="btn-yes-point-1"
                                                    style="color: {{ $multipleoptionList1s->color ?? '' }}; background: {{ $multipleoptionList1s->bg_color ?? '' }}; padding: 2px 7px; border-radius: 15px; font-weight: 400; font-size: 15px;">
                                                    {{ $multipleoptionList1s->name ?? '' }}
                                                    </button>
                                                    
                                                    @endforeach
                                                    
                                                    </div>
                                                    </div>
                                                    @else
                                                                        <div class="list-conducted togl-btn-prev">
                                                                        <div class="inputbtn-btm-btn">
                                                                        <button class="btn-yes-point-1">Yes</button>
                                                                        <button class="btn-yes-point-2">No</button>
                                                                        <button class="btn-yes-point-3">N/A</button>
                                                                        </div>
                                                                        </div>
                                                    @endif
                                                    
                                                    
        
                                @php $i++; @endphp
                                @endforeach

                            
                        </div>
                    </div>

        
                </div>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $(".delete").hide();
        //when the Add Field button is clicked
        $(".add").click(function(e) {
            $(".delete").fadeIn("1500");
            
             var id = '{{ $template_id }}'; 
                    $.ajax({
                url: '{{ route('templates_addquestion') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    var id =response.id;
            //Append a new row of code to the "#items" div
            $("#items").append(
            '<tr><td class="d-flex align-items-center" style="border:none;"> <div class="darg-icon"> <svg viewBox="0 0 24 24" width="24" height="24" focusable="false"> <path fill="none" d="M0 0h24v24H0V0z"></path> <path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path> </svg> </div> <span class="required-icon">*</span> <div class="content-editable-block w-100 fr1" id="question_' + id + '" onkeyup="updateQuestion(' + id + ')"  contenteditable="true" placeholder="Site conducted" tabindex="0"></div> </td><td> <span class="info">Safe</span><span class="risk">At Risk</span> <span class="na">N/A</span> <div class="dropdown" style="float: right;"> <button class="pop-arrow dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="arrow-icon1"> <svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false"> <path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path> </svg> </span> </button> <div class="dropdown-menu p-3" style="margin: 0px; width: 450px; overflow: auto; max-height:90vh; inset: auto auto 0px 0px !important; transform: translate(-570.857px, -28px) !important;" data-popper-placement="top-end"> <div class="row"> <div class="col-md-12"> <div class="position-relative search-bar-box w-100 ps-0 mb-3"> <input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y" style="left:10px;"><i class="bx bx-search"></i></span> <span class="position-absolute top-50 search-close translate-middle-y"><i class="bx bx-x"></i></span> </div> <div class="d-flex justify-content-between mb-3"> <span>Title page information</span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Text answer </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Number </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Checkbox </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Date & Time </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Media </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Location </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Document number </span> </div> <hr> <div class="d-flex justify-content-between mb-3"> <span>Multiple choice responses</span> <a role="button" class="text-primary">+ Responses</a> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Good</span> <span class="war">Fair</span> <span class="risk">Poor</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Compliant</span> <span class="risk">Non-Compliant</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Safe</span> <span class="risk">At Risk</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Pass</span> <span class="risk">Fail</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Yes</span> <span class="risk">No</span> <span class="na">N/A</span> </span> </div> </div> </div> </div> </div> </td></tr>'

            );
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
                    var id =response.id;
            //Append a new row of code to the "#items" div
            $("#items").append(
            '<tr class="sectionbox"><td><textarea id="sectionname_' + id + '" onkeyup="updateSection(' + id + ')"></textarea><td class="d-flex align-items-center" style="border:none;"> <div class="darg-icon"> <svg viewBox="0 0 24 24" width="24" height="24" focusable="false"> <path fill="none" d="M0 0h24v24H0V0z"></path> <path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path> </svg> </div> <span class="required-icon">*</span> <div class="content-editable-block w-100 fr1" id="section_' + id + '" onkeyup="updateSection(' + id + ')"  contenteditable="true" placeholder="Site conducted" tabindex="0"></div> </td><td> <span class="info">Safe</span><span class="risk">At Risk</span> <span class="na">N/A</span> <div class="dropdown" style="float: right;"> <button class="pop-arrow dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="arrow-icon1"> <svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false"> <path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path> </svg> </span> </button> <div class="dropdown-menu p-3" style="margin: 0px; width: 450px; overflow: auto; max-height:90vh; inset: auto auto 0px 0px !important; transform: translate(-570.857px, -28px) !important;" data-popper-placement="top-end"> <div class="row"> <div class="col-md-12"> <div class="position-relative search-bar-box w-100 ps-0 mb-3"> <input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y" style="left:10px;"><i class="bx bx-search"></i></span> <span class="position-absolute top-50 search-close translate-middle-y"><i class="bx bx-x"></i></span> </div> <div class="d-flex justify-content-between mb-3"> <span>Title page information</span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Text answer </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Number </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Checkbox </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Date & Time </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Media </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Location </span> </div> <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span> Document number </span> </div> <hr> <div class="d-flex justify-content-between mb-3"> <span>Multiple choice responses</span> <a role="button" class="text-primary">+ Responses</a> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Good</span> <span class="war">Fair</span> <span class="risk">Poor</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Compliant</span> <span class="risk">Non-Compliant</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Safe</span> <span class="risk">At Risk</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Pass</span> <span class="risk">Fail</span> <span class="na">N/A</span> </span> </div> <div class="d-flex justify-content-between mb-1"> <span style="line-height: 1.25rem;padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap;user-select: none;overflow: hidden;"> <span class="info">Yes</span> <span class="risk">No</span> <span class="na">N/A</span> </span> </div> </div> </div> </div> </div> </td></tr>'

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

    $(".addpage").click(function (e) {
        $(".delete").fadeIn(1500);
        id++; // Increment ID for each new item

        $.ajax({
            url: '{{ route('templates_addpage') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                var newId = response.id;

                // Append a new row of code to the "#accordionFlushExample" div
                $("#accordionFlushExample").append(`
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading${newId}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse${newId}" aria-controls="flush-collapse${newId}"></button>
                            <input type="text" id="templatepage_${newId}" onkeyup="updatepage(${newId})" value="">
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
                                                </tr>
                                            </thead>
                                            <tbody id="items">
                                                <tr>
                                                    <td class="d-flex align-items-center" style="border:none;">
                                                        <div class="darg-icon">
                                                            <svg viewBox="0 0 24 24" width="24" height="24" focusable="false">
                                                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                                <path fill="#333" d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                                            </svg>
                                                        </div>    
                                                        <span class="required-icon">*</span> 
                                                        <div class="content-editable-block w-100 fr1" onkey="questionsave()" contenteditable="true" placeholder="Site conducted" tabindex="0"></div>
                                                    </td>
                                                    <td>
                                                        <span class="info">Safe</span>
                                                        <span class="risk">At Risk</span>
                                                        <span class="na">N/A</span>
                                                        <div class="dropdown" style="float: right;">
                                                            <button class="pop-arrow dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span class="arrow-icon1">
                                                                    <svg viewBox="0 0 24 24" width="16" height="16" class="" focusable="false">
                                                                        <path d="M12.819 17.633l8.866-9.52a1.323 1.323 0 0 0-.028-1.745 1.113 1.113 0 0 0-1.625-.03l-7.663 8.228a.509.509 0 0 1-.755 0L3.968 6.354a1.113 1.113 0 0 0-1.625.03 1.323 1.323 0 0 0-.028 1.745l8.85 9.504c.22.235.517.368.827.367a1.12 1.12 0 0 0 .827-.367z" fill="#545f70" fill-rule="nonzero"></path>
                                                                    </svg>
                                                                </span>    
                                                            </button>
                                                            <div class="dropdown-menu p-3" style="margin: 0px; width: 450px; overflow: auto; max-height:90vh; inset: auto auto 0px 0px !important; transform: translate(-570.857px, -28px) !important;" data-popper-placement="top-end">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="position-relative search-bar-box w-100 ps-0 mb-3">
                                                                            <input type="text" class="form-control search-control" placeholder="Type to search..."> 
                                                                            <span class="position-absolute top-50 search-show translate-middle-y" style="left:10px;"><i class="bx bx-search"></i></span>
                                                                            <span class="position-absolute top-50 search-close translate-middle-y"><i class="bx bx-x"></i></span>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between mb-3">
                                                                            <span>Title page information</span>
                                                                        </div>
                                                                        @foreach($optionList as $optionLists)
                                                                            <div class="d-flex justify-content-between mb-1" style="line-height: 1.25rem; padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap; user-select: none; overflow: hidden;">
                                                                                <span>{{$optionLists->name ?? ''}}</span>
                                                                            </div>
                                                                        @endforeach
                                                                        <hr>
                                                                        <div class="d-flex justify-content-between mb-3">
                                                                            <span>Multiple choice responses</span>
                                                                            <a role="button" class="text-primary">+ Responses</a>
                                                                        </div>
                                                                        @foreach($multipleoptionList as $multipleoptionLists)
                                                                            @php $list = Helper::multipleOptions($multipleoptionLists->unique_id); @endphp
                                                                            <div class="d-flex justify-content-between mb-1">
                                                                                <span style="line-height: 1.25rem; padding: 0.6rem 0.875rem; min-height: 2rem; white-space: nowrap; user-select: none; overflow: hidden;">
                                                                                    @foreach($list as $lists)
                                                                                        <span class="{{$lists->color ?? ''}}">{{$lists->name ?? ''}}</span>
                                                                                    @endforeach
                                                                                </span>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-body position-relative">
                                        <svg class="p-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="View score column" viewBox="0 0 24 24" width="14" height="14" focusable="false" style="cursor: pointer;" aria-label="View score column">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#545f70"></path>
                                        </svg>
                                        <div class="mt-3">
                                            <button id="add" class="btn btn-primary me-2 add">
                                                <svg viewBox="0 0 24 24" width="16" height="16" focusable="false">
                                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" fill="#fff"></path>
                                                </svg> Add Question
                                            </button>
                                            <button class="btn btn-primary Addsection">
                                                <svg width="16" height="16" viewBox="0 0 14 14" focusable="false">
                                                    <g transform="translate(1 1)" fill="#fff" fill-rule="nonzero">
                                                        <rect width="12" height="4.066" rx="0.733"></rect>
                                                        <path d="M.8 5.947v5.164h10.4V5.947H.8zm0-.89h10.4c.442 0 .8.399.8.89v5.164c0 .491-.358.889-.8.889H.8c-.442 0-.8-.398-.8-.889V5.947c0-.491.358-.89.8-.89z"></path>
                                                    </g>
                                                </svg> Add section
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            },
            error: function(xhr, status, error) {
                console.error('Error updating template:', error);
                console.error(xhr.responseText);
            }
        });
    });
});

        $("body").on("click", ".delete", function(e) {
            $(".next-referral").last().remove();
        });
        
        
        
    });
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
                    templatedesc: templatedesc
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
    
    
    
function updateQuestion(id) {
    var question = $('#question_' + id).text();
    var id = id;
    

    $.ajax({
        url: '{{ route('templates_updatequestion') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            question: question,
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
    



</script>

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


   