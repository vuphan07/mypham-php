<?php

class NotFoundController extends BaseController
{
    public function index()
    {
        return $this->view('fontend.notfounds.index');
    }
}
