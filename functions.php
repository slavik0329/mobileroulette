<?

    function cleantxt($written)
    {
    $written=addslashes($written);
    $written=ereg_replace("<.+>", "", $written);
    return $written;
    }
   
    
    

?>