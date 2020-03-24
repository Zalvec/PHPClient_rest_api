<?php


class ViewService
{
    /* Deze functie laadt de opgegeven template */
    function LoadTemplate( $name )
    {
        if ( file_exists("$name.html") ) return file_get_contents("$name.html");
        if ( file_exists("template/$name.html") ) return file_get_contents("template/$name.html");
        if ( file_exists("../template/$name.html") ) return file_get_contents("../template/$name.html");
    }

    function ReplaceTasks( $tasks, $template) {
        $returnvalue = "";

        foreach ( $tasks as $task) {
            $content = $template;

            $content = str_replace("@@taa_id@@", $task->getId(), $content);
            $content = str_replace("@@taa_datum@@", $task->getDatum(), $content);
            $content = str_replace("@@taa_omschr@@", $task->getOmschr(), $content);

            $returnvalue .= $content;
        }
        return $returnvalue;
    }

    /* Deze functie laadt de <head> sectie */
    function BasicHead($folderpath,  $css = "" )
    {
        $str_stylesheets = "";
        if ( is_array($css))
        {
            foreach( $css as $stylesheet )
            {
                $str_stylesheets .= '<link rel="stylesheet" href="' . $folderpath . 'css/' . $stylesheet . '">' ;
            }
        }

        $data = array("stylesheets" => $str_stylesheets );
        $template = $this->LoadTemplate("basic_head");
        print $this->ReplaceContentOneRow($data, $template);

        $_SESSION["head_printed"] = true;
    }

    /* Deze functie voegt data en template samen en print het resultaat */
    function ReplaceContentOneRow( $row, $template_html )
    {
        //replace fields with values in template
        $content = $template_html;
        foreach($row as $field => $value)
        {
            $content = str_replace("@@$field@@", $value, $content);
        }

        return $content;
    }
}