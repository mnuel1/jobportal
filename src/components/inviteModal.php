<div class="modal" tabindex="-1" id="inviteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Which job will you invite the applicant?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
        <?php
            // Assuming you have already established a database connection in $conn

            // Query to get job titles from the job_post table for the current company
            $sql = "SELECT id_jobpost, jobtitle FROM job_post WHERE id_company = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_SESSION["id_company"]);
            $stmt->execute();

            // Get the result set from the statement
            $result = $stmt->get_result();
        ?>
        <select id="jobpost" class="form-select" aria-label="Default select example">
            <option selected>Open this select menu</option>

            <?php
                // Check if there are results and populate the dropdown
                if ($result->num_rows > 0) {
                    // Loop through the result set and create an <option> for each job title
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['id_jobpost']) . '">' . htmlspecialchars($row['jobtitle']) . '</option>';
                    }
                } else {
                    // Optionally, you can handle the case where there are no jobs found
                    echo '<option disabled>No job titles available</option>';
                }
            ?>
        </select>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="sendInvite">Invite</button>
      </div>
    </div>
  </div>
</div>