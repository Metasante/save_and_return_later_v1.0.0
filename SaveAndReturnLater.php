<?php

namespace Unisante\SaveAndReturnLater;


class SaveAndReturnLater extends \ExternalModules\AbstractExternalModule
{
    public function redcap_every_page_top($project_id)
    {
        if (PAGE === "surveys/index.php" && isset($_GET['__return'])) {

          print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$this->getUrl("style.css")."\" media=\"screen\">"; ?>



          <script type = "text/javascript">
            $(document).ready(function(){

                //Hide existing fields (email, return code)
                  $(document.querySelector("#return_instructions > div:nth-child(2)")).remove();
                  $(document.querySelector("#return_instructions > div:nth-child(2)")).remove();
                  $(document.querySelector("#return_continue_form > b")).remove();

                //Replace text of #provideEmail div
                $('#provideEmail').html("");

                //Append button which allows to return to instruments
                $( "#return_instructions" ).append('<button class = "jqbutton" id="redirect_to_instruments">Retourner aux questionnaires</button>');

                //On click, return to instruments page
                $("#redirect_to_instruments").click(function(){
                    location.href = "https://metasante.ch/index.php/questionnaires";

                })



            });


        </script>
     <?php
        }
    }
}
