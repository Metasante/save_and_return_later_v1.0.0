<?php

namespace Unisante\SaveAndReturnLater;

use \REDCap;

class SaveAndReturnLater extends \ExternalModules\AbstractExternalModule
{
    public function redcap_every_page_top($project_id)
    {
        if (PAGE === "surveys/index.php" && isset($_GET['__return'])) {

            $url = "https://metasante.ch/index.php/questionnaires";
            $hash = db_real_escape_string($_GET['s']);
            $sql = "SELECT s.record FROM redcap_surveys_response s, redcap_surveys_participants p where p.hash = '$hash' and s.participant_id = p.participant_id LIMIT 1;";
            $query = db_query($sql);
            while($row = db_fetch_assoc($query)){
                $record_id =  $row['record'];
            }
            if ($record_id) {
                $params = [
                    'project_id' => $project_id,
                    'return_format' => 'json',
                    'records' => [$record_id],
                ];
                $record = json_decode(REDCap::getData($params));
                foreach ($record as $field) {
                    if (strpos($field->redcap_event_name, 'arm_4') !== false) {
                        $url = "https://yverdon.metasante.ch/index.php/questionnaires";
                    }
                }
            }

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
                        location.href = "<?php echo $url; ?>";

                    })

                });
            </script> <?php
        }
    }

    public function redirect($project_id, $record_id)
    {
        $url = "https://metasante.ch/index.php/questionnaires";
        $params = [
            'project_id' => $project_id,
            'return_format' => 'json',
            'records' => [$record_id],
        ];
        $record = json_decode(REDCap::getData($params));
        foreach ($record as $field) {
            if (strpos($field->redcap_event_name, 'arm_4') !== false) {
                $url = "https://yverdon.metasante.ch/index.php/questionnaires";
            }
        }
        header("Location: $url");
        $this->exitAfterHook();
    }
}
