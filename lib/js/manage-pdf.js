$('#uploadPdfModal').on('show.bs.modal', function(event) {
  var button = $(event.relatedTarget);             //Button that triggered the modal
  var subjectId = button.data('whatever');         //Extract info from data attributes

  var modal = $(this)
  modal.find('.modal-title').text('Upload PDF for subject id : ' + subjectId);
  modal.find('.modal-body #modalSubjectId').val(subjectId);
})