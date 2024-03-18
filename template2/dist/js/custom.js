/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */
// var path = location.pathname.split('/')
// var url = location.origin + '/' + path[1]

// $('ul.sidebar-menu li a').each(function(){
//     if($(this).attr('href').indexOf(url) !== -1) {
//         $(this).parent().addClass('active').parent().parent('li').addClass('active')
//     }
// })

// modal confirmation
  function confirmDialog(title, message) {
    return new Promise((resolve) => {
      const confirmModal = `
        <div class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">${title}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>${message}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="resolveConfirm(true)">OK</button>
              </div>
            </div>
          </div>
        </div>
      `;

      // Append the modal to the body
      $('body').append(confirmModal);

      // Show the modal
      $('.modal').modal('show');

      // Resolve the promise based on user action
      window.resolveConfirm = (result) => {
        $('.modal').modal('hide');
        resolve(result);
      };

      // Remove the modal from the DOM when it's hidden
      $('.modal').on('hidden.bs.modal', function (e) {
        $(this).remove();
      });
    });
  }

  // Example usage
function submitDel(id) {
    confirmDialog('Hapus Device', 'Apakah Anda yakin?').then((result) => {
      if (result) {
        // User clicked 'OK', submit the form
        $('#del-' + id).submit();
      }
    });
    return false;
  }
  


