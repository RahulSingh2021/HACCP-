<script>
    function updateStickyColumns() {
      // Find the first element in each of the first two columns to measure their width
      const firstCol = document.querySelector('.sticky-col-1');
      const secondCol = document.querySelector('.sticky-col-2');

      if (!firstCol || !secondCol) {
        return; // Exit if columns aren't found
      }

      // Get the actual rendered width of the columns
      const firstColWidth = firstCol.offsetWidth;
      const secondColWidth = secondCol.offsetWidth;

      // Select all cells in the second and third sticky columns
      const allSecondCols = document.querySelectorAll('.sticky-col-2');
      const allThirdCols = document.querySelectorAll('.sticky-col-3');

      // Set the 'left' style for the second column
      allSecondCols.forEach(cell => {
        cell.style.left = `${firstColWidth}px`;
      });

      // Set the 'left' style for the third column based on the combined width of the first two
      allThirdCols.forEach(cell => {
        cell.style.left = `${firstColWidth + secondColWidth}px`;
      });
    }

    // Run the function on initial page load
    document.addEventListener('DOMContentLoaded', updateStickyColumns);
    
    // Rerun the function whenever the window is resized
    window.addEventListener('resize', updateStickyColumns);
  </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Restore active tab
        // const lastTabId = sessionStorage.getItem('activeTabId');
        // if (lastTabId) {
        //     const tabBtn = document.querySelector(`.tab-button[data-tab-target="${lastTabId}"]`);
        //     const tabContent = document.querySelector(lastTabId);

        //     if (tabBtn && tabContent) {
        //         document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        //         document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));

        //         tabBtn.classList.add('active');
        //         tabContent.classList.add('active');
        //     }
        // }

        // Store tab click
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.addEventListener('click', function () {
                // sessionStorage.setItem('activeTabId', this.dataset.tabTarget);
            });
        });

        // Score AJAX save on change
        document.querySelectorAll('.competency-select').forEach(select => {
            select.addEventListener('change', function (e) {
                const value = e.target.value;

                const payload = {
                    staff_id: e.target.dataset.staffId,
                    sop_id: e.target.dataset.sopId,
                    sub_sop_id: e.target.dataset.subId,
                    department_id: e.target.dataset.deptId,
                    category_id: e.target.dataset.catId,
                    score: value
                };

                fetch("{{ url('https://efsm.safefoodmitra.com/admin/public/index.php/training/tni/save-single-count') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || "Saved successfully");
                    } else {
                        toastr.error(data.message || "Failed to save");
                    }
                })
                .catch(error => {
                    // toastr.error("Server error");
                    // console.error(error);
                });
            });
        });
    });
</script>