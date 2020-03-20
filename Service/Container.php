<?php


class Container
{
    private $taskService;
    private $viewService;
    private $messageService;

    /**
     * @return TaskService
     */
    public function getTaskService()
    {
        if ($this->taskService === null) {
            $this->taskService = new TaskService( $this->getMessageService(), $this->getViewService() );
        }

        return $this->taskService;
    }

    /**
     * @return ViewService
     */
    public function getViewService()
    {
        if ($this->viewService === null) {
            $this->viewService = new ViewService();
        }

        return $this->viewService;
    }

    /**
     * @return MessageService
     */
    public function getMessageService()
    {
        if ($this->messageService === null) {
            $this->messageService = new MessageService( $this->getViewService() );
        }

        return $this->messageService;
    }


}