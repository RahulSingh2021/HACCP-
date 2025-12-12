<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#sopForm').on('submit', function (e) {
            e.preventDefault();
            var formData = {
                _token: '{{ csrf_token() }}',
                program_entity_id: $('#programEntityId').val(),
                title: $('#programNameModal').val(),
                description: $('#programDescriptionModal').val(),
                keywords: $('#programKeywordsModal').val()
            };
            
            $.ajax({
                url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/topics/sops/save', 
                method: 'POST',
                data: formData,
                success: function (response) {
                    console.log('response',response);
                    toastr.success(response.message || 'SOP saved successfully!');
                    $('#sopForm')[0].reset();
                    closeModal('programModal');
                    sessionStorage.setItem('activateTab', '#topic');
                    window.location.reload();
                },
                error: function (xhr) {
                     console.log('xhr',xhr);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function (key, error) {
                            toastr.error(error);
                        });
                    } else {
                        toastr.error('An error occurred while saving the SOP.');
                    }
                }
            });
        });
    });
    
    
    $(document).ready(function () {
        $('.sop-edit-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var sopId = form.data('id');
            var formData = form.serialize();
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                success: function (response) {
                    toastr.success('SOP updated successfully!');
                    closeModalSopEdit('sop_' + sopId + 'ModalEdit');
                      sessionStorage.setItem('activateTab', '#topic');
                      window.location.reload();
                },
                error: function (xhr) {
                    toastr.error('Error updating SOP. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        });
    });

    function deleteSops(id) {
       if (!confirm('Are you sure you want to delete this sop?')) return;
       $.ajax({
           url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/topics/sops/delete',
           type: 'POST',
           data: {
               _token: '{{ csrf_token() }}',
               id: id
           },
           success: function (response) {
               toastr.success(response.message || 'Deleted successfully!');
                setTimeout(() => {
                sessionStorage.setItem('activateTab', '#topic');
                window.location.reload(); // 🔁 Reload the page
           }, 1000);
           },
           error: function (xhr) {
               toastr.error('Delete failed: ' + (xhr.responseJSON?.message || 'Server error'));
           }
       });
   }
   
    function deleteSubSops(id) {
       if (!confirm('Are you sure you want to delete this sub sop?')) return;
       $.ajax({
           url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/topics/sub-sops/delete',
           type: 'POST',
           data: {
               _token: '{{ csrf_token() }}',
               id: id
           },
           success: function (response) {
               toastr.success(response.message || 'Deleted successfully!');
                setTimeout(() => {
               sessionStorage.setItem('activateTab', '#topic');
                window.location.reload(); // 🔁 Reload the page
           }, 1000);
                // Optionally remove from DOM
                // $('#row_' + id).remove(); // if using row IDs
           },
           error: function (xhr) {
               toastr.error('Delete failed: ' + (xhr.responseJSON?.message || 'Server error'));
           }
       });
   }
   
   
$(document).ready(function () {
    $('#courseForm').off('submit').on('submit', function (e) {
        e.preventDefault();
        let formData = {
            _token: '{{ csrf_token() }}',
            id: $('#courseEntityId').val(),
            parent_id: $('#courseParentId').val(),
            title: $('#courseNameModal').val(),
            description: $('#courseDescriptionModal').val(),
            keywords: $('#courseKeywordsModal').val()
        };
        $.ajax({
            url: "{{ url('/training/topics/sub-sops/add') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                      toastr.success("Sub-SOP saved successfully!");
                    closeModal1('courseModal'); // Hide modal
                    $('#courseForm')[0].reset();
                      sessionStorage.setItem('activateTab', '#topic');
                      window.location.reload();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function (key, value) {
                        errorMsg += value[0] + '\n';
                    });
                    alert("Validation Error:\n" + errorMsg);
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        });
    });
});

function closeModal1(id) {
    $('#' + id).hide();
}



$(document).ready(function () {
    $('.subSopEditForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let id = form.data('id');
        let formData = form.serialize();

        $.ajax({
            url: "{{ url('/training/topics/sub-sops/update') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                     toastr.success("Sub-SOP updated successfully!");
                    $('#sub_sop_' + id + 'ModalEdit').hide();
                      sessionStorage.setItem('activateTab', '#topic');
                      window.location.reload();
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let msg = '';
                    $.each(errors, function (key, value) {
                        msg += value[0] + '\n';
                    });
                    alert("Validation Error:\n" + msg);
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        });
    });
});

function closeModalSubSopEdit(id) {
    $('#' + id).hide();
}

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

   
  
   
    function toggleSubSopStatusUpdate(button) {
    const el = $(button);
    
    const id = el.data('id');
    const type = el.data('type');
    const currentStatus = el.data('status');
    
    $.ajax({
        url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/topics/sub-sops/toggle-status',
        method: 'POST',
        data: {
            id: id,
            type: type,
            current_status: currentStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(response.success) {
                // Toggle UI
                const newStatus = response.new_status;
                el.data('status', newStatus);
                if (newStatus === 'active') {
                    el.find('span.btn-icon').text('🟢');
                    el.find('span:last').text('Active');
                } else {
                    el.find('span.btn-icon').text('🔴');
                    el.find('span:last').text('Inactive');
                }
            } else {
                alert('Failed to update status');
            }
        }
    });
}

   
   function toggleStatusUpdate(button) {
    const el = $(button);
    
    const id = el.data('id');
    const type = el.data('type');
    const currentStatus = el.data('status');
    
    $.ajax({
        url: 'https://efsm.safefoodmitra.com/admin/public/index.php/training/topics/sops/toggle-status',
        method: 'POST',
        data: {
            id: id,
            type: type,
            current_status: currentStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(response.success) {
                // Toggle UI
                const newStatus = response.new_status;
                el.data('status', newStatus);
                if (newStatus === 'active') {
                    el.find('span.btn-icon').text('🟢');
                    el.find('span:last').text('Active');
                } else {
                    el.find('span.btn-icon').text('🔴');
                    el.find('span:last').text('Inactive');
                }
            } else {
                alert('Failed to update status');
            }
        }
    });
}



// function openEditSubSopModalBasic(id, sop) {

//     openModalSubSopEdit(`sub_sop_${id}ModalEdit`);
// }

// function openModalSubSopEdit(modalId) {
//     const modal = document.getElementById(modalId);
//     if (modal) modal.style.display = 'block';
// }


function openEditSubSopModalBasic(id, sop, event) {
    openModalSubSopEdit(`sub_sop_${id}ModalEdit`, event);
}

function openModalSubSopEdit(modalId, event) {
    const modal = document.getElementById(modalId);
    if (!modal || !event) return;
    
    const button = event.currentTarget;
    const rect = button.getBoundingClientRect();

    const scrollTop = window.scrollY;
    const scrollLeft = window.scrollX;

    modal.style.visibility = 'hidden';
    modal.style.display = 'block';
    modal.style.left = '-9999px';
    modal.style.top = '-9999px';
    
    const modalWidth = modal.offsetWidth;
    const modalHeight = modal.offsetHeight;

    const left = window.innerWidth / 2 - modalWidth / 2;
    const top = rect.top + scrollTop - modalHeight - 15; 
    const finalLeft = Math.max(10, Math.min(left, window.innerWidth - modalWidth - 10));
    const finalTop = Math.max(10, top);
    modal.style.left = `${finalLeft}px`;
    modal.style.top = `${finalTop}px`;
    modal.style.visibility = 'visible';
}

function closeModalSubSopEdit(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'none';
}

// function openEditModalBasic(id, sop) {

//     openModalSopEdit(`sop_${id}ModalEdit`);
// }

function openEditModalBasic(id, event) {
    openModalSopEdit(`sop_${id}ModalEdit`, event);
}

function openModalSopEdit(modalId, event) {
    const modal = document.getElementById(modalId);
    if (!modal || !event) return;

    const button = event.currentTarget;
    const rect = button.getBoundingClientRect();

    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const scrollLeft = window.scrollX || document.documentElement.scrollLeft;

    // Temporarily display modal to measure size
    modal.style.visibility = 'hidden';
    modal.style.display = 'block';

    const modalWidth = modal.offsetWidth;
    const modalHeight = modal.offsetHeight;

    // ✅ Position: Center exactly in front of button
    // const left = rect.left + scrollLeft + rect.width / 2 - modalWidth / 2;
    
    // const top = rect.top + scrollTop + rect.height / 2 - modalHeight / 2;

    const left = window.innerWidth / 2 - modalWidth / 2;
    const top = rect.top + scrollTop - modalHeight - 15; 
    
    modal.style.left = `${Math.max(10, left)}px`;
    modal.style.top = `${Math.max(10, top)}px`;
    modal.style.visibility = 'visible';
}

function closeModalSopEdit(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'none';
}


    
</script>

<script>
// // function openAddCourse(sopId, sop) {
// //     // Reset form
// //     document.getElementById('courseForm').reset();

// //     // Fill the hidden SOP (parent) ID
// //     document.getElementById('courseParentId').value = sopId;

// //     // Optional: set dynamic modal title
// //     document.getElementById('courseModalTitle').innerText = `Add Sub-SOP for "${sop.name}"`;

// //     // Show the modal
// //     openModalAddCourse('courseModal');
// // }

// // function openModalAddCourse(modalId) {
// //     const modal = document.getElementById(modalId);
// //     if (modal) {
// //         modal.style.display = "block";
// //     }
// // }

// // function closeModalAddCourse(modalId) {
// //     const modal = document.getElementById(modalId);
// //     if (modal) {
// //         modal.style.display = "none";
// //     }
// // }

// function openAddCourse(sopId, sop) {
//     const modal = document.getElementById('courseModal');
//     document.getElementById('courseForm').reset();
//     document.getElementById('courseParentId').value = sopId;
//     document.getElementById('courseModalTitle').innerText = `Add Sub-SOP for "${sop.name}"`;

//     const button = event.target;

//     const rect = button.getBoundingClientRect();
//     const scrollTop = window.scrollY || document.documentElement.scrollTop;
//     const scrollLeft = window.scrollX || document.documentElement.scrollLeft;

//     const modalWidth = 400; // or modal.offsetWidth if modal already shown
//     const left = rect.left + scrollLeft + (rect.width / 2) - (modalWidth / 2);
//     const top = rect.top + scrollTop - 10; // 10px above button

//     // Apply inline style positioning
//     modal.style.left = Math.max(10, left) + 'px';
//     modal.style.top = top + 'px';
//     modal.style.display = 'block';
// }

// function closeModalAddCourse(modalId) {
//     const modal = document.getElementById(modalId);
//     if (modal) modal.style.display = 'none';
// }
// </script>

<script>

function openAddCourse(sopId, sop, event) {
    const modal = document.getElementById('courseModal');
    document.getElementById('courseForm').reset();
    document.getElementById('courseParentId').value = sopId;
    document.getElementById('courseModalTitle').innerText = `Add Sub-SOP for "${sop.name}"`;

    const button = event.currentTarget;
    const rect = button.getBoundingClientRect();

    const scrollTop = window.scrollY;
    const scrollLeft = window.scrollX;

    modal.style.visibility = 'hidden';
    modal.style.display = 'block';
    modal.style.left = '-9999px';
    modal.style.top = '-9999px';

    const modalWidth = modal.offsetWidth;
    const modalHeight = modal.offsetHeight;

    const left = window.innerWidth / 2 - modalWidth / 2;
    const top = rect.top + scrollTop - modalHeight - 15; 
    const finalLeft = Math.max(10, Math.min(left, window.innerWidth - modalWidth - 10));
    const finalTop = Math.max(10, top);
    modal.style.left = `${finalLeft}px`;
    modal.style.top = `${finalTop}px`;
    modal.style.visibility = 'visible';
}


function closeModalAddCourse(modalId) {
    document.getElementById(modalId).style.display = "none";
}
</script>



  <script>
  
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTabId = button.dataset.tab;
                    const targetTabContent = document.getElementById(targetTabId);

                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    button.classList.add('active');
                    targetTabContent.classList.add('active');
                });
            });
        });
    </script>
       <script>
        // --- CONSTANTS & GLOBALS ---
        // let currentEntityType = null, currentEntityId = null, currentParentId = null, currentParentName = '';
        // let filterProgramEl, filterCourseEl, filterKeywordEl, clearFiltersButtonEl; 
    
        // // // --- UTILITY FUNCTIONS ---
        // function generateId(prefix) { return `${prefix}_${Date.now()}_${Math.floor(Math.random() * 1000)}`; }
        // function getOriginalName(displayName) {
        //     if (displayName.startsWith('SOPs-(') && displayName.endsWith(')')) {
        //         return displayName.substring(6, displayName.length - 1);
        //     }
        //     if (displayName.startsWith('Sub-SOP-(') && displayName.endsWith(')')) {
        //         return displayName.substring(9, displayName.length - 1);
        //     }
        //     return displayName;
        // }

        // --- MODAL FUNCTIONS ---
        // function openModal(modalId) { document.getElementById(modalId).style.display = 'block'; }
        // function closeModal(modalId) { 
        //     const modalElement = document.getElementById(modalId); 
        //     if (!modalElement) return; 
        //     modalElement.style.display = 'none'; 
        //     if (modalId === 'programModal' || modalId === 'courseModal') { 
        //         const form = document.getElementById(modalId.replace('Modal', 'Form')); 
        //         if (form) form.reset(); 
        //         currentEntityType = currentEntityId = currentParentId = currentParentName = null; 
        //     } else if (modalId === 'uploadCoursesModal' || modalId === 'superAdminCsvUploadModal' || modalId === 'uploadKeywordsModal') {
        //         const formId = modalId.replace('Modal','Form');
        //         const statusId = modalId.replace('Modal','Status');
        //         document.getElementById(formId)?.reset(); 
        //         const statusEl = document.getElementById(statusId);
        //         if(statusEl) {
        //             statusEl.innerHTML = ''; 
        //             statusEl.style.backgroundColor = '#e9ecef'; 
        //             statusEl.style.color = 'var(--text-primary)'; 
        //         }
        //     }
        // }
        // function getDisplayValue(element, fieldName) { 
        //     const contentWrapper = element.querySelector('.entity-content-wrapper'); 
        //     if (!contentWrapper) return '';
        //     const el = contentWrapper.querySelector(`p[data-field="${fieldName}"]`);
        //     return el ? el.textContent.trim() : ''; 
        // }
        
        // --- INLINE KEYWORD & ALIAS MANAGEMENT ---
     
    
//         function toggleAddKeywordInput(element, show) {
//             const wrapper = element.closest('.add-keyword-wrapper');
//             const addButton = wrapper.querySelector('.add-keyword-btn');
//             const inputGroup = wrapper.querySelector('.add-keyword-input-group');
//             const inputField = wrapper.querySelector('.add-keyword-input');
    
//             if (show) {
//                 addButton.classList.add('hidden');
//                 inputGroup.classList.remove('hidden');
//                 inputField.value = '';
//                 inputField.focus();
//             } else {
//                 addButton.classList.remove('hidden');
//                 inputGroup.classList.add('hidden');
//                 inputField.value = '';
//             }
//         }
    
//         function handleKeywordInputKeydown(event, entityId) {
//             if (event.key === 'Enter') {
//                 event.preventDefault();
//                 saveNewInlineKeyword(event.target, entityId);
//             } else if (event.key === 'Escape') {
//                 event.preventDefault();
//                 toggleAddKeywordInput(event.target, false);
//             }
//         }
    
//         function saveNewInlineKeyword(element, entityId) {
//             const inputGroup = element.closest('.add-keyword-input-group');
//             const inputField = inputGroup.querySelector('.add-keyword-input');
//             const newKeyword = inputField.value.trim();
    
//             if (newKeyword === '') {
//                 inputField.focus();
//                 return;
//             }
    
//             const entityElement = document.getElementById(entityId);
//             if (!entityElement) return;
    
//             let existingKeywords = (entityElement.dataset.keywords || '').split(',').map(k => k.trim()).filter(Boolean);
//             if (!existingKeywords.includes(newKeyword)) {
//                 existingKeywords.push(newKeyword);
//                 entityElement.dataset.keywords = existingKeywords.join(', ');
//             }
            
//             renderInteractiveKeywords(entityElement);

//             const newAddButton = entityElement.querySelector('.add-keyword-btn');
//             if (newAddButton) {
//                 toggleAddKeywordInput(newAddButton, true);
//             }
//         }
    
//         function deleteInlineKeyword(entityId, keywordToDelete) {
//             const entityElement = document.getElementById(entityId);
//             if (!entityElement) return;
//             let keywords = (entityElement.dataset.keywords || '').split(',').map(k => k.trim()).filter(Boolean);
//             const updatedKeywords = keywords.filter(k => k !== keywordToDelete);
//             entityElement.dataset.keywords = updatedKeywords.join(', ');
//             renderInteractiveKeywords(entityElement);
//         }
    
//         // --- CORE CRUD & DISPLAY FUNCTIONS ---
//         function openAddModal(entityType, parentId, parentName) {
//             currentEntityType = entityType; currentParentId = parentId; currentParentName = parentName; currentEntityId = null;
//             let modalId, modalTitleElId, formId, titlePrefix = "Add New";
//             if (entityType === 'program') { 
//                 modalId = 'programModal'; modalTitleElId = 'programModalTitle'; formId = 'programForm';
//                 document.getElementById('programEntityId').value = '';
//                 document.getElementById(modalTitleElId).textContent = `${titlePrefix} SOPs`;
//             } else if (entityType === 'course') { 
//                 modalId = 'courseModal'; modalTitleElId = 'courseModalTitle'; formId = 'courseForm';
//                 document.getElementById('courseParentId').value = parentId;
//                 document.getElementById(modalTitleElId).textContent = `${titlePrefix} Sub-SOP under "SOPs-(${parentName})"`;
//             }
//             if (modalId) {
//                 const formElement = document.getElementById(formId);
//                 if (formElement) formElement.reset();
//                 openModal(modalId);
//             }
//         }
    
//         function openEditModal(entityType, entityId) {
//             currentEntityType = entityType; currentEntityId = entityId; currentParentId = null;
//             const entityEl = document.getElementById(entityId);
//             if (!entityEl) { console.error("Entity not found:", entityId); return; }
//             let modalId, modalTitleElId, titlePrefix = "Edit";
//             const entityNameDisplay = entityEl.querySelector('.entity-name-display').textContent;
//             const originalName = getOriginalName(entityNameDisplay);
//             const keywords = entityEl.dataset.keywords || '';
    
//             if (entityType === 'program') {
//                 modalId = 'programModal'; modalTitleElId = 'programModalTitle';
//                 document.getElementById('programEntityId').value = entityId;
//                 document.getElementById('programNameModal').value = originalName;
//                 document.getElementById('programDescriptionModal').value = getDisplayValue(entityEl, 'description');
//                 document.getElementById('programKeywordsModal').value = keywords;
//                 document.getElementById(modalTitleElId).textContent = `${titlePrefix} SOPs`;
//             } else if (entityType === 'course') {
//                 modalId = 'courseModal'; modalTitleElId = 'courseModalTitle';
//                 document.getElementById('courseEntityId').value = entityId;
//                 document.getElementById('courseNameModal').value = originalName;
//                 document.getElementById('courseDescriptionModal').value = getDisplayValue(entityEl, 'description');
//                 document.getElementById('courseKeywordsModal').value = keywords;
//                 document.getElementById(modalTitleElId).textContent = `${titlePrefix} Sub-SOP`;
//             }
//             if (modalId) openModal(modalId);
//         }
    
//         function updateDisplay(element, fieldName, newValue) { 
//             const contentWrapper = element.querySelector('.entity-content-wrapper');
//             if (!contentWrapper) return;
//             const descEl = contentWrapper.querySelector(`p[data-field="${fieldName}"]`);
//             if (descEl) {
//                 descEl.textContent = newValue || 'No description provided.'; 
//             }
//         }
    

//         function deleteProgramOrCourse(entityType, entityId) {
//             const entityElement = document.getElementById(entityId);
//             if (!entityElement) return;
//             const entityName = entityElement.querySelector('.entity-name-display').textContent;
//             let message = `Are you sure you want to delete the ${entityType === 'program' ? 'SOPs' : 'Sub-SOP'} "${entityName}"?`;
//             if (entityType === 'program') {
//                 message += " This will also delete all its Sub-SOPs.";
//             }
//             if (confirm(message)) {
//                 const parentProgramElement = entityElement.closest('.training-program');
//                 if (entityType === 'program') {
//                     const courses = entityElement.querySelectorAll('.course-item');
//                     courses.forEach(course => course.remove());
//                 }
//                 entityElement.remove();
                
//                 if (parentProgramElement && entityType === 'course' && parentProgramElement.id !== entityId) {
//                     updateProgramEntityCounts(parentProgramElement);
//                 }
//                 populateProgramFilter();
//                 populateCourseFilter();
//                 applyAllFilters();
//                 updateSuperAdminDashboardStats();
//             }
//         }
        
//         function toggleActivation(entityId, entityType, buttonElement) { const entityElement = document.getElementById(entityId); if (!entityElement) return; const currentStatus = entityElement.dataset.status; const newStatus = currentStatus === 'active' ? 'inactive' : 'active'; entityElement.dataset.status = newStatus; buttonElement.classList.toggle('active-state', newStatus === 'active'); buttonElement.classList.toggle('inactive-state', newStatus === 'inactive'); buttonElement.innerHTML = `<span class="btn-icon">${newStatus === 'active' ? '🟢' : '🔴'}</span><span>${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</span>`; applyAllFilters(); updateAllCountsAndDisplays(); }
        
//         function setSpanText(spanId, label, count) { 
//             const spanElement = document.getElementById(spanId); 
//             if (spanElement) { 
//                 const strongElement = spanElement.querySelector('strong');
//                 const labelElement = spanElement.querySelector('.count-label');
//                 if(strongElement) {
//                     strongElement.textContent = count;
//                 } else if (labelElement) {
//                     spanElement.innerHTML = `<span class="count-label">${label} </span>${count}`; 
//                 } else {
//                     spanElement.innerHTML = `<span class="count-label">${label} </span><strong>${count}</strong>`; 
//                 }
//             }
//         }
        
//         function updateCourseEntityCounts(courseElement) { 
//             if (!courseElement) return; 
//         }
    
//         function updateProgramEntityCounts(progElement) { 
//             if (!progElement) return; 
//             const progId = progElement.id; 
//             const courses = progElement.querySelectorAll('.course-container .entity-level.course-item:not(.hidden-by-filter)'); 
//             setSpanText(`${progId}-course-count`, 'Sub-SOPs: ', courses.length); 
//         }
    
//         function updateSuperAdminDashboardStats() {
//             const allPrograms = document.querySelectorAll('.training-program'); 
//             const allCourses = document.querySelectorAll('.course-item'); 
//             document.getElementById('dashStatTotalPrograms').textContent = allPrograms.length;
//             document.getElementById('dashStatTotalCourses').textContent = allCourses.length;
//         }
    
//         function updateAllCountsAndDisplays() { 
//             document.querySelectorAll('.training-program:not(.hidden-by-filter)').forEach(updateProgramEntityCounts);
//             document.querySelectorAll('.course-item:not(.hidden-by-filter)').forEach(updateCourseEntityCounts); 
//             updateSuperAdminDashboardStats();
//         }
    
//         // --- FILTER FUNCTIONS ---
//         function populateProgramFilter() { 
//             const filterEl = document.getElementById('filterProgram');
//             if (!filterEl) return;
//             const currentValue = filterEl.value;
//             filterEl.innerHTML = '<option value="all">All SOPs</option>';
//             document.querySelectorAll('.training-program').forEach(prog => { 
//                 const name = prog.querySelector('.entity-name-display').textContent;
//                 filterEl.innerHTML += `<option value="${prog.id}">${name}</option>`;
//             });
//             filterEl.value = currentValue; 
//         }
    
//         function populateCourseFilter() { 
//             const filterEl = document.getElementById('filterCourse');
//             if (!filterEl) return;
//             const currentValue = filterEl.value;
//             filterEl.innerHTML = '<option value="all">All Sub-SOPs</option>';
//             const selectedProgramId = document.getElementById('filterProgram').value;
    
//             document.querySelectorAll('.course-item').forEach(course => { 
//                 const parentProgram = course.closest('.training-program');
//                 if (selectedProgramId === 'all' || (parentProgram && parentProgram.id === selectedProgramId)) {
//                     const name = course.querySelector('.entity-name-display').textContent;
//                     const progName = parentProgram?.querySelector('.entity-name-display').textContent || 'Unknown SOPs';
//                     filterEl.innerHTML += `<option value="${course.id}">${name} (${progName})</option>`;
//                 }
//             });
//              filterEl.value = currentValue; 
//         }
    
//         function applyAllFilters() {
//             const progFilterValue = document.getElementById('filterProgram').value;
//             const courseFilterValue = document.getElementById('filterCourse').value;
//             const keywordFilterValue = document.getElementById('filterKeyword').value.toLowerCase().trim();
    
//             document.querySelectorAll('.training-program, .course-item').forEach(el => el.classList.remove('hidden-by-filter'));
    
//             document.querySelectorAll('.training-program').forEach(prog => {
//                 const name = prog.querySelector('.entity-name-display').textContent.toLowerCase();
//                 const description = getDisplayValue(prog, 'description').toLowerCase();
//                 const userKeywords = (prog.dataset.keywords || '').toLowerCase();
                
//                 const programMatchesKeyword = keywordFilterValue === '' || `${name} ${description} ${userKeywords}`.includes(keywordFilterValue);
//                 const programMatchesDropdown = progFilterValue === 'all' || prog.id === progFilterValue;
    
//                 let hasVisibleCourse = false;
    
//                 prog.querySelectorAll('.course-item').forEach(course => {
//                     const cName = course.querySelector('.entity-name-display').textContent.toLowerCase();
//                     const cDescription = getDisplayValue(course, 'description').toLowerCase();
//                     const cUserKeywords = (course.dataset.keywords || '').toLowerCase();

//                     const courseMatchesKeyword = keywordFilterValue === '' || `${cName} ${cDescription} ${cUserKeywords}`.includes(keywordFilterValue);
//                     const courseMatchesDropdown = courseFilterValue === 'all' || course.id === courseFilterValue;
                    
//                     const courseIsVisible = courseMatchesDropdown && courseMatchesKeyword;
                    
//                     if (!courseIsVisible) {
//                         course.classList.add('hidden-by-filter');
//                     }
//                     if (courseIsVisible && programMatchesDropdown) {
//                         hasVisibleCourse = true;
//                     }
//                 });
//                 const programIsVisible = programMatchesDropdown && (programMatchesKeyword || hasVisibleCourse);
                
//                 if(!programIsVisible) {
//                     prog.classList.add('hidden-by-filter');
//                 }
//             });
    
//             populateCourseFilter();
//             updateAllCountsAndDisplays();
//         }
    
//         function clearAllFilters() {
//             document.getElementById('filterProgram').value = 'all';
//             document.getElementById('filterCourse').value = 'all';
//             document.getElementById('filterKeyword').value = '';
//             applyAllFilters();
//         }
    
//         // --- CSV HANDLING FUNCTIONS ---
//         function downloadFullSampleCsv() {
//             const csvContent = `Level,ParentName,Name,Description,Keywords
// SOPs,,Foundational Skills Program,"Core training for all new employees","onboarding, core, compliance"
// Sub-SOP,Foundational Skills Program,Intro to Company Policies,"Overview of key company policies","hr, policy, procedures"
// SOPs,,Advanced Leadership Development,"For senior managers and team leads","leadership, management, advanced"
// Sub-SOP,Advanced Leadership Development,Strategic Thinking Workshop,"Develop strategic planning skills","strategy, planning, executive"`;
//             const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
//             const url = URL.createObjectURL(blob);
//             const link = document.createElement('a');
//             link.setAttribute('href', url);
//             link.setAttribute('download', 'full_sops_sample.csv');
//             link.style.visibility = 'hidden';
//             document.body.appendChild(link);
//             link.click();
//             document.body.removeChild(link);
//         }
    
//         function downloadCourseSampleCsv(progId, progName) { 
//             const csvContent = `Level,ParentName,Name,Description,Keywords
// Sub-SOP,${progName},New Sub-SOP Title,"Sub-SOP description details","keyword1, keyword2"`;
//             const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
//             const url = URL.createObjectURL(blob);
//             const link = document.createElement('a');
//             link.setAttribute('href', url);
//             link.setAttribute('download', `sub-sops_sample_for_${progName.replace(/[^a-z0-9]/gi, '_')}.csv`);
//             link.style.visibility = 'hidden';
//             document.body.appendChild(link);
//             link.click();
//             document.body.removeChild(link);
//         }
    
//         function downloadKeywordSampleCsv(entityId, entityName) {
//             const csvContent = `Keywords\nkeyword1\nsample-keyword\nanother-one`;
//             const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
//             const url = URL.createObjectURL(blob);
//             const link = document.createElement('a');
//             link.setAttribute('href', url);
//             link.setAttribute('download', `keywords_sample_for_${entityName.replace(/[^a-z0-9]/gi, '_')}.csv`);
//             link.style.visibility = 'hidden';
//             document.body.appendChild(link);
//             link.click();
//             document.body.removeChild(link);
//         }

//         function openUploadKeywordsCsvModal(entityId, entityName) {
//             document.getElementById('uploadKeywordsForm').reset(); 
//             document.getElementById('uploadKeywordsStatus').innerHTML = ''; 
//             document.getElementById('uploadKeywordsEntityId').value = entityId; 
//             document.getElementById('uploadKeywordsEntityName').value = entityName; 
//             document.getElementById('uploadKeywordsTargetEntityName').textContent = entityName; 
//             openModal('uploadKeywordsModal'); 
//         }

//         function handleUploadKeywordsCsv() {
//             const fileInput = document.getElementById('uploadKeywordsFileCsv');
//             const statusEl = document.getElementById('uploadKeywordsStatus');
//             const entityId = document.getElementById('uploadKeywordsEntityId').value;
//             const entityElement = document.getElementById(entityId);

//             if (!fileInput.files.length) {
//                 statusEl.textContent = 'Please select a CSV file first.';
//                 statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828';
//                 return;
//             }
//             if (!entityElement) {
//                 statusEl.textContent = 'Target entity not found. Please close and try again.';
//                 statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828';
//                 return;
//             }

//             const file = fileInput.files[0];
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 try {
//                     const csvData = e.target.result;
//                     const lines = csvData.split(/\r?\n/).filter(line => line.trim() !== '');
//                     if (lines.length <= 1) { // Header only or empty
//                         throw new Error('CSV is empty or contains only a header.');
//                     }
                    
//                     const newKeywords = lines.slice(1).map(line => line.split(',')[0].trim()).filter(Boolean);
                    
//                     if(newKeywords.length === 0) {
//                         throw new Error('No valid keywords found in the CSV file.');
//                     }

//                     const existingKeywords = new Set((entityElement.dataset.keywords || '').split(',').map(k => k.trim()).filter(Boolean));
//                     newKeywords.forEach(k => existingKeywords.add(k));

//                     entityElement.dataset.keywords = Array.from(existingKeywords).join(', ');
//                     renderInteractiveKeywords(entityElement); 

//                     statusEl.innerHTML = `Successfully added/merged ${newKeywords.length} keywords.`;
//                     statusEl.style.backgroundColor = '#e8f5e9'; statusEl.style.color = '#2e7d32';

//                     setTimeout(() => closeModal('uploadKeywordsModal'), 2000);
//                 } catch (error) {
//                     console.error('Error processing Keywords CSV:', error);
//                     statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
//                     statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828';
//                 }
//             };
//             reader.readAsText(file);
//         }

//         function openSuperAdminCsvUploadModal() {
//             document.getElementById('superAdminCsvUploadForm').reset();
//             document.getElementById('superAdminCsvUploadStatus').innerHTML = '';
//             openModal('superAdminCsvUploadModal');
//         }
    
//         function openUploadCoursesCsvModal(progId, progName) { 
//             document.getElementById('uploadCoursesForm').reset(); 
//             document.getElementById('uploadCoursesStatus').innerHTML = ''; 
//             // document.getElementById('uploadCoursesProgramId').value = progId; 
//             document.getElementById('uploadCoursesProgramName').value = progName; 
//             document.getElementById('uploadCoursesTargetProgramName').textContent = `SOPs-(${progName})`; 
//             document.getElementById('uploadCoursesTargetProgramNameMirror').textContent = `SOPs-(${progName})`; 
//             openModal('uploadCoursesModal'); 
//         }
        
//         function handleSuperAdminCsvUpload() {
//             const fileInput = document.getElementById('superAdminFileCsv');
//             const statusEl = document.getElementById('superAdminCsvUploadStatus');
//             if (!fileInput.files.length) {
//                 statusEl.textContent = 'Please select a CSV file first.';
//                 statusEl.style.backgroundColor = '#ffebee';
//                 statusEl.style.color = '#c62828';
//                 return;
//             }
    
//             const file = fileInput.files[0];
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 try {
//                     const csvData = e.target.result;
//                     const lines = csvData.split('\n').filter(line => line.trim() !== ''); 
//                     const headers = lines[0].split(',').map(h => h.trim().toLowerCase()); 
                    
//                     const requiredHeaders = ['level', 'name'];
//                     if (!requiredHeaders.every(rh => headers.includes(rh))) {
//                         statusEl.innerHTML = 'Error: CSV must contain "Level" and "Name" columns.';
//                         statusEl.style.backgroundColor = '#ffebee';
//                         statusEl.style.color = '#c62828';
//                         return;
//                     }
    
//                     const programEntities = []; 
//                     const courseEntities = []; 
    
//                     for (let i = 1; i < lines.length; i++) {
//                         const values = lines[i].split(',');
//                         const entity = {};
//                         headers.forEach((header, index) => {
//                             entity[header] = values[index] ? values[index].trim() : '';
//                         });
                        
//                         if (entity.level.toLowerCase() === 'sops') { 
//                             programEntities.push(entity);
//                         } else if (entity.level.toLowerCase() === 'sub-sop') { 
//                             courseEntities.push(entity);
//                         }
//                     }
    
//                     programEntities.forEach(processProgramFromCsv); 
//                     courseEntities.forEach(processCourseFromCsv); 
    
//                     statusEl.innerHTML = 'Successfully processed CSV file!<br>' +
//                         `SOPs: ${programEntities.length}<br>` +
//                         `Sub-SOPs: ${courseEntities.length}`;
//                     statusEl.style.backgroundColor = '#e8f5e9';
//                     statusEl.style.color = '#2e7d32';
    
//                 } catch (error) {
//                     console.error('Error processing CSV:', error);
//                     statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
//                     statusEl.style.backgroundColor = '#ffebee';
//                     statusEl.style.color = '#c62828';
//                 } finally {
//                     populateProgramFilter();
//                     populateCourseFilter();
//                     updateAllCountsAndDisplays();
//                     applyAllFilters(); 
//                     setTimeout(() => closeModal('superAdminCsvUploadModal'), 2000);
//                 }
//             };
//             reader.readAsText(file);
//         }
    
//         function processProgramFromCsv(csvRow) { 
//             const name = csvRow.name;
//             const description = csvRow.description || 'No description provided.';
//             const keywords = csvRow.keywords || '';
//             const displayName = `SOPs-(${name})`;
            
//             const existingProgElement = Array.from(document.querySelectorAll('.training-program .entity-name-display'))
//                                       .find(el => el.textContent.trim() === displayName.trim());
//             if (existingProgElement) {
//                 console.log(`SOPs "${name}" already exists. Skipping creation.`);
//                 return existingProgElement.closest('.training-program').id;
//             }
    
//             const progId = generateId('prog'); 
//             const nameEscaped = name.replace(/'/g, "\\'");
//             // const progHTML = `
//             //     <details class="entity-level training-program" id="${progId}" data-status="active" data-keywords="${keywords}">
//             //         <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">🎓</span> <span class="entity-name-display">${displayName}</span> </div> <div class="summary-actions"> <span class="entity-count course-count" id="${progId}-course-count"><span class="count-label">Sub-SOPs: </span>0</span> <button type="button" class="edit-btn" onclick="openEditModal('program', '${progId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="deleteProgramOrCourse('program', '${progId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" onclick="openAddModal('course', '${progId}', '${nameEscaped}')" class="action-button summary-action-btn add-course"><span class="btn-icon">➕</span><span>Add Sub-SOP</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${progId}', 'program', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>
//             //         <div class="scoped-upload-section"> <h4>Bulk Add Sub-SOPs to this SOPs</h4> <div class="button-pair"> <button type="button" class="action-button download-sample" onclick="downloadCourseSampleCsv('${progId}', '${nameEscaped}')">📄 Sample CSV for Sub-SOPs</button> <button type="button" class="action-button upload-scoped" onclick="openUploadCoursesCsvModal('${progId}', '${nameEscaped}')">⬆️ Upload Sub-SOPs CSV</button> </div> </div>
//             //         <div class="entity-content-wrapper"><p class="entity-description" data-field="description">${description}</p><div class="keywords-display-container"></div><div class="keyword-management-section"><h4>Bulk Keyword Management</h4><div class="button-pair"><button type="button" class="action-button download-sample" onclick="downloadKeywordSampleCsv('${progId}', '${nameEscaped}')">📄 Sample Keywords CSV</button><button type="button" class="action-button upload-scoped" onclick="openUploadKeywordsCsvModal('${progId}', '${nameEscaped}')">⬆️ Upload Keywords CSV</button></div></div><div class="course-container"></div></div>
//             //     </details>`;
            
//             const mainContentArea = document.getElementById('mainContentArea');
//             const firstProgram = mainContentArea.querySelector('.training-program');
//             if (firstProgram) {
//                 firstProgram.insertAdjacentHTML('beforebegin', progHTML);
//             } else {
//                 const dashboardDetails = document.querySelector('.super-admin-dashboard-details');
//                 if (dashboardDetails) {
//                     dashboardDetails.insertAdjacentHTML('afterend', progHTML);
//                 } else { 
//                     mainContentArea.insertAdjacentHTML('afterbegin', progHTML);
//                 }
//             }
//             const newProgElement = document.getElementById(progId);
//             if(newProgElement) {
//                 renderInteractiveKeywords(newProgElement);
//             }
//             return progId;
//         }
    
    
//         function processCourseFromCsv(csvRow) { 
//             const programName = csvRow.parentname;
//             const name = csvRow.name;
//             const description = csvRow.description || 'No description.';
//             const keywords = csvRow.keywords || '';
//             const courseNameEscaped = name.replace(/'/g, "\\'");
//             const courseDisplayName = `Sub-SOP-(${name})`;
//             const programDisplayName = `SOPs-(${programName})`;
            
//             const programElement = Array.from(document.querySelectorAll('.training-program')).find(prog =>
//                 prog.querySelector('.entity-name-display').textContent.trim() === programDisplayName.trim()
//             );
    
//             if (!programElement) {
//                 console.warn(`CSV Warning: SOPs parent "${programName}" not found for Sub-SOP "${name}". Skipping.`);
//                 return null;
//             }
            
//             const existingCourseElement = Array.from(programElement.querySelectorAll('.course-item .entity-name-display')).find(el => el.textContent.trim() === courseDisplayName.trim());
//             if (existingCourseElement) {
//                 console.log(`Sub-SOP "${name}" under SOPs "${programName}" already exists. Skipping.`);
//                 return existingCourseElement.closest('.course-item').id;
//             }
    
//             const courseId = generateId('course'); 
//             // const courseHTML = `
//                 // <details class="entity-level course-item" id="${courseId}" data-status="active" data-keywords="${keywords}">
//                 //     <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">📖</span> <span class="entity-name-display">${courseDisplayName}</span> </div> <div class="summary-actions"> <button type="button" class="edit-btn" onclick="openEditModal('course', '${courseId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="deleteProgramOrCourse('course', '${courseId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${courseId}', 'course', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>
//                 //     <div class="entity-content-wrapper"><p class="entity-description" data-field="description">${description}</p><div class="keywords-display-container"></div><div class="keyword-management-section"><h4>Bulk Keyword Management</h4><div class="button-pair"><button type="button" class="action-button download-sample" onclick="downloadKeywordSampleCsv('${courseId}', '${courseNameEscaped}')">📄 Sample Keywords CSV</button><button type="button" class="action-button upload-scoped" onclick="openUploadKeywordsCsvModal('${courseId}', '${courseNameEscaped}')">⬆️ Upload Keywords CSV</button></div></div></div>
//                 // </details>`;
            
//             const courseContainer = programElement.querySelector('.course-container');
//             if (courseContainer) {
//                 courseContainer.insertAdjacentHTML('beforeend', courseHTML);
//                 const newCourseElement = document.getElementById(courseId);
//                 if(newCourseElement) {
//                     renderInteractiveKeywords(newCourseElement);
//                 }
//             } else {
//                 console.error(`CRITICAL ERROR: Could not find .course-container in SOPs "${programName}" (ID: ${programElement.id}) while trying to add Sub-SOP "${name}".`);
//                 return null; 
//             }
//             return courseId;
//         }
    
//         function handleUploadCoursesCsv() { 
//             const fileInput = document.getElementById('uploadCoursesFileCsv'); 
//             const statusEl = document.getElementById('uploadCoursesStatus'); 
//             const progId = document.getElementById('uploadCoursesProgramId').value; 
//             const progName = document.getElementById('uploadCoursesProgramName').value; 
            
//             if (!fileInput.files.length) {
//                 statusEl.textContent = 'Please select a CSV file first.';
//                 statusEl.style.backgroundColor = '#ffebee';
//                 statusEl.style.color = '#c62828';
//                 return;
//             }
    
//             const file = fileInput.files[0];
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 try {
//                     const csvData = e.target.result;
//                     const lines = csvData.split('\n').filter(line => line.trim() !== '');
//                     const headers = lines[0].split(',').map(h => h.trim().toLowerCase());
                    
//                     const requiredHeaders = ['level', 'name'];
//                     if (!requiredHeaders.every(rh => headers.includes(rh))) {
//                         statusEl.innerHTML = 'Error: CSV must contain "Level" and "Name" columns.';
//                         statusEl.style.backgroundColor = '#ffebee';
//                         statusEl.style.color = '#c62828';
//                         return;
//                     }
    
//                     const courseEntities = []; 
    
//                     for (let i = 1; i < lines.length; i++) {
//                         const values = lines[i].split(',');
//                         const entity = {};
//                         headers.forEach((header, index) => {
//                             entity[header] = values[index] ? values[index].trim() : '';
//                         });
    
//                         if (entity.level.toLowerCase() === 'sub-sop') { 
//                             entity.parentname = progName; 
//                             courseEntities.push(entity);
//                         }
//                     }
    
//                     courseEntities.forEach(processCourseFromCsv); 
    
//                     statusEl.innerHTML = 'Successfully processed CSV file!<br>' +
//                         `Sub-SOPs Added: ${courseEntities.length}`;
//                     statusEl.style.backgroundColor = '#e8f5e9';
//                     statusEl.style.color = '#2e7d32';
//                 } catch (error) {
//                     console.error('Error processing CSV:', error);
//                     statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
//                     statusEl.style.backgroundColor = '#ffebee';
//                     statusEl.style.color = '#c62828';
//                 } finally {
//                     const programElement = document.getElementById(progId);
//                     if (programElement) updateProgramEntityCounts(programElement);
//                     populateCourseFilter(); 
//                     updateAllCountsAndDisplays();
//                     applyAllFilters();
//                     setTimeout(() => closeModal('uploadCoursesModal'), 2000);
//                 }
//             };
//             reader.readAsText(file);
//         }
    
    
//         // --- INITIALIZATION ---
//         document.addEventListener('DOMContentLoaded', function() {
//             filterProgramEl = document.getElementById('filterProgram'); 
//             filterCourseEl = document.getElementById('filterCourse');
//             filterKeywordEl = document.getElementById('filterKeyword'); 
//             clearFiltersButtonEl = document.getElementById('clearFiltersButton');
    
//             if (filterProgramEl) filterProgramEl.addEventListener('change', () => {
//                 if(filterCourseEl) filterCourseEl.value = 'all';
//                 applyAllFilters();
//             });
//             if (filterCourseEl) filterCourseEl.addEventListener('change', applyAllFilters);
//             if (filterKeywordEl) filterKeywordEl.addEventListener('input', applyAllFilters);
//             if (clearFiltersButtonEl) clearFiltersButtonEl.addEventListener('click', clearAllFilters);
            
//             document.querySelectorAll('.entity-level').forEach(el => {
//                 renderInteractiveKeywords(el);
//             });
    
//             populateProgramFilter(); 
//             populateCourseFilter(); 
//             updateAllCountsAndDisplays();
//             applyAllFilters(); 
//         });
    
//         // Close modals when clicking outside
//         window.addEventListener('click', function(event) {
//             const modals = document.querySelectorAll('.modal');
//             modals.forEach(modal => {
//                 if (event.target === modal) {
//                     closeModal(modal.id);
//                 }
//             });
//         });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTabId = button.dataset.tab;
                    const targetTabContent = document.getElementById(targetTabId);

                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    button.classList.add('active');
                    targetTabContent.classList.add('active');
                });
            });
        });
    </script>
    
    <!-- Script from your provided code -->
    <script>
        // --- CONSTANTS & GLOBALS ---
        let currentEntityType = null, currentEntityId = null, currentParentId = null, currentParentName = '';
        let filterProgramEl, filterCourseEl, filterKeywordEl, clearFiltersButtonEl; 
    
        // --- UTILITY FUNCTIONS ---
        function generateId(prefix) { return `${prefix}_${Date.now()}_${Math.floor(Math.random() * 1000)}`; }
        function getOriginalName(displayName) {
            if (displayName.startsWith('SOPs-(') && displayName.endsWith(')')) {
                return displayName.substring(6, displayName.length - 1);
            }
            if (displayName.startsWith('Sub-SOP-(') && displayName.endsWith(')')) {
                return displayName.substring(9, displayName.length - 1);
            }
            return displayName;
        }

        // --- MODAL FUNCTIONS ---
        function openModal(modalId) { document.getElementById(modalId).style.display = 'block'; }
        function closeModal(modalId) { 
            const modalElement = document.getElementById(modalId); 
            if (!modalElement) return; 
            modalElement.style.display = 'none'; 
            if (modalId === 'programModal' || modalId === 'courseModal') { 
                const form = document.getElementById(modalId.replace('Modal', 'Form')); 
                if (form) form.reset(); 
                currentEntityType = currentEntityId = currentParentId = currentParentName = null; 
            } else if (modalId === 'uploadCoursesModal' || modalId === 'superAdminCsvUploadModal' || modalId === 'uploadKeywordsModal') {
                const formId = modalId.replace('Modal','Form');
                const statusId = modalId.replace('Modal','Status');
                document.getElementById(formId)?.reset(); 
                const statusEl = document.getElementById(statusId);
                if(statusEl) {
                    statusEl.innerHTML = ''; 
                    statusEl.style.backgroundColor = '#e9ecef'; 
                    statusEl.style.color = 'var(--text-primary)'; 
                }
            }
        }
        function getDisplayValue(element, fieldName) { 
            const contentWrapper = element.querySelector('.entity-content-wrapper'); 
            if (!contentWrapper) return '';
            const el = contentWrapper.querySelector(`p[data-field="${fieldName}"]`);
            return el ? el.textContent.trim() : ''; 
        }
        
        // --- INLINE KEYWORD & ALIAS MANAGEMENT ---
        function renderInteractiveKeywords(entityElement) {
            if (!entityElement) return;
            const entityId = entityElement.id;
            const keywordsContainer = entityElement.querySelector('.keywords-display-container');
            if (!keywordsContainer) return;
    
            const keywordsString = entityElement.dataset.keywords || '';
            const keywords = keywordsString.split(',').map(k => k.trim()).filter(Boolean);
    
            const keywordsListHTML = keywords.map(k => {
                const keywordEscaped = k.replace(/'/g, "\\'");
                return `<span class="keyword-tag">${k}<button class="delete-keyword-btn" onclick="deleteInlineKeyword('${entityId}', '${keywordEscaped}')">×</button></span>`;
            }).join('');
    
            const addKeywordHTML = `
                <div class="add-keyword-wrapper">
                    <button class="add-keyword-btn" onclick="toggleAddKeywordInput(this, true)">
                        <span class="btn-icon">+</span> Add Keyword
                    </button>
                    <div class="add-keyword-input-group hidden">
                        <input type="text" class="add-keyword-input" placeholder="New keyword" onkeydown="handleKeywordInputKeydown(event, '${entityId}')">
                        <button class="save-keyword-btn" onclick="saveNewInlineKeyword(this, '${entityId}')">✓</button>
                        <button class="cancel-keyword-btn" onclick="toggleAddKeywordInput(this.parentElement, false)">×</button>
                    </div>
                </div>
            `;
    
            keywordsContainer.innerHTML = `
                <strong>Keywords:</strong>
                <div class="keywords-list">${keywordsListHTML}</div>
                ${addKeywordHTML}
            `;
            keywordsContainer.style.display = 'flex';
        }
    
        function toggleAddKeywordInput(element, show) {
            const wrapper = element.closest('.add-keyword-wrapper');
            const addButton = wrapper.querySelector('.add-keyword-btn');
            const inputGroup = wrapper.querySelector('.add-keyword-input-group');
            const inputField = wrapper.querySelector('.add-keyword-input');
    
            if (show) {
                addButton.classList.add('hidden');
                inputGroup.classList.remove('hidden');
                inputField.value = '';
                inputField.focus();
            } else {
                addButton.classList.remove('hidden');
                inputGroup.classList.add('hidden');
                inputField.value = '';
            }
        }
    
        function handleKeywordInputKeydown(event, entityId) {
            if (event.key === 'Enter') {
                event.preventDefault();
                saveNewInlineKeyword(event.target, entityId);
            } else if (event.key === 'Escape') {
                event.preventDefault();
                toggleAddKeywordInput(event.target, false);
            }
        }
    
function saveNewInlineKeyword(element, entityId) {
    const inputGroup = element.closest('.add-keyword-input-group');
    const inputField = inputGroup.querySelector('.add-keyword-input');
    const newKeyword = inputField.value.trim();

    if (newKeyword === '') {
        inputField.focus();
        return;
    }

    const entityElement = document.getElementById(entityId);
    if (!entityElement) return;

    let existingKeywords = (entityElement.dataset.keywords || '')
        .split(',')
        .map(k => k.trim())
        .filter(Boolean);

    if (!existingKeywords.includes(newKeyword)) {
        existingKeywords.push(newKeyword);
        entityElement.dataset.keywords = existingKeywords.join(', ');
    }

    renderInteractiveKeywords(entityElement);

    const newAddButton = entityElement.querySelector('.add-keyword-btn');
    if (newAddButton) {
        toggleAddKeywordInput(newAddButton, true);
    }

    // 🔹 Extract numeric course_id from "course65"
    const courseId = entityId.replace(/\D/g, ''); // remove all non-digits → gives "65"

    // 🔹 AJAX call to save keyword
    const url = '{{ route("add_keyword") }}';
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            course_id: courseId,
            keyword: newKeyword
        },
        success: function (response) {
            console.log('Keyword saved successfully:', response);
        },
        error: function (xhr) {
            console.error('Failed to save keyword:', xhr.responseText);
            alert('Failed to save keyword on server.');

            // rollback on failure
            existingKeywords = existingKeywords.filter(k => k !== newKeyword);
            entityElement.dataset.keywords = existingKeywords.join(', ');
            renderInteractiveKeywords(entityElement);
        }
    });
}

    
       function deleteInlineKeyword(entityId, keywordToDelete) {
    const entityElement = document.getElementById(entityId);
    if (!entityElement) return;

    // Confirm before deleting
    if (!confirm(`Are you sure you want to delete "${keywordToDelete}"?`)) {
        return;
    }

    // 🔹 Extract numeric course_id from something like "course65"
    const courseId = entityId.replace(/\D/g, '');

    // 🔹 AJAX call to delete keyword
    const url = '{{ route("delete_keyword") }}';
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            course_id: courseId,
            keyword: keywordToDelete
        },
        success: function (response) {
            console.log('Keyword deleted successfully:', response);

            // Update local data after successful delete
            let keywords = (entityElement.dataset.keywords || '')
                .split(',')
                .map(k => k.trim())
                .filter(Boolean);

            const updatedKeywords = keywords.filter(k => k !== keywordToDelete);
            entityElement.dataset.keywords = updatedKeywords.join(', ');
            renderInteractiveKeywords(entityElement);
        },
        error: function (xhr) {
            console.error('Failed to delete keyword:', xhr.responseText);
            alert('Failed to delete keyword on server.');
        }
    });
}
    
        // --- CORE CRUD & DISPLAY FUNCTIONS ---
        function openAddModal(entityType, parentId, parentName) {
            currentEntityType = entityType; currentParentId = parentId; currentParentName = parentName; currentEntityId = null;
            let modalId, modalTitleElId, formId, titlePrefix = "Add New";
            if (entityType === 'program') { 
                modalId = 'programModal'; modalTitleElId = 'programModalTitle'; formId = 'programForm';
                document.getElementById('programEntityId').value = '';
                document.getElementById(modalTitleElId).textContent = `${titlePrefix} SOPs`;
            } else if (entityType === 'course') { 
                modalId = 'courseModal'; modalTitleElId = 'courseModalTitle'; formId = 'courseForm';
                document.getElementById('courseParentId').value = parentId;
                document.getElementById(modalTitleElId).textContent = `${titlePrefix} Sub-SOP under "SOPs-(${parentName})"`;
            }
            if (modalId) {
                const formElement = document.getElementById(formId);
                if (formElement) formElement.reset();
                openModal(modalId);
            }
        }
    
        function openEditModal(entityType, entityId) {
            currentEntityType = entityType; currentEntityId = entityId; currentParentId = null;
            const entityEl = document.getElementById(entityId);
            if (!entityEl) { console.error("Entity not found:", entityId); return; }
            let modalId, modalTitleElId, titlePrefix = "Edit";
            const entityNameDisplay = entityEl.querySelector('.entity-name-display').textContent;
            const originalName = getOriginalName(entityNameDisplay);
            const keywords = entityEl.dataset.keywords || '';
    
            if (entityType === 'program') {
                modalId = 'programModal'; modalTitleElId = 'programModalTitle';
                document.getElementById('programEntityId').value = entityId;
                document.getElementById('programNameModal').value = originalName;
                document.getElementById('programDescriptionModal').value = getDisplayValue(entityEl, 'description');
                document.getElementById('programKeywordsModal').value = keywords;
                document.getElementById(modalTitleElId).textContent = `${titlePrefix} SOPs`;
            } else if (entityType === 'course') {
                modalId = 'courseModal'; modalTitleElId = 'courseModalTitle';
                document.getElementById('courseEntityId').value = entityId;
                document.getElementById('courseNameModal').value = originalName;
                document.getElementById('courseDescriptionModal').value = getDisplayValue(entityEl, 'description');
                document.getElementById('courseKeywordsModal').value = keywords;
                document.getElementById(modalTitleElId).textContent = `${titlePrefix} Sub-SOP`;
            }
            if (modalId) openModal(modalId);
        }
    
        function updateDisplay(element, fieldName, newValue) { 
            const contentWrapper = element.querySelector('.entity-content-wrapper');
            if (!contentWrapper) return;
            const descEl = contentWrapper.querySelector(`p[data-field="${fieldName}"]`);
            if (descEl) {
                descEl.textContent = newValue || 'No description provided.'; 
            }
        }
    
        function saveProgram() { 
            const entityIdInput = document.getElementById('programEntityId'); 
            const entityId = entityIdInput.value; 
            const name = document.getElementById('programNameModal').value; 
            const description = document.getElementById('programDescriptionModal').value; 
            const keywords = document.getElementById('programKeywordsModal').value;
            const nameEscaped = name.replace(/'/g, "\\'"); 
            const displayName = `SOPs-(${name})`;
            
            if (entityId) { 
                const progElement = document.getElementById(entityId); 
                if (!progElement) return; 
                progElement.querySelector('.entity-name-display').textContent = displayName; 
                progElement.querySelector('.summary-action-btn.add-course')?.setAttribute('onclick', `openAddModal('course', '${entityId}', '${nameEscaped}')`); 
                progElement.querySelector('.scoped-upload-section .download-sample').setAttribute('onclick', `downloadCourseSampleCsv('${entityId}', '${nameEscaped}')`); 
                progElement.querySelector('.scoped-upload-section .upload-scoped').setAttribute('onclick', `openUploadCoursesCsvModal('${entityId}', '${nameEscaped}')`); 
                progElement.querySelector('.keyword-management-section .download-sample').setAttribute('onclick', `downloadKeywordSampleCsv('${entityId}', '${nameEscaped}')`); 
                progElement.querySelector('.keyword-management-section .upload-scoped').setAttribute('onclick', `openUploadKeywordsCsvModal('${entityId}', '${nameEscaped}')`);
                updateDisplay(progElement, 'description', description); 
                progElement.dataset.keywords = keywords; 
                renderInteractiveKeywords(progElement); 
            } else { 
                const newProgId = generateId('prog'); 
                const mainContentArea = document.getElementById('mainContentArea'); 
                const firstProgram = mainContentArea.querySelector('.training-program'); 
                const programHTML = ` <details class="entity-level training-program" id="${newProgId}" data-status="active" data-keywords="${keywords}"> <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">🎓</span> <span class="entity-name-display">${displayName}</span> </div> <div class="summary-actions"> <span class="entity-count course-count" id="${newProgId}-course-count"><span class="count-label">Sub-SOPs: </span>0</span> <button type="button" class="edit-btn" onclick="openEditModal('program', '${newProgId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="deleteProgramOrCourse('program', '${newProgId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" onclick="openAddModal('course', '${newProgId}', '${nameEscaped}')" class="action-button summary-action-btn add-course"><span class="btn-icon">➕</span><span>Add Sub-SOP</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${newProgId}', 'program', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary> <div class="scoped-upload-section"> <h4>Bulk Add Sub-SOPs to this SOPs</h4> <div class="button-pair"> <button type="button" class="action-button download-sample" onclick="downloadCourseSampleCsv('${newProgId}', '${nameEscaped}')">📄 Sample CSV for Sub-SOPs</button> <button type="button" class="action-button upload-scoped" onclick="openUploadCoursesCsvModal('${newProgId}', '${nameEscaped}')">⬆️ Upload Sub-SOPs CSV</button> </div> </div> <div class="entity-content-wrapper"><p class="entity-description" data-field="description">${description || 'No description provided.'}</p><div class="keywords-display-container"></div><div class="keyword-management-section"><h4>Bulk Keyword Management</h4><div class="button-pair"><button type="button" class="action-button download-sample" onclick="downloadKeywordSampleCsv('${newProgId}', '${nameEscaped}')">📄 Sample Keywords CSV</button><button type="button" class="action-button upload-scoped" onclick="openUploadKeywordsCsvModal('${newProgId}', '${nameEscaped}')">⬆️ Upload Keywords CSV</button></div></div><div class="course-container"></div></div></details>`; 
                if (firstProgram) { 
                    firstProgram.insertAdjacentHTML('beforebegin', programHTML); 
                } else { 
                    const dashboardDetails = document.querySelector('.super-admin-dashboard-details'); 
                    if(dashboardDetails) dashboardDetails.insertAdjacentHTML('afterend', programHTML); 
                    else { mainContentArea.insertAdjacentHTML('afterbegin', programHTML); } 
                } 
                const newProgElement = document.getElementById(newProgId); 
                if (newProgElement) { 
                    renderInteractiveKeywords(newProgElement); 
                    updateProgramEntityCounts(newProgElement); 
                } 
                entityIdInput.value = ''; 
            } 
            closeModal('programModal'); 
            populateProgramFilter(); 
            applyAllFilters(); 
            updateSuperAdminDashboardStats(); 
        }
    
        function saveCourse() { 
            const entityId = document.getElementById('courseEntityId').value; 
            const parentId = document.getElementById('courseParentId').value; 
            const courseName = document.getElementById('courseNameModal').value; 
            const description = document.getElementById('courseDescriptionModal').value; 
            const keywords = document.getElementById('courseKeywordsModal').value;
            const courseNameEscaped = courseName.replace(/'/g, "\\'");
            const displayName = `Sub-SOP-(${courseName})`;
            
            if (entityId) { 
                const courseElement = document.getElementById(entityId); 
                if (!courseElement) return; 
                courseElement.querySelector('.entity-name-display').textContent = displayName;
                courseElement.querySelector('.keyword-management-section .download-sample').setAttribute('onclick', `downloadKeywordSampleCsv('${entityId}', '${courseNameEscaped}')`);
                courseElement.querySelector('.keyword-management-section .upload-scoped').setAttribute('onclick', `openUploadKeywordsCsvModal('${entityId}', '${courseNameEscaped}')`);
                updateDisplay(courseElement, 'description', description); 
                courseElement.dataset.keywords = keywords; 
                renderInteractiveKeywords(courseElement); 
            } else if (parentId) { 
                const programElement = document.getElementById(parentId); 
                if (!programElement) return; 
                const newCourseId = generateId('course'); 
                const courseHTML = ` <details class="entity-level course-item" id="${newCourseId}" data-status="active" data-keywords="${keywords}"> <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">📖</span> <span class="entity-name-display">${displayName}</span> </div> <div class="summary-actions">  <button type="button" class="edit-btn" onclick="openEditModal('course', '${newCourseId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="deleteProgramOrCourse('course', '${newCourseId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${newCourseId}', 'course', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>  <div class="entity-content-wrapper"><p class="entity-description" data-field="description">${description || 'No description.'}</p><div class="keywords-display-container"></div><div class="keyword-management-section"><h4>Bulk Keyword Management</h4><div class="button-pair"><button type="button" class="action-button download-sample" onclick="downloadKeywordSampleCsv('${newCourseId}', '${courseNameEscaped}')">📄 Sample Keywords CSV</button><button type="button" class="action-button upload-scoped" onclick="openUploadKeywordsCsvModal('${newCourseId}', '${courseNameEscaped}')">⬆️ Upload Keywords CSV</button></div></div></div> </details>`; 
                const courseContainer = programElement.querySelector('.course-container'); 
                courseContainer.insertAdjacentHTML('beforeend', courseHTML); 
                const newCourseElement = document.getElementById(newCourseId); 
                if(newCourseElement) {
                    renderInteractiveKeywords(newCourseElement); 
                }
                updateProgramEntityCounts(programElement); 
            } 
            closeModal('courseModal'); 
            populateCourseFilter(); 
            applyAllFilters(); 
            updateSuperAdminDashboardStats(); 
        }
    
        function deleteProgramOrCourse(entityType, entityId) {
            const entityElement = document.getElementById(entityId);
            if (!entityElement) return;
            const entityName = entityElement.querySelector('.entity-name-display').textContent;
            let message = `Are you sure you want to delete the ${entityType === 'program' ? 'SOPs' : 'Sub-SOP'} "${entityName}"?`;
            if (entityType === 'program') {
                message += " This will also delete all its Sub-SOPs.";
            }
            if (confirm(message)) {
                const parentProgramElement = entityElement.closest('.training-program');
                if (entityType === 'program') {
                    const courses = entityElement.querySelectorAll('.course-item');
                    courses.forEach(course => course.remove());
                }
                entityElement.remove();
                
                if (parentProgramElement && entityType === 'course' && parentProgramElement.id !== entityId) {
                    updateProgramEntityCounts(parentProgramElement);
                }
                populateProgramFilter();
                populateCourseFilter();
                applyAllFilters();
                updateSuperAdminDashboardStats();
            }
        }
        
        function toggleActivation(entityId, entityType, buttonElement) { const entityElement = document.getElementById(entityId); if (!entityElement) return; const currentStatus = entityElement.dataset.status; const newStatus = currentStatus === 'active' ? 'inactive' : 'active'; entityElement.dataset.status = newStatus; buttonElement.classList.toggle('active-state', newStatus === 'active'); buttonElement.classList.toggle('inactive-state', newStatus === 'inactive'); buttonElement.innerHTML = `<span class="btn-icon">${newStatus === 'active' ? '🟢' : '🔴'}</span><span>${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</span>`; applyAllFilters(); updateAllCountsAndDisplays(); }
        
        function setSpanText(spanId, label, count) { 
            const spanElement = document.getElementById(spanId); 
            if (spanElement) { 
                const strongElement = spanElement.querySelector('strong');
                const labelElement = spanElement.querySelector('.count-label');
                if(strongElement) {
                    strongElement.textContent = count;
                } else if (labelElement) {
                    spanElement.innerHTML = `<span class="count-label">${label} </span>${count}`; 
                } else {
                    spanElement.innerHTML = `<span class="count-label">${label} </span><strong>${count}</strong>`; 
                }
            }
        }
        
        function updateCourseEntityCounts(courseElement) { 
            if (!courseElement) return; 
        }
    
        function updateProgramEntityCounts(progElement) { 
            if (!progElement) return; 
            const progId = progElement.id; 
            const courses = progElement.querySelectorAll('.course-container .entity-level.course-item:not(.hidden-by-filter)'); 
            setSpanText(`${progId}-course-count`, 'Sub-SOPs: ', courses.length); 
        }
    
        function updateSuperAdminDashboardStats() {
            const allPrograms = document.querySelectorAll('.training-program'); 
            const allCourses = document.querySelectorAll('.course-item'); 
            document.getElementById('dashStatTotalPrograms').textContent = allPrograms.length;
            document.getElementById('dashStatTotalCourses').textContent = allCourses.length;
        }
    
        function updateAllCountsAndDisplays() { 
            document.querySelectorAll('.training-program:not(.hidden-by-filter)').forEach(updateProgramEntityCounts);
            document.querySelectorAll('.course-item:not(.hidden-by-filter)').forEach(updateCourseEntityCounts); 
            updateSuperAdminDashboardStats();
        }
    
        // --- FILTER FUNCTIONS ---
        function populateProgramFilter() { 
            const filterEl = document.getElementById('filterProgram');
            if (!filterEl) return;
            const currentValue = filterEl.value;
            filterEl.innerHTML = '<option value="all">All SOPs</option>';
            document.querySelectorAll('.training-program').forEach(prog => { 
                const name = prog.querySelector('.entity-name-display').textContent;
                filterEl.innerHTML += `<option value="${prog.id}">${name}</option>`;
            });
            filterEl.value = currentValue; 
        }
    
        function populateCourseFilter() { 
            const filterEl = document.getElementById('filterCourse');
            if (!filterEl) return;
            const currentValue = filterEl.value;
            filterEl.innerHTML = '<option value="all">All Sub-SOPs</option>';
            const selectedProgramId = document.getElementById('filterProgram').value;
    
            document.querySelectorAll('.course-item').forEach(course => { 
                const parentProgram = course.closest('.training-program');
                if (selectedProgramId === 'all' || (parentProgram && parentProgram.id === selectedProgramId)) {
                    const name = course.querySelector('.entity-name-display').textContent;
                    const progName = parentProgram?.querySelector('.entity-name-display').textContent || 'Unknown SOPs';
                    filterEl.innerHTML += `<option value="${course.id}">${name} (${progName})</option>`;
                }
            });
             filterEl.value = currentValue; 
        }
    
        function applyAllFilters() {
            const progFilterValue = document.getElementById('filterProgram').value;
            const courseFilterValue = document.getElementById('filterCourse').value;
            const keywordFilterValue = document.getElementById('filterKeyword').value.toLowerCase().trim();
    
            document.querySelectorAll('.training-program, .course-item').forEach(el => el.classList.remove('hidden-by-filter'));
    
            document.querySelectorAll('.training-program').forEach(prog => {
                const name = prog.querySelector('.entity-name-display').textContent.toLowerCase();
                const description = getDisplayValue(prog, 'description').toLowerCase();
                const userKeywords = (prog.dataset.keywords || '').toLowerCase();
                
                const programMatchesKeyword = keywordFilterValue === '' || `${name} ${description} ${userKeywords}`.includes(keywordFilterValue);
                const programMatchesDropdown = progFilterValue === 'all' || prog.id === progFilterValue;
    
                let hasVisibleCourse = false;
    
                prog.querySelectorAll('.course-item').forEach(course => {
                    const cName = course.querySelector('.entity-name-display').textContent.toLowerCase();
                    const cDescription = getDisplayValue(course, 'description').toLowerCase();
                    const cUserKeywords = (course.dataset.keywords || '').toLowerCase();

                    const courseMatchesKeyword = keywordFilterValue === '' || `${cName} ${cDescription} ${cUserKeywords}`.includes(keywordFilterValue);
                    const courseMatchesDropdown = courseFilterValue === 'all' || course.id === courseFilterValue;
                    
                    const courseIsVisible = courseMatchesDropdown && courseMatchesKeyword;
                    
                    if (!courseIsVisible) {
                        course.classList.add('hidden-by-filter');
                    }
                    if (courseIsVisible && programMatchesDropdown) {
                        hasVisibleCourse = true;
                    }
                });
                const programIsVisible = programMatchesDropdown && (programMatchesKeyword || hasVisibleCourse);
                
                if(!programIsVisible) {
                    prog.classList.add('hidden-by-filter');
                }
            });
    
            populateCourseFilter();
            updateAllCountsAndDisplays();
        }
    
        function clearAllFilters() {
            document.getElementById('filterProgram').value = 'all';
            document.getElementById('filterCourse').value = 'all';
            document.getElementById('filterKeyword').value = '';
            applyAllFilters();
        }
    
        // --- CSV HANDLING FUNCTIONS ---
        function downloadFullSampleCsv() {
            const csvContent = `Level,ParentName,Name,Description,Keywords
SOPs,,Foundational Skills Program,"Core training for all new employees","onboarding, core, compliance"
Sub-SOP,Foundational Skills Program,Intro to Company Policies,"Overview of key company policies","hr, policy, procedures"
SOPs,,Advanced Leadership Development,"For senior managers and team leads","leadership, management, advanced"
Sub-SOP,Advanced Leadership Development,Strategic Thinking Workshop,"Develop strategic planning skills","strategy, planning, executive"`;
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', 'full_sops_sample.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    
        function downloadCourseSampleCsv(progId, progName) { 
            const csvContent = `Level,ParentName,Name,Description,Keywords
Sub-SOP,${progName},New Sub-SOP Title,"Sub-SOP description details","keyword1, keyword2"`;
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', `sub-sops_sample_for_${progName.replace(/[^a-z0-9]/gi, '_')}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    
        function downloadKeywordSampleCsv(entityId, entityName) {
            const csvContent = `Keywords\nkeyword1\nsample-keyword\nanother-one`;
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', `keywords_sample_for_${entityName.replace(/[^a-z0-9]/gi, '_')}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function openUploadKeywordsCsvModal(entityId, entityName) {
            document.getElementById('uploadKeywordsForm').reset(); 
            document.getElementById('uploadKeywordsStatus').innerHTML = ''; 
            document.getElementById('uploadKeywordsEntityId').value = entityId; 
            document.getElementById('uploadKeywordsEntityName').value = entityName; 
            document.getElementById('uploadKeywordsTargetEntityName').textContent = entityName; 
            openModal('uploadKeywordsModal'); 
        }

        function handleUploadKeywordsCsv() {
            const fileInput = document.getElementById('uploadKeywordsFileCsv');
            const statusEl = document.getElementById('uploadKeywordsStatus');
            const entityId = document.getElementById('uploadKeywordsEntityId').value;
            const entityElement = document.getElementById(entityId);

            if (!fileInput.files.length) {
                statusEl.textContent = 'Please select a CSV file first.';
                statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828';
                return;
            }
            if (!entityElement) {
                statusEl.textContent = 'Target entity not found. Please close and try again.';
                statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828';
                return;
            }

            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const csvData = e.target.result;
                    const lines = csvData.split(/\r?\n/).filter(line => line.trim() !== '');
                    if (lines.length <= 1) { // Header only or empty
                        throw new Error('CSV is empty or contains only a header.');
                    }
                    
                    const newKeywords = lines.slice(1).map(line => line.split(',')[0].trim()).filter(Boolean);
                    
                    if(newKeywords.length === 0) {
                        throw new Error('No valid keywords found in the CSV file.');
                    }

                    const existingKeywords = new Set((entityElement.dataset.keywords || '').split(',').map(k => k.trim()).filter(Boolean));
                    newKeywords.forEach(k => existingKeywords.add(k));

                    entityElement.dataset.keywords = Array.from(existingKeywords).join(', ');
                    renderInteractiveKeywords(entityElement); 

                    statusEl.innerHTML = `Successfully added/merged ${newKeywords.length} keywords.`;
                    statusEl.style.backgroundColor = '#e8f5e9'; statusEl.style.color = '#2e7d32';

                    setTimeout(() => closeModal('uploadKeywordsModal'), 2000);
                } catch (error) {
                    console.error('Error processing Keywords CSV:', error);
                    statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
                    statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828';
                }
            };
            reader.readAsText(file);
        }

        function openSuperAdminCsvUploadModal() {
            document.getElementById('superAdminCsvUploadForm').reset();
            document.getElementById('superAdminCsvUploadStatus').innerHTML = '';
            openModal('superAdminCsvUploadModal');
        }
    
        function openUploadCoursesCsvModal(progId, progName) { 
            document.getElementById('uploadCoursesForm').reset(); 
            document.getElementById('uploadCoursesStatus').innerHTML = ''; 
            document.getElementById('uploadCoursesProgramId').value = progId; 
            document.getElementById('uploadCoursesProgramName').value = progName; 
            document.getElementById('uploadCoursesTargetProgramName').textContent = `SOPs-(${progName})`; 
            document.getElementById('uploadCoursesTargetProgramNameMirror').textContent = `SOPs-(${progName})`; 
            openModal('uploadCoursesModal'); 
        }
        
        function handleSuperAdminCsvUpload() {
            const fileInput = document.getElementById('superAdminFileCsv');
            const statusEl = document.getElementById('superAdminCsvUploadStatus');
            if (!fileInput.files.length) {
                statusEl.textContent = 'Please select a CSV file first.';
                statusEl.style.backgroundColor = '#ffebee';
                statusEl.style.color = '#c62828';
                return;
            }
    
            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const csvData = e.target.result;
                    const lines = csvData.split('\n').filter(line => line.trim() !== ''); 
                    const headers = lines[0].split(',').map(h => h.trim().toLowerCase()); 
                    
                    const requiredHeaders = ['level', 'name'];
                    if (!requiredHeaders.every(rh => headers.includes(rh))) {
                        statusEl.innerHTML = 'Error: CSV must contain "Level" and "Name" columns.';
                        statusEl.style.backgroundColor = '#ffebee';
                        statusEl.style.color = '#c62828';
                        return;
                    }
    
                    const programEntities = []; 
                    const courseEntities = []; 
    
                    for (let i = 1; i < lines.length; i++) {
                        const values = lines[i].split(',');
                        const entity = {};
                        headers.forEach((header, index) => {
                            entity[header] = values[index] ? values[index].trim() : '';
                        });
                        
                        if (entity.level.toLowerCase() === 'sops') { 
                            programEntities.push(entity);
                        } else if (entity.level.toLowerCase() === 'sub-sop') { 
                            courseEntities.push(entity);
                        }
                    }
    
                    programEntities.forEach(processProgramFromCsv); 
                    courseEntities.forEach(processCourseFromCsv); 
    
                    statusEl.innerHTML = 'Successfully processed CSV file!<br>' +
                        `SOPs: ${programEntities.length}<br>` +
                        `Sub-SOPs: ${courseEntities.length}`;
                    statusEl.style.backgroundColor = '#e8f5e9';
                    statusEl.style.color = '#2e7d32';
    
                } catch (error) {
                    console.error('Error processing CSV:', error);
                    statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
                    statusEl.style.backgroundColor = '#ffebee';
                    statusEl.style.color = '#c62828';
                } finally {
                    populateProgramFilter();
                    populateCourseFilter();
                    updateAllCountsAndDisplays();
                    applyAllFilters(); 
                    setTimeout(() => closeModal('superAdminCsvUploadModal'), 2000);
                }
            };
            reader.readAsText(file);
        }
    
        function processProgramFromCsv(csvRow) { 
            const name = csvRow.name;
            const description = csvRow.description || 'No description provided.';
            const keywords = csvRow.keywords || '';
            const displayName = `SOPs-(${name})`;
            
            const existingProgElement = Array.from(document.querySelectorAll('.training-program .entity-name-display'))
                                       .find(el => el.textContent.trim() === displayName.trim());
            if (existingProgElement) {
                console.log(`SOPs "${name}" already exists. Skipping creation.`);
                return existingProgElement.closest('.training-program').id;
            }
    
            const progId = generateId('prog'); 
            const nameEscaped = name.replace(/'/g, "\\'");
            const progHTML = `
                <details class="entity-level training-program" id="${progId}" data-status="active" data-keywords="${keywords}">
                    <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">🎓</span> <span class="entity-name-display">${displayName}</span> </div> <div class="summary-actions"> <span class="entity-count course-count" id="${progId}-course-count"><span class="count-label">Sub-SOPs: </span>0</span> <button type="button" class="edit-btn" onclick="openEditModal('program', '${progId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="deleteProgramOrCourse('program', '${progId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" onclick="openAddModal('course', '${progId}', '${nameEscaped}')" class="action-button summary-action-btn add-course"><span class="btn-icon">➕</span><span>Add Sub-SOP</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${progId}', 'program', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>
                    <div class="scoped-upload-section"> <h4>Bulk Add Sub-SOPs to this SOPs</h4> <div class="button-pair"> <button type="button" class="action-button download-sample" onclick="downloadCourseSampleCsv('${progId}', '${nameEscaped}')">📄 Sample CSV for Sub-SOPs</button> <button type="button" class="action-button upload-scoped" onclick="openUploadCoursesCsvModal('${progId}', '${nameEscaped}')">⬆️ Upload Sub-SOPs CSV</button> </div> </div>
                    <div class="entity-content-wrapper"><p class="entity-description" data-field="description">${description}</p><div class="keywords-display-container"></div><div class="keyword-management-section"><h4>Bulk Keyword Management</h4><div class="button-pair"><button type="button" class="action-button download-sample" onclick="downloadKeywordSampleCsv('${progId}', '${nameEscaped}')">📄 Sample Keywords CSV</button><button type="button" class="action-button upload-scoped" onclick="openUploadKeywordsCsvModal('${progId}', '${nameEscaped}')">⬆️ Upload Keywords CSV</button></div></div><div class="course-container"></div></div>
                </details>`;
            
            const mainContentArea = document.getElementById('mainContentArea');
            const firstProgram = mainContentArea.querySelector('.training-program');
            if (firstProgram) {
                firstProgram.insertAdjacentHTML('beforebegin', progHTML);
            } else {
                const dashboardDetails = document.querySelector('.super-admin-dashboard-details');
                if (dashboardDetails) {
                    dashboardDetails.insertAdjacentHTML('afterend', progHTML);
                } else { 
                    mainContentArea.insertAdjacentHTML('afterbegin', progHTML);
                }
            }
            const newProgElement = document.getElementById(progId);
            if(newProgElement) {
                renderInteractiveKeywords(newProgElement);
            }
            return progId;
        }
    
    
        function processCourseFromCsv(csvRow) { 
            const programName = csvRow.parentname;
            const name = csvRow.name;
            const description = csvRow.description || 'No description.';
            const keywords = csvRow.keywords || '';
            const courseNameEscaped = name.replace(/'/g, "\\'");
            const courseDisplayName = `Sub-SOP-(${name})`;
            const programDisplayName = `SOPs-(${programName})`;
            
            const programElement = Array.from(document.querySelectorAll('.training-program')).find(prog =>
                prog.querySelector('.entity-name-display').textContent.trim() === programDisplayName.trim()
            );
    
            if (!programElement) {
                console.warn(`CSV Warning: SOPs parent "${programName}" not found for Sub-SOP "${name}". Skipping.`);
                return null;
            }
            
            const existingCourseElement = Array.from(programElement.querySelectorAll('.course-item .entity-name-display')).find(el => el.textContent.trim() === courseDisplayName.trim());
            if (existingCourseElement) {
                console.log(`Sub-SOP "${name}" under SOPs "${programName}" already exists. Skipping.`);
                return existingCourseElement.closest('.course-item').id;
            }
    
            const courseId = generateId('course'); 
            const courseHTML = `
                <details class="entity-level course-item" id="${courseId}" data-status="active" data-keywords="${keywords}">
                    <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">📖</span> <span class="entity-name-display">${courseDisplayName}</span> </div> <div class="summary-actions"> <button type="button" class="edit-btn" onclick="openEditModal('course', '${courseId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="deleteProgramOrCourse('course', '${courseId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${courseId}', 'course', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>
                    <div class="entity-content-wrapper"><p class="entity-description" data-field="description">${description}</p><div class="keywords-display-container"></div><div class="keyword-management-section"><h4>Bulk Keyword Management</h4><div class="button-pair"><button type="button" class="action-button download-sample" onclick="downloadKeywordSampleCsv('${courseId}', '${courseNameEscaped}')">📄 Sample Keywords CSV</button><button type="button" class="action-button upload-scoped" onclick="openUploadKeywordsCsvModal('${courseId}', '${courseNameEscaped}')">⬆️ Upload Keywords CSV</button></div></div></div>
                </details>`;
            
            const courseContainer = programElement.querySelector('.course-container');
            if (courseContainer) {
                courseContainer.insertAdjacentHTML('beforeend', courseHTML);
                const newCourseElement = document.getElementById(courseId);
                if(newCourseElement) {
                    renderInteractiveKeywords(newCourseElement);
                }
            } else {
                console.error(`CRITICAL ERROR: Could not find .course-container in SOPs "${programName}" (ID: ${programElement.id}) while trying to add Sub-SOP "${name}".`);
                return null; 
            }
            return courseId;
        }
    
        function handleUploadCoursesCsv() { 
            const fileInput = document.getElementById('uploadCoursesFileCsv'); 
            const statusEl = document.getElementById('uploadCoursesStatus'); 
            const progId = document.getElementById('uploadCoursesProgramId').value; 
            const progName = document.getElementById('uploadCoursesProgramName').value; 
            
            if (!fileInput.files.length) {
                statusEl.textContent = 'Please select a CSV file first.';
                statusEl.style.backgroundColor = '#ffebee';
                statusEl.style.color = '#c62828';
                return;
            }
    
            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const csvData = e.target.result;
                    const lines = csvData.split('\n').filter(line => line.trim() !== '');
                    const headers = lines[0].split(',').map(h => h.trim().toLowerCase());
                    
                    const requiredHeaders = ['level', 'name'];
                    if (!requiredHeaders.every(rh => headers.includes(rh))) {
                        statusEl.innerHTML = 'Error: CSV must contain "Level" and "Name" columns.';
                        statusEl.style.backgroundColor = '#ffebee';
                        statusEl.style.color = '#c62828';
                        return;
                    }
    
                    const courseEntities = []; 
    
                    for (let i = 1; i < lines.length; i++) {
                        const values = lines[i].split(',');
                        const entity = {};
                        headers.forEach((header, index) => {
                            entity[header] = values[index] ? values[index].trim() : '';
                        });
    
                        if (entity.level.toLowerCase() === 'sub-sop') { 
                            entity.parentname = progName; 
                            courseEntities.push(entity);
                        }
                    }
    
                    courseEntities.forEach(processCourseFromCsv); 
    
                    statusEl.innerHTML = 'Successfully processed CSV file!<br>' +
                        `Sub-SOPs Added: ${courseEntities.length}`;
                    statusEl.style.backgroundColor = '#e8f5e9';
                    statusEl.style.color = '#2e7d32';
                } catch (error) {
                    console.error('Error processing CSV:', error);
                    statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
                    statusEl.style.backgroundColor = '#ffebee';
                    statusEl.style.color = '#c62828';
                } finally {
                    const programElement = document.getElementById(progId);
                    if (programElement) updateProgramEntityCounts(programElement);
                    populateCourseFilter(); 
                    updateAllCountsAndDisplays();
                    applyAllFilters();
                    setTimeout(() => closeModal('uploadCoursesModal'), 2000);
                }
            };
            reader.readAsText(file);
        }
    
    
        // --- INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', function() {
            filterProgramEl = document.getElementById('filterProgram'); 
            filterCourseEl = document.getElementById('filterCourse');
            filterKeywordEl = document.getElementById('filterKeyword'); 
            clearFiltersButtonEl = document.getElementById('clearFiltersButton');
    
            if (filterProgramEl) filterProgramEl.addEventListener('change', () => {
                if(filterCourseEl) filterCourseEl.value = 'all';
                applyAllFilters();
            });
            if (filterCourseEl) filterCourseEl.addEventListener('change', applyAllFilters);
            if (filterKeywordEl) filterKeywordEl.addEventListener('input', applyAllFilters);
            if (clearFiltersButtonEl) clearFiltersButtonEl.addEventListener('click', clearAllFilters);
            
            document.querySelectorAll('.entity-level').forEach(el => {
                renderInteractiveKeywords(el);
            });
    
            populateProgramFilter(); 
            populateCourseFilter(); 
            updateAllCountsAndDisplays();
            applyAllFilters(); 
        });
    
        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });
    </script>
    
    