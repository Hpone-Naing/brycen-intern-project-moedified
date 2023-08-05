<div class="project-add-box-container">
    <div class="project-add-box-card">
        <div class="project-add-msg-name mt-2"><h1>Add New Project</h1></div>
        <form method="post" action="save-projects">
            @csrf
            <div class="d-flex justify-content-center align-items-center">
                <div class="form-group mt-3 mb-2">
                    <div class="form-group">
                        <input type="hidden" id="save-project-emp-id" name="employee_id" value="">
                        <input type="hidden" id="save-project-emp-name" name="employee_name" value="">
                        <input type="hidden" id="save-project-start-date" name="start_date" value="">
                        <input type="hidden" id="save-project-end-date" name="end_date" value="">
                        <input type="hidden" id="save-project-name" name="save_form_project_name" value="">
                        <label for="">Project Name: &nbsp; &nbsp;</label>
                        <!-- <input type="text" class="form-control input" name="project_name" style="width:300px"/> -->
                        <input type="text" class="form-control input" name="add_project_name" style="width:300px" required/>
                        @error('add_project_name')
                                    <div class="text-danger hide">{{ $message }}</div>
                        @enderror
                        <button type="submit" name="alert_msg_delete" class="btn btn-danger mt-3 me-2">Submit</button>
                        <button type="button" id="cancel-add-new" name="alert_msg_cancel" class="btn btn-primary mt-3 ms-3">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
