<div class="project-remove-box-container">
  <div class="project-remove-box-card">
    <div class="alert-msg-name mt-4">Are you sure want to delete?</div>
    <form method="post" action="delete-projects">
      @method('DELETE')
      @csrf
      <div class="d-flex justify-content-center align-items-center">
        <div class="form-group mt-3 mb-2">
          <input type="hidden" id="delete-project-emp-id" name="employee_id" value="">
          <input type="hidden" id="delete-project-emp-name" name="employee_name" value="">
          <label for="">Project Name: &nbsp; &nbsp;</label>
          <select class="form-select form-select-lg mb-3" id="delete-project-select" name="delete_project" aria-label=".form-select-lg example">
          </select>
          <button type="submit" name="alert_msg_delete" class="btn btn-danger mt-3 me-2" >Delete</button>
          <button type="button" id="cancel-delete" name="alert_msg_cancel" class="btn btn-primary mt-3 ms-3">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>