<?php
    include_once('./model/mRequest.php');
    class cRequest {
        public function cDeleteRq($RequestID) {
            $p = new mRequest();
            return $p->mDeleteRq($RequestID);
        }
    }
?>
