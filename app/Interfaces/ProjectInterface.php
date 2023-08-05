<?php

namespace App\Interfaces;

interface ProjectInterface
{
 
    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get all projects
     * 
     * return array
     * 
     * @access  public
     */
    public function getAllProjects();

    /**
     * @author HponeNaingTun
     * 
     * @create 29/06/2023
     * 
     * Get all current working project, end date less than or equal current date.
     * 
     * return array
     * 
     * @access  public
     */
    public function getAllCurrentProjects();

    /**
     * @author HponeNaingTun
     * 
     * @create 02/07/2023
     * 
     * Get project by id
     * 
     * return object
     * 
     * @access  public
     */
    public function getProjectById($id);

    /**
     * @author HponeNaingTun
     * 
     * @create 02/07/2023
     * 
     * Get current working project by id, end date less than or equal current date.
     * 
     * return array
     * 
     * @access  public
     */
    public function getCurrentProjectsById($id);

    public function isProjectAssignedOtherEmployees($id);

    public function getProjectDocumentationsById($id);

}