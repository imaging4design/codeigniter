<?php
// profiler.php
class MY_Profiler
{
    private $CI;
    
    public function enable()
    {
        $this->CI =& get_instance();
        
        $this->CI->output->enable_profiler(TRUE);
    }
}  