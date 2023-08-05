<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "config.php";
include_once "system_lib.php";

#Costanti
Class AA_Sier_Const extends AA_Const
{
    const AA_USER_FLAG_SIER="sier";

    //percorso pubblicazione provvedimenti
    const AA_SIER_ALLEGATI_PATH="/sier/allegati";
    const AA_SIER_ALLEGATI_PUBLIC_PATH="/pubblicazioni/sier/docs.php";
}

#Classe oggetto elezioni
Class AA_Sier extends AA_Object_V2
{
    //tabella dati db
    const AA_DBTABLE_DATA="aa_sier_data";
    const AA_ALLEGATI_DB_TABLE="aa_sier_allegati";

    //Funzione di cancellazione
    protected function DeleteData($idData = 0, $user = null)
    {
        if(!$this->IsValid() || $this->IsReadOnly() || $idData == 0) return false;

        if($idData != $this->nId_Data && $idData != $this->nId_Data_Rev) return false;

        //Cancella tutti gli allegati
        foreach($this->GetAllegati($idData) as $curAllegato)
        {
            if(!$this->DeleteAllegato($curAllegato,$user))
            {
                return false;
            }
        }

        return parent::DeleteData($idData,$user);
    }

    //Funzione di clonazione dei dati
    protected function CloneData($idData = 0, $user = null)
    {
        if(!$this->IsValid() || $this->IsReadOnly()) return 0;
        
        $newIdData=parent::CloneData($idData,$user);

        return $newIdData;
    }

    //Costruttore
    public function __construct($id=0, $user=null)
    {
        //data table
        $this->SetDbDataTable(static::AA_DBTABLE_DATA);

        //Db data binding
        $this->SetBind("Estremi","estremi_atto");
        $this->SetBind("AnnoRiferimento","anno_rif");
        $this->SetBind("Tipo","tipo");
        $this->SetBind("Contraente","contraente");
        $this->SetBind("Modalita","modalita");

        //Valori iniziali
        $this->SetProp("IdData",0);
        $this->SetProp("Modalita",0);

        //disabilita la revisione
        $this->EnableRevision(false);

        //chiama il costruttore genitore
        parent::__construct($id,$user,false);

        //Carica i dati dell'oggetto
        if($this->bValid && $this->nId > 0)
        {
            if(!$this->LoadData($user))
            {
                $this->bValid=false;
            }
        }
    }

    //funzione di ricerca
    static public function Search($params=array(),$user=null)
    {
        //Verifica utente
        if($user instanceof AA_User)
        {
            if(!$user->isCurrentUser())
            {
                $user=AA_User::GetCurrentUser();
            }
        }
        else $user=AA_User::GetCurrentUser();

        //---------local checks-------------
        $params['class']="AA_Sier";
        //----------------------------------

        return parent::Search($params,$user);
    }

    //Funzione di verifica dei permessi
    public function GetUserCaps($user=null)
    {
        //Verifica utente
        if($user instanceof AA_User)
        {
            if(!$user->isCurrentUser())
            {
               $user=AA_User::GetCurrentUser();
            }
        }
        else $user=AA_User::GetCurrentUser();

        $perms=parent::GetUserCaps($user);

        //------------local checks---------------

        //Se l'utente non ha il flag può al massimo visualizzare la scheda
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0 && !$user->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $perms = AA_Const::AA_PERMS_READ;
        }
        //---------------------------------------

        //Se l'utente ha il flag e può modificare la scheda allora può fare tutto
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0 && $user->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $perms = AA_Const::AA_PERMS_ALL;
        }
        //---------------------------------------

        return $perms;
    }

    static public function AddNew($object=null,$user=null,$bSaveData=true)
    {
        //Verifica utente
        if($user instanceof AA_User)
        {
            if(!$user->isCurrentUser())
            {
               $user=AA_User::GetCurrentUser();
            }
        }
        else $user=AA_User::GetCurrentUser();

        //-------------local checks---------------------
        $bStandardCheck=false; //disable standard checks
        $bSaveData=true; //enable save data

        //Chi non ha il flag non può inserire nuovi elementi
        if(!$user->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            AA_Log::Log(__METHOD__." - L'utente corrente: ".$user->GetUserName()." non ha i permessi per inserire nuovi elementi.",100);
            return false;
        }

        //Verifica validità oggetto
        if(!($object instanceof AA_Sier))
        {
            AA_Log::Log(__METHOD__." - Errore: oggetto non valido (".print_r($object,true).").",100);
            return false;
        }
        //----------------------------------------------

        return parent::AddNew($object,$user,$bSaveData);
    }

    //Restituisce un allegato esistente
    public function GetAllegato($id=null, $user=null)
    {
        AA_Log::Log(__METHOD__."()");

        if(!$this->isValid())
        {
                AA_Log::Log(__METHOD__." - oggetto non valido.", 100,false,true);
                return null;            
        }
        
        //Verifica utente
        if($user==null || !$user->isValid() || !$user->isCurrentUser()) 
        {
            $user=AA_User::GetCurrentUser();
        
            if($user==null || !$user->isValid() || !$user->isCurrentUser())
            {
                AA_Log::Log(__METHOD__." - utente non valido.", 100,false,true);
                return null;
            }
        }

        //Verifica Flags
        if(($this->GetUserCaps($user) & AA_Const::AA_PERMS_READ)==0)
        {
            AA_Log::Log(__METHOD__." - l'utente corrente non ha accesso all'oggetto.", 100,false,true);
            return null;
        }
        
        $id_sier=$this->nId_Data;
        if($this->nId_Data_Rev > 0)
        {
            $id_sier=$this->nId_Data_Rev;
        }

        $query="SELECT * FROM ".AA_Sier::AA_ALLEGATI_DB_TABLE." WHERE id_sier='".$id_sier."'";
        $query.=" AND id='".addslashes($id)."' LIMIT 1";
        
        $db= new AA_Database();
        
        if(!$db->Query($query))
        {
            AA_Log::Log(__METHOD__." - Errore nella query: ".$query, 100,false,true);
            return null;            
        }
        
        if($db->GetAffectedRows() > 0)
        {
            $rs=$db->GetResultSet();
            $object=new AA_SierAllegati($rs[0]['id'],$id_sier,$rs[0]['estremi'],$rs[0]['url']);
            
            return $object;
        }
        
        return null;
    }
    

    //Aggiunge un nuovo allegato
    public function AddNewAllegato($allegato=null, $file="", $user=null)
    {
        AA_Log::Log(__METHOD__."()");

        if(!$this->isValid())
        {
                AA_Log::Log(__METHOD__." - provvedimento non valido.", 100,false,true);
                return false;            
        }
        
        //Verifica utente
        if($user==null || !$user->isValid() || !$user->isCurrentUser()) 
        {
            $user=AA_User::GetCurrentUser();
        
            if($user==null || !$user->isValid() || !$user->isCurrentUser())
            {
                AA_Log::Log(__METHOD__." - utente non valido.", 100,false,true);
                return false;
            }
        }

        //Verifica Flags
        if(($this->GetUserCaps($user) & AA_Const::AA_PERMS_WRITE)==0)
        {
            AA_Log::Log(__METHOD__." - l'utente corrente non può modificare il provvedimento.", 100,false,true);
            return false;
        }

        if(!($allegato instanceof AA_SierAllegati))
        {
            AA_Log::Log(__METHOD__." - Allegato non valido.", 100,false,true);
            return false;
        }
        
        $this->IsChanged();

        //Aggiorna l'elemento e lo versiona se necessario
        if(!$this->Update($user,true, "Aggiunta nuovo allegato: ".$allegato->GetEstremi()))
        {
            return false;
        }

        $allegato->SetIdProvvedimento($this->nId_Data);
        if($this->nId_Data_Rev > 0)
        {
            $allegato->SetIdProvvedimento($this->nId_Data_Rev);
        }

        $query="INSERT INTO ".static::AA_ALLEGATI_DB_TABLE." SET id_sier='".$allegato->GetIdProvvedimento()."'";
        $query.=", url='".addslashes($allegato->GetUrl())."'";
        $query.=", estremi='".addslashes($allegato->GetEstremi())."'";
        
        $db= new AA_Database();
        
        //AA_Log::Log(__METHOD__." - query: ".$query, 100);
        
        if(!$db->Query($query))
        {
            AA_Log::Log(__METHOD__." - Errore nella query: ".$query, 100,false,true);
            return false;            
        }
        
        $new_id=$db->GetLastInsertId();
        
        if($file !="")
        {
            if(is_uploaded_file($file))
            {
                if(!move_uploaded_file($file,AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf"))
                {
                    AA_Log::Log(__METHOD__." - Errore durante il salvataggio del file: ".AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf", 100,false,true);
                    return false;
                }
            }
            else 
            {   
                if(!rename($file,AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf"))
                {
                    AA_Log::Log(__METHOD__." - Errore durante il salvataggio del file", 100);
                    return false;
                }
            }
        }
        
        return true;
    }

    //Aggiorna un allegato esistente
    public function UpdateAllegato($allegato=null, $file="", $user=null)
    {
        AA_Log::Log(__METHOD__."()");

        if(!$this->isValid())
        {
                AA_Log::Log(__METHOD__." - provvedimento non valido.", 100,false,true);
                return false;            
        }
        
        //Verifica utente
        if($user==null || !$user->isValid() || !$user->isCurrentUser()) 
        {
            $user=AA_User::GetCurrentUser();
        
            if($user==null || !$user->isValid() || !$user->isCurrentUser())
            {
                AA_Log::Log(__METHOD__." - utente non valido.", 100,false,true);
                return false;
            }
        }

        //Verifica Flags
        if(($this->GetUserCaps($user) & AA_Const::AA_PERMS_WRITE)==0)
        {
            AA_Log::Log(__METHOD__." - l'utente corrente non può modificare il provvedimento.", 100,false,true);
            return false;
        }

        if(!($allegato instanceof AA_SierAllegati))
        {
            AA_Log::Log(__METHOD__." - Allegato non valido.", 100,false,true);
            return false;
        }

        $this->IsChanged();

        //Aggiorna l'elemento e lo versiona se necessario
        if(!$this->Update($user,true, "Aggiornamento allegato: ".$allegato->GetEstremi()))
        {
            return false;
        }

        $allegato->SetIdProvvedimento($this->nId_Data);
        if($this->nId_Data_Rev > 0)
        {
            $allegato->SetIdProvvedimento($this->nId_Data_Rev);
        }
        
        $query="UPDATE ".static::AA_ALLEGATI_DB_TABLE." SET id_sier='".$allegato->GetIdProvvedimento()."'";
        $query.=", url='".addslashes($allegato->GetUrl())."'";
        $query.=", estremi='".addslashes($allegato->GetEstremi())."'";
        $query.=" WHERE id='".addslashes($allegato->GetId())."' LIMIT 1";
        
        $db= new AA_Database();
        
        //AA_Log::Log(__METHOD__." - query: ".$query, 100);
        
        if(!$db->Query($query))
        {
            AA_Log::Log(__METHOD__." - Errore nella query: ".$query, 100,false,true);
            return false;            
        }
        
        $new_id=$allegato->GetId();
        
        if($file !="")
        {
            if(is_uploaded_file($file))
            {
                if(!move_uploaded_file($file,AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf"))
                {
                    AA_Log::Log(__METHOD__." - Errore durante il salvataggio del file: ".AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf", 100,false,true);
                    return false;
                }
            }
            else 
            {   
                if(!rename($file,AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf"))
                {
                    AA_Log::Log(__METHOD__." - Errore durante il salvataggio del file", 100);
                    return false;
                }
            }
        }
        else
        {
            //Rimuove il file precedentemente caricato
            if(is_file(AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf"))
            {
                if(!unlink(AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf"))
                {
                    AA_Log::Log(__METHOD__." - Errore durante l'eliminazione del file precedente: ".AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$new_id.".pdf", 100);
                }
            }
        }

        return true;
    }

    //Elimina un allegato esistente
    public function DeleteAllegato($allegato=null, $user=null)
    {
        AA_Log::Log(__METHOD__."()");

        if(!$this->isValid())
        {
                AA_Log::Log(__METHOD__." - provvedimento non valido.", 100,false,true);
                return false;            
        }
        
        //Verifica utente
        if($user==null || !$user->isValid() || !$user->isCurrentUser()) 
        {
            $user=AA_User::GetCurrentUser();
        
            if($user==null || !$user->isValid() || !$user->isCurrentUser())
            {
                AA_Log::Log(__METHOD__." - utente non valido.", 100,false,true);
                return false;
            }
        }

        //Verifica Flags
        if(($this->GetUserCaps($user) & AA_Const::AA_PERMS_WRITE)==0)
        {
            AA_Log::Log(__METHOD__." - l'utente corrente non può modificare il provvedimento.", 100,false,true);
            return false;
        }

        if(!($allegato instanceof AA_SierAllegati))
        {
            AA_Log::Log(__METHOD__." - Allegato non valido.", 100,false,true);
            return false;
        }

        $this->IsChanged();

        //Aggiorna l'elemento e lo versiona se necessario
        if(!$this->Update($user,true, "Rimozione allegato: ".$allegato->GetEstremi()))
        {
            return false;
        }

        $allegato->SetIdProvvedimento($this->nId_Data);
        if($this->nId_Data_Rev > 0)
        {
            $allegato->SetIdProvvedimento($this->nId_Data_Rev);
        }
        
        $query="DELETE FROM ".static::AA_ALLEGATI_DB_TABLE;
        $query.=" WHERE id='".addslashes($allegato->GetId())."'";
        if($this->nId_Data_Rev > 0)
        {
            $query.=" AND id_sier = in (".$this->nId_Data_Rev.",".$this->nId_Data."')";
        }
        else $query.=" AND id_sier = '".$this->nId_Data."'";
        
        $query.="LIMIT 1";
        
        $db= new AA_Database();
        
        //AA_Log::Log(__METHOD__." - query: ".$query, 100);
        
        if(!$db->Query($query))
        {
            AA_Log::Log(__METHOD__." - Errore nella query: ".$query, 100,false,true);
            return false;            
        }
        
        $file=$allegato->GetFilePath();
        
        if(is_file($file))
        {
            if(!unlink($file))
            {
                AA_Log::Log(__METHOD__." - Errore durante la rimozione del file: ".$file, 100,false,true);
                return false;
            }
        }

        return true;
    }

    //Restituisce gli allegati
    public function GetAllegati($idData=0)
    {
        AA_Log::Log(__METHOD__."()");

        if(!$this->IsValid())
        {
            AA_Log::Log(__METHOD__."() - oggetto non valido.");

            return array();
        }

        if($idData==0 || $idData == "") $idData=$this->nId_Data;

        if($idData != $this->nId_Data && $idData !=$this->nId_Data_Rev && $idData > 0)
        {
            $idData=$this->nId_Data;
            if($this->nId_Data_Rev > 0)
            {
                $idData=$this->nId_Data_Rev;
            }
        }

        //Impostazione dei parametri
        $query="SELECT * from ".AA_Sier::AA_ALLEGATI_DB_TABLE." WHERE";

        $query.=" id_sier='".$idData."'";
        
        $query.= " ORDER by id DESC";

        $db=new AA_Database();
        if(!$db->Query($query))
        {
            AA_Log::Log(__METHOD__." - errore nella query: ".$query,100);
            return array();
        }

        $result=array();

        $rs=$db->GetResultSet();
        foreach($rs as $curRec)
        {   
            $allegato=new AA_SierAllegati($curRec['id'],$idData,$curRec['estremi'],$curRec['url']);
            $result[$curRec['id']]=$allegato;
        }

        return $result;
    }
}

#Classe per il modulo art23 - provvedimenti dirigenziali e accordi
Class AA_SierModule extends AA_GenericModule
{
    const AA_UI_PREFIX="AA_Sier";

    //Id modulo
    const AA_ID_MODULE="AA_MODULE_PROVVEDIMENTI";

    //main ui layout box
    const AA_UI_MODULE_MAIN_BOX="AA_Sier_module_layout";

    const AA_MODULE_OBJECTS_CLASS="AA_Sier";

    //Task per la gestione dei dialoghi standard
    const AA_UI_TASK_PUBBLICATE_FILTER_DLG="GetSierPubblicateFilterDlg";
    const AA_UI_TASK_BOZZE_FILTER_DLG="GetSierBozzeFilterDlg";
    const AA_UI_TASK_REASSIGN_DLG="GetSierReassignDlg";
    const AA_UI_TASK_PUBLISH_DLG="GetSierPublishDlg";
    const AA_UI_TASK_TRASH_DLG="GetSierTrashDlg";
    const AA_UI_TASK_RESUME_DLG="GetSierResumeDlg";
    const AA_UI_TASK_DELETE_DLG="GetSierDeleteDlg";
    const AA_UI_TASK_ADDNEW_DLG="GetSierAddNewDlg";
    const AA_UI_TASK_MODIFY_DLG="GetSierModifyDlg";
    //------------------------------------

    public function __construct($user=null,$bDefaultSections=true)
    {
        $this->SetId("AA_MODULE_PROVVEDIMENTI");
        
        parent::__construct($user,$bDefaultSections);
        
        #--------------------------------Registrazione dei task-----------------------------
        $taskManager=$this->GetTaskManager();
        
        //Dialoghi di filtraggio
        $taskManager->RegisterTask("GetSierPubblicateFilterDlg");
        $taskManager->RegisterTask("GetSierBozzeFilterDlg");

        //provvedimenti
        $taskManager->RegisterTask("GetSierModifyDlg");
        $taskManager->RegisterTask("GetSierAddNewDlg");
        $taskManager->RegisterTask("GetSierTrashDlg");
        $taskManager->RegisterTask("TrashSier");
        $taskManager->RegisterTask("GetSierDeleteDlg");
        $taskManager->RegisterTask("DeleteSier");
        $taskManager->RegisterTask("GetSierResumeDlg");
        $taskManager->RegisterTask("ResumeSier");
        $taskManager->RegisterTask("GetSierReassignDlg");
        $taskManager->RegisterTask("GetSierPublishDlg");
        $taskManager->RegisterTask("ReassignSier");
        $taskManager->RegisterTask("AddNewSier");
        $taskManager->RegisterTask("UpdateSier");
        $taskManager->RegisterTask("PublishSier");

        //Allegati
        $taskManager->RegisterTask("GetSierAddNewAllegatoDlg");
        $taskManager->RegisterTask("AddNewSierAllegato");
        $taskManager->RegisterTask("GetSierModifyAllegatoDlg");
        $taskManager->RegisterTask("UpdateSierAllegato");
        $taskManager->RegisterTask("GetSierTrashAllegatoDlg");
        $taskManager->RegisterTask("DeleteSierAllegato");

        //template dettaglio
        $this->SetSectionItemTemplate(static::AA_ID_SECTION_DETAIL,array(
            array("id"=>static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_Generale_Tab", "value"=>"Generale","tooltip"=>"Dati generali","template"=>"TemplateSierDettaglio_Generale_Tab"),
            //array("id"=>static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_Canoni_Tab", "value"=>"Canoni","tooltip"=>"Canoni legati all'immobile","template"=>"TemplateSierDettaglio_Canoni_Tab")
        ));
    }
    
    //istanza
    protected static $oInstance=null;
    
    //Restituisce l'istanza corrente
    public static function GetInstance($user=null)
    {
        if(self::$oInstance==null)
        {
            self::$oInstance=new AA_SierModule($user);
        }
        
        return self::$oInstance;
    }
    
    //Layout del modulo
    function TemplateLayout()
    {
        return $this->TemplateGenericLayout();
    }
    
    //Template placeholder
    public function TemplateSection_Placeholder()
    {
        return $this->TemplateGenericSection_Placeholder();
    }
    
    //Template pubblicate content
    public function TemplateSection_Pubblicate($params=array())
    {
        $bCanModify=false;
        if($this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $bCanModify=true;
        }

        $content=$this->TemplateGenericSection_Pubblicate($params,$bCanModify);
        return $content->toObject();
    }

    //Restituisce la lista delle schede pubblicate (dati)
    public function GetDataSectionPubblicate_List($params=array())
    {
        return $this->GetDataGenericSectionPubblicate_List($params,"GetDataSectionPubblicate_CustomFilter","GetDataSectionPubblicate_CustomDataTemplate");
    }

    //Personalizza il filtro delle schede pubblicate per il modulo corrente
    protected function GetDataSectionPubblicate_CustomFilter($params = array())
    {
       //Tipo
       if($params['Tipo'] > 0)
       {
           $params['where'][]=" AND ".AA_Sier::AA_DBTABLE_DATA.".tipo = '".addslashes($params['Tipo'])."'";
       }

        //anno rif
        if($params['AnnoRiferimento'] > 0)
        {
            $params['where'][]=" AND ".AA_Sier::AA_DBTABLE_DATA.".anno_rif = '".addslashes($params['AnnoRiferimento'])."'";
        }

        //Estremi
        if($params['Estremi'] !="")
        {
            $params['where'][]=" AND ".AA_Sier::AA_DBTABLE_DATA.".estremi_atto like '%".addslashes($params['Estremi'])."%'";
        }
       
       return $params;
    }

     //Personalizza il template dei dati delle schede pubblicate per il modulo corrente
     protected function GetDataSectionPubblicate_CustomDataTemplate($data = array(),$object=null)
     {
        if($object instanceof AA_Sier)
        {

            /*$data['pretitolo']=$object->GetTipo();
            if($object->GetTipo(true) != AA_Sier_Const::AA_TIPO_PROVVEDIMENTO_ACCORDO)
            {
                $data['tags']="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$object->GetModalita()."</span>";
            } 
            else
            {
                $tag="";
                foreach(explode("|",$object->GetProp('Contraente')) as $value)
                {
                    $tag.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$value."</span>";
                }
                $data['tags']=$tag;
            } */
        }
        
        return $data;
     }

    //Template sezione bozze (da specializzare)
    public function TemplateSection_Bozze($params=array())
    {
        $is_enabled= false;
       
        if($this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $is_enabled=true;
        }
        
        if(!$is_enabled)
        {
            $content = new AA_JSON_Template_Template(static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX,
                array(
                "type"=>"clean",
                "update_time"=>Date("Y-m-d H:i:s"),
                "name"=>"Schede in bozza",
                "template"=>"L'utente corrente non è abilitato alla visualizzazione della sezione."
            ));
        
            return $content;
        }

        $content=$this->TemplateGenericSection_Bozze($params,false);
        return $content->toObject();
    }
    
    //Restituisce i dati delle bozze
    public function GetDataSectionBozze_List($params=array())
    {
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            AA_Log::Log(__METHOD__." - ERRORE: l'utente corrente: ".$this->oUser->GetUserName()." non è abilitato alla visualizzazione delle bozze.",100);
            return array();
        }

        return $this->GetDataGenericSectionBozze_List($params,"GetDataSectionBozze_CustomFilter","GetDataSectionBozze_CustomDataTemplate");
    }

    //Personalizza il filtro delle bozze per il modulo corrente
    protected function GetDataSectionBozze_CustomFilter($params = array())
    {
        //Tipo
        if($params['Tipo'] > 0)
        {
            $params['where'][]=" AND ".AA_Sier::AA_DBTABLE_DATA.".tipo = '".addslashes($params['Tipo'])."'";
        }

        //anno rif
        if($params['AnnoRiferimento'] > 0)
        {
            $params['where'][]=" AND ".AA_Sier::AA_DBTABLE_DATA.".anno_rif = '".addslashes($params['AnnoRiferimento'])."'";
        }

        //Estremi
        if($params['Estremi'] !="")
        {
            $params['where'][]=" AND ".AA_Sier::AA_DBTABLE_DATA.".estremi_atto like '%".addslashes($params['Estremi'])."%'";
        }

        return $params;
    }

    //Personalizza il template dei dati delle bozze per il modulo corrente
    protected function GetDataSectionBozze_CustomDataTemplate($data = array(),$object=null)
    {
        
        if($object instanceof AA_Sier)
        {

            /*$data['pretitolo']=$object->GetTipo();
            if($object->GetTipo(true) != AA_Sier_Const::AA_TIPO_PROVVEDIMENTO_ACCORDO)
            {
                $data['tags']="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$object->GetModalita()."</span>";
            } 
            else
            {
                $tag="";
                foreach(explode("|",$object->GetProp('Contraente')) as $value)
                {
                    $tag.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$value."</span>";
                }
                $data['tags']=$tag;
            }*/
        }
        
        return $data;
    }
    
    //Template organismo publish dlg
    public function Template_GetSierPublishDlg($params)
    {
        //lista organismi da ripristinare
        if($params['ids'])
        {
            $ids= json_decode($params['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Sier($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_PUBLISH)>0)
                {
                    $ids_final[$curId]=$organismo->GetDescr();
                    unset($organismo);
                }
            }

            $id=$this->id."_PublishDlg";

            //Esiste almeno un organismo che può essere pubblicato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $forms_data['ids']=json_encode(array_keys($ids_final));
                
                $wnd=new AA_GenericFormDlg($id, "Pubblica", $this->id, $forms_data,$forms_data);
               
                //Disattiva il pulsante di reset
                $wnd->EnableResetButton(false);

                //Imposta il nome del pulsante di conferma
                $wnd->SetApplyButtonName("Procedi");

                $tabledata=array();
                foreach($ids_final as $id_org=>$desc)
                {
                    $tabledata[]=array("Denominazione"=>$desc);
                }

                if(sizeof($ids_final) > 1) $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"I seguenti ".sizeof($ids_final)." provvedimenti/accordi verranno pubblicati, vuoi procedere?")));
                else $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente provvedimento/accordo verrà pubblicato, vuoi procedere?")));

                $table=new AA_JSON_Template_Generic($id."_Table", array(
                    "view"=>"datatable",
                    "scrollX"=>false,
                    "autoConfig"=>true,
                    "select"=>false,
                    "data"=>$tabledata
                ));

                $wnd->AddGenericObject($table);

                $wnd->EnableCloseWndOnSuccessfulSave();
                $wnd->enableRefreshOnSuccessfulSave();
                $wnd->SetSaveTask('PublishSier');
            }
            else
            {
                $wnd=new AA_GenericWindowTemplate($id, "Avviso",$this->id);
                $wnd->AddView(new AA_JSON_Template_Template("",array("css"=>array("text-align"=>"center"),"template"=>"<p>L'utente corrente non ha i permessi per pubblicare i provvedimenti/accordi selezionati.</p>")));
                $wnd->SetWidth(380);
                $wnd->SetHeight(115);
            }
            
            return $wnd;
        }
    }
    
    //Template organismo delete dlg
    public function Template_GetSierDeleteDlg($params)
    {
        return $this->Template_GetGenericObjectDeleteDlg($params,"DeleteSier");
    }
        
    //Template dlg addnew provvedimenti
    public function Template_GetSierAddNewDlg()
    {
        $id=$this->GetId()."_AddNew_Dlg";
        
        $form_data=array();
        
        $anno_fine=Date('Y');
        $form_data['AnnoRiferimento']=$anno_fine;
        $form_data['Modalita']=0;
        $form_data['Contraente']="n.d.";
        
        $form_data['Tipo']=-1;
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi un nuovo provvedimento/accordo", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(920);
        $wnd->SetHeight(640);
        $wnd->EnableValidation();
              
        //tipo
        /*$selectionChangeEvent="try{AA_MainApp.utils.getEventHandler('onTipoProvSelectChange','".$this->id."','".$this->id."_Field_Tipo')}catch(msg){console.error(msg)}";
        $options=array();
        foreach(AA_Sier_Const::GetListaTipologia() as $key=>$value)
        {
            $options[]=array("id"=>$key,"value"=>$value);
        }
        $wnd->AddSelectField("Tipo","Tipo",array("required"=>true,"validateFunction"=>"IsSelected","customInvalidMessage"=>"*Occorre selezionare il tipo di provvedimento.","bottomLabel"=>"*Indicare il tipo di provvedimento","placeholder"=>"Scegli una voce...","options"=>$options,"on"=>array("onChange"=>$selectionChangeEvent)));
        
        //modalità
        $options=array();
        foreach(AA_Sier_Const::GetListaModalita() as $key=>$value)
        {
            $options[]=array("id"=>$key,"value"=>$value);
        }
        $wnd->AddSelectField("Modalita","Modalità",array("hidden"=>"true", "required"=>"true","validateFunction"=>"IsSelected","customInvalidMessage"=>"*Occorre selezionare il tipo di modalità di scelta del contraente.","bottomLabel"=>"*Indicare il tipo di modalità","placeholder"=>"Scegli una voce...","options"=>$options,"gravity"=>100));

        //Contraente
        $wnd->AddTextField("Contraente","Stipulanti",array("hidden"=>"true", "required"=>true,"bottomLabel"=>"*Inserisci la denominazione degli enti esterni stipulanti (utilizzare il carattere | \"pipe\" come separatore).", "placeholder"=>"Denominazione degli enti esterni stipulanti...","gravity"=>100));

        $anno_start=($anno_fine-10);
        //anno riferimento
        $options=array();
        for($i=$anno_fine; $i>=$anno_start; $i--)
        {
            $options[]=array("id"=>$i, "value"=>$i);
        }
        $wnd->AddSelectField("AnnoRiferimento","Anno",array("required"=>true,"validateFunction"=>"IsSelected","bottomLabel"=>"*Indicare l'anno di riferimento.", "placeholder"=>"Scegli l'anno di riferimento.","options"=>$options,"value"=>Date('Y')));*/

        //Nome
        $wnd->AddTextField("nome","Oggetto",array("required"=>true, "bottomLabel"=>"*Inserisci l'oggetto del provvedimento.", "placeholder"=>"Oggetto del provvedimento..."));

        //Descrizione
        $label="Descrizione";
        $wnd->AddTextareaField("descrizione",$label,array("bottomLabel"=>"*Breve descrizione del provvedimento.", "placeholder"=>"Inserisci qui la descrizione del provvedimento..."));

        //estremi
        $wnd->AddTextField("Estremi","Estremi",array("required"=>true, "bottomLabel"=>"*Inserisci gli estremi dell'atto.", "placeholder"=>"Estremi dell'atto..."));

        $wnd->EnableCloseWndOnSuccessfulSave();

        $wnd->SetSaveTask("AddNewSier");
        
        return $wnd;
    }
    
    //Template dlg aggiungi allegato/link
    public function Template_GetSierAddNewAllegatoDlg($object=null)
    {
        $id=static::AA_UI_PREFIX."_GetSierAddNewAllegatoDlg";
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array();
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi allegato/link", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(480);

        //descrizione
        $wnd->AddTextField("estremi", "Descrizione", array("required"=>true,"bottomLabel" => "*Indicare una descrizione per l'allegato o il link", "placeholder" => "es. DGR ..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>30)));
        
        $section=new AA_FieldSet($id."_Section_Url","Inserire un'url oppure scegliere un file");
        $wnd->SetFileUploaderId($id."_Section_Url_FileUpload_Field");

        //url
        $section->AddTextField("url", "Url", array("validateFunction"=>"IsUrl","bottomLabel"=>"*Indicare un'URL sicura, es. https://www.regione.sardegna.it", "placeholder"=>"https://..."));
        
        $section->AddGenericObject(new AA_JSON_Template_Template("",array("type"=>"clean","template"=>"<hr/>","height"=>18)));

        //file
        $section->AddFileUploadField("NewAllegatoDoc","", array("validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti pdf (dimensione max: 2Mb).","accept"=>"application/pdf"));
        
        $wnd->AddGenericObject($section);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("AddNewSierAllegato");
        
        return $wnd;
    }

    //Template dlg aggiungi allegato/link
    public function Template_GetSierModifyAllegatoDlg($object=null,$allegato=null)
    {
        $id=static::AA_UI_PREFIX."_GetSierModifyAllegatoDlg";
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array();
        $form_data["estremi"]=$allegato->GetEstremi();
        $form_data["url"]=$allegato->GetUrl();
        
        $wnd=new AA_GenericFormDlg($id, "Modifica allegato/link", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(480);

        //descrizione
        $wnd->AddTextField("estremi", "Descrizione", array("required"=>true,"bottomLabel" => "*Indicare una descrizione per l'allegato o il link", "placeholder" => "es. DGR ..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>30)));
        
        
        $section=new AA_FieldSet($id."_Section_Url","Inserire un'url oppure scegliere un file");
        $wnd->SetFileUploaderId($id."_Section_Url_FileUpload_Field");

        //url
        $section->AddTextField("url", "Url", array("validateFunction"=>"IsUrl","bottomLabel"=>"*Indicare un'URL sicura, es. https://www.regione.sardegna.it", "placeholder"=>"https://..."));
        
        $section->AddGenericObject(new AA_JSON_Template_Template("",array("type"=>"clean","template"=>"<hr/>","height"=>18)));

        //file
        $section->AddFileUploadField("NewAllegatoDoc","", array("validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti pdf (dimensione max: 2Mb).","accept"=>"application/pdf"));
        
        $wnd->AddGenericObject($section);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_allegato"=>$allegato->GetId()));
        $wnd->SetSaveTask("UpdateSierAllegato");
        
        return $wnd;
    }

    //Template dlg trash allegato
    public function Template_GetSierTrashAllegatoDlg($object=null,$allegato=null)
    {
        $id=$this->id."_TrashProvvedimentoAllegato_Dlg";
        
        $form_data=array();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina allegato", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $url=$allegato->GetUrl();
        if($url =="") $url="file locale";
        $tabledata[]=array("estremi"=>$allegato->GetEstremi(),"url"=>$url);
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente allegato verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "columns"=>array(
              array("id"=>"estremi", "header"=>"Descrizione", "fillspace"=>true),
              array("id"=>"url", "header"=>"Url", "fillspace"=>true)
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("DeleteSierAllegato");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_allegato"=>$allegato->GetId()));
        
        return $wnd;
    }

    //Task Aggiungi allegato
    public function Task_AddNewSierAllegato($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $object=new AA_Sier($_REQUEST['id'], $this->oUser);
        
        if(!$object->isValid())
        {
            $task->SetError("Identificativo provvedimento non valido o permessi insufficienti. (".$_REQUEST['id'].")");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo provvedimento non valido o permessi insufficienti. (".$_REQUEST['id'].")</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if($object->IsReadOnly())
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare il provvedimento: ".$object->GetProp("estremi"));
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare il provvedimento: ".$object->GetProp("estremi")."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $file = AA_SessionFileUpload::Get("NewAllegatoDoc");
        
        if(!$file->isValid() && $_REQUEST['url'] == "")
        {   
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($file,true)." - ".print_r($_REQUEST,true),100);
            $task->SetError("Parametri non validi occorre indicare un url o un file.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Parametri non validi: occorre indicare un url o un file.</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
        
        $id_sier=$object->GetIdData();
        if($object->GetIdDataRev() > 0)
        {
            $id_sier=$object->GetIdDataRev();
        }
        
        //Se c'è un file uploadato l'url non viene salvata.
        if($file->isValid()) $_REQUEST['url']="";

        $allegato=new AA_SierAllegati(0,$id_sier,$_REQUEST['estremi'],$_REQUEST['url']);
        
        //AA_Log::Log(__METHOD__." - "."Provvedimento: ".print_r($provvedimento, true),100);
        
        if($file->isValid()) $filespec=$file->GetValue();
        else $filespec=array();
        
        if(!$object->AddNewAllegato($allegato, $filespec['tmp_name'], $this->oUser))
        {        
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio dell'allegato provvedimento. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Allegato caricato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Template dlg modify provvedimento
    public function Template_GetSierModifyDlg($object=null)
    {
        $id=$this->GetId()."_Modify_Dlg";
        if(!($object instanceof AA_Sier)) return new AA_GenericWindowTemplate($id, "Modifica i dati generali", $this->id);

        $form_data['id']=$object->GetID();
        $form_data['nome']=$object->GetName();
        $form_data['descrizione']=$object->GetDescr();

        foreach($object->GetDbBindings() as $prop=>$field)
        {
            $form_data[$prop]=$object->GetProp($prop);
        }
        
        $wnd=new AA_GenericFormDlg($id, "Modifica i dati generali", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(920);
        $wnd->SetHeight(640);
        
        //tipo
        /*
        $selectionChangeEvent="try{AA_MainApp.utils.getEventHandler('onTipoProvSelectChange','".$this->id."','".$this->id."_Field_Tipo')}catch(msg){console.error(msg)}";
        $options=array();
        foreach(AA_Sier_Const::GetListaTipologia() as $key=>$value)
        {
            $options[]=array("id"=>$key,"value"=>$value);
        }
        $wnd->AddSelectField("Tipo","Tipo",array("required"=>true,"validateFunction"=>"IsSelected","customInvalidMessage"=>"*Occorre selezionare il tipo di provvedimento.","bottomLabel"=>"*Indicare il tipo di provvedimento","placeholder"=>"Scegli una voce...","options"=>$options,"on"=>array("onChange"=>$selectionChangeEvent)));
        
        //modalità
        $options=array();
        foreach(AA_Sier_Const::GetListaModalita() as $key=>$value)
        {
            $options[]=array("id"=>$key,"value"=>$value);
        }
        $wnd->AddSelectField("Modalita","Modalità",array("hidden"=>"true", "required"=>"true","validateFunction"=>"IsSelected","customInvalidMessage"=>"*Occorre selezionare il tipo di modalità di scelta del contraente.","bottomLabel"=>"*Indicare il tipo di modalità","placeholder"=>"Scegli una voce...","options"=>$options,"gravity"=>100));*/

        //Contraente
        $wnd->AddTextField("Contraente","Stipulanti",array("hidden"=>"true", "required"=>true,"bottomLabel"=>"*Inserisci la denominazione degli enti esterni stipulanti (utilizzare il carattere | \"pipe\" come separatore).", "placeholder"=>"Denominazione degli enti esterni stipulanti...","gravity"=>100));        

        $anno_fine=Date('Y');
        $anno_start=($anno_fine-10);
        //anno riferimento
        $options=array();
        for($i=$anno_fine; $i>=$anno_start; $i--)
        {
            $options[]=array("id"=>$i, "value"=>$i);
        }
        $wnd->AddSelectField("AnnoRiferimento","Anno",array("required"=>true,"validateFunction"=>"IsSelected","bottomLabel"=>"*Indicare l'anno di riferimento.", "placeholder"=>"Scegli l'anno di riferimento.","options"=>$options,"value"=>Date('Y')));

        //Nome
        $wnd->AddTextField("nome","Oggetto",array("required"=>true, "bottomLabel"=>"*Inserisci l'oggetto del provvedimento.", "placeholder"=>"Oggetto del provvedimento..."));

        //Descrizione
        $label="Descrizione";
        $wnd->AddTextareaField("descrizione",$label,array("bottomLabel"=>"*Breve descrizione del provvedimento.", "placeholder"=>"Inserisci qui la descrizione del provvedimento..."));

        //estremi
        $wnd->AddTextField("Estremi","Estremi",array("required"=>true, "bottomLabel"=>"*Inserisci gli estremi dell'atto.", "placeholder"=>"Estremi dell'atto..."));

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("UpdateSier");
        
        return $wnd;
    }  

    //Template detail (da specializzare)
    public function TemplateSection_Detail($params)
    {
        //Gestione dei tab
        //$id=static::AA_UI_PREFIX."_Detail_Generale_Tab_".$params['id'];
        //$params['DetailOptionTab']=array(array("id"=>$id, "value"=>"Generale","tooltip"=>"Dati generali","template"=>"TemplateSierDettaglio_Generale_Tab"));
        
        return $this->TemplateGenericSection_Detail($params);
    }   
    
    //Template section detail, tab generale
    public function TemplateSierDettaglio_Generale_Tab($object=null)
    {
        $sectionTemplate=$this->GetSectionItemTemplate(static::AA_ID_SECTION_DETAIL);
        if(!is_array($sectionTemplate))
        {
            $id=static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_Generale_Tab_".date("Y-m-d_h:i:s");
        }
        else
        {
            $id=$sectionTemplate[0]['id'];
        }

        if(!($object instanceof AA_Sier)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));
        
        //$id=static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_Generale_Tab_".$object->GetId();
        $rows_fixed_height=50;

        $layout=$this->TemplateGenericDettaglio_Header_Generale_Tab($object,$id);

        //Descrizione
        $value=$object->GetDescr();
        if($value=="")$value="n.d.";
        $descr=new AA_JSON_Template_Template($id."_Descrizione",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Descrizione:","value"=>$value)
        ));

        //anno riferimento
        $value=$object->GetProp("AnnoRiferimento");
        if($value=="")$value="n.d.";
        $anno_rif=new AA_JSON_Template_Template($id."_AnnoRif",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Anno:","value"=>$value)
        ));
        
        //estremi
        $value= $object->GetProp("Estremi");
        if($value=="") $value="n.d.";
        $estremi=new AA_JSON_Template_Template($id."_Estremi",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Estremi atto:","value"=>$value)
        ));

        $modalita=null;
        $contraente=null;
        
        //prima riga
        $riga=new AA_JSON_Template_Layout($id."_FirstRow",array("height"=>$rows_fixed_height,"css"=>array("border-bottom"=>"1px solid #dadee0 !important")));
        $riga->AddCol($anno_rif);
        if($modalita) $riga->AddCol($modalita);
        if($contraente) $riga->AddCol($contraente);
        $riga->AddCol($estremi);
        $layout->AddRow($riga);
        
        //seconda riga
        //$riga=new AA_JSON_Template_Layout($id."_SecondRow",array("css"=>array("border-bottom"=>"1px solid #dadee0 !important","gravity"=>1)));
        //$riga->addCol($oggetto);
        //$layout->AddRow($riga);

        //terza riga
        $riga=new AA_JSON_Template_Layout($id."_ThirdRow",array("gravity"=>4));
        $riga->addCol($descr);
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)>0)
        {
            $riga->addCol($this->TemplateDettaglio_Allegati($object,$id,true));
        }
        else $riga->addCol($this->TemplateDettaglio_Allegati($object,$id));

        $layout->AddRow($riga);

        return $layout;
    }
    
    //Task Update Sier
    public function Task_UpdateSier($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento");
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente non ha i permessi di modifica dell'elemento</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        return $this->Task_GenericUpdateObject($task,$_REQUEST,true);   
    }
    
    //Task trash Sier
    public function Task_TrashSier($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $task->SetError("L'utente corrente non ha i permessi per cestinare l'elemento");
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente non ha i permessi per cestinare l'elemento</error>";
            $task->SetLog($sTaskLog);

            return false;
        }

        return $this->Task_GenericTrashObject($task,$_REQUEST);
    }
    
    //Task resume Sier
    public function Task_ResumeSier($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        return $this->Task_GenericResumeObject($task,$_REQUEST);
    }
    
    //Task publish Sier
    public function Task_PublishSier($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        return $this->Task_GenericPublishObject($task,$_REQUEST);
    }
    
    //Task reassign Sier
    public function Task_ReassignSier($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        return $this->Task_GenericReassignObject($task,$_REQUEST);
    }
    
    //Task delete Sier
    public function Task_DeleteSier($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        return $this->Task_GenericDeleteObject($task,$_REQUEST);
    }
    
    //Task Aggiungi provvedimenti
    public function Task_AddNewSier($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $task->SetError("L'utente corrente non ha i permessi per aggiungere nuovi elementi");
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente non ha i permessi per aggiungere nuovi elementi</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        return $this->Task_GenericAddNew($task,$_REQUEST);
    }

    //Task modifica provvedimento
    public function Task_GetSierModifyDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non può modifcare l'elemento.</error>";
            $task->SetLog($sTaskLog);

            return false;
        }

        $object= new AA_Sier($_REQUEST['id'],$this->oUser);
        if(!$object->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Elemento non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        else
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetSierModifyDlg($object)->toBase64();
            $sTaskLog.="</content>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task resume organismo
    public function Task_GetSierResumeDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per ripristinare elementi.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetGenericResumeObjectDlg($_REQUEST,"ResumeSier")->toBase64();
            $sTaskLog.="</content>";
            $task->SetLog($sTaskLog);
        
            return true;
        }    
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Identificativi non presenti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        return true;
    }
    
    //Task publish organismo
    public function Task_GetSierPublishDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per pubblicare elementi.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetGenericPublishObjectDlg($_REQUEST,"PublishSier")->toBase64();
            $sTaskLog.="</content>";
            $task->SetLog($sTaskLog);
        
            return true;
        }    
        else
        {
            // to do lista da recuperare con filtro
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Identificativi non presenti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        return true;
    }
    
    //Task Riassegna provvedimenti
    public function Task_GetSierReassignDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
         if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per riassegnare elementi.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetGenericReassignObjectDlg($_REQUEST,"ReassignSier")->toBase64();
            $sTaskLog.="</content>";
            
            $task->SetLog($sTaskLog);
        
            return true;
        }    
        else
        {
            // to do lista da recuperare con filtro
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Identificativi non presenti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        return true;
    }
    
    //Task elimina organismo
    public function Task_GetSierTrashDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per cestinare/eliminare elementi di questo tipo.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetGenericObjectTrashDlg($_REQUEST,"TrashSier")->toBase64();
            $sTaskLog.="</content>";
            
            $task->SetLog($sTaskLog);
        
            return true;
        }    
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Identificativi non presenti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }

        return true;
    }
       
    //Task dialogo elimina provvedimenti
    public function Task_GetSierDeleteDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per cestinare/eliminare organismi.</error>";
        }
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetSierDeleteDlg($_REQUEST)->toBase64();
            $sTaskLog.="</content>";
        }    
        else
        {
            // to do lista da recuperare con filtro
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Identificativi non presenti.</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiunta provvedimenti
    public function Task_GetSierAddNewDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
       
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per istanziare nuovi elementi.</error>";
        }
        else
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetSierAddNewDlg()->toBase64();
            $sTaskLog.="</content>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task aggiungi allegato
    public function Task_GetSierAddNewAllegatoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $object= new AA_Sier($_REQUEST['id'],$this->oUser);
        
        if(!$object->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Provvedimento non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetSierAddNewAllegatoDlg($object)->toBase64();
            $sTaskLog.="</content>";
            $task->SetLog($sTaskLog);
        
            return true;
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare il provvedimento (".$object->GetId().").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
    }

    //Task aggiorna allegato
    public function Task_UpdateSierAllegato($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $object= new AA_Sier($_REQUEST['id'],$this->oUser);
        
        if(!$object->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Provvedimento non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare il provvedimento (".$object->GetId().").</error>";
            $task->SetLog($sTaskLog);
        
            return true;
        }

        $allegato=$object->GetAllegato($_REQUEST['id_allegato'],$this->oUser);
        if($allegato==null)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo allegato non valido (".$_REQUEST['id_allegato'].").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $file = AA_SessionFileUpload::Get("NewAllegatoDoc");
        
        if(!$file->isValid() && $_REQUEST['url'] == "")
        {   
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($file,true)." - ".print_r($_REQUEST,true),100);
            $task->SetError("Parametri non validi occorre indicare un url o un file.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Parametri non validi: occorre indicare un url o un file.</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
        
        $allegato->SetEstremi($_REQUEST['estremi']);
        $allegato->SetUrl($_REQUEST['url']);
        
        //AA_Log::Log(__METHOD__." - "."Provvedimento: ".print_r($provvedimento, true),100);
        
        if($file->isValid()) $filespec=$file->GetValue();
        else $filespec=array();
        
        if(!$object->UpdateAllegato($allegato, $filespec['tmp_name'], $this->oUser))
        {        
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nell'aggiornamento dell'allegato. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Allegato aggiornato con successo.";
        $sTaskLog.="</content>";
        $task->SetLog($sTaskLog);

        return true;
    }

    //Task aggiorna allegato
    public function Task_DeleteSierAllegato($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $object= new AA_Sier($_REQUEST['id'],$this->oUser);
        
        if(!$object->isValid() || $object->GetId()<=0)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Provvedimento non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare il provvedimento (".$object->GetId().").</error>";
            $task->SetLog($sTaskLog);
        
            return true;
        }

        $allegato=$object->GetAllegato($_REQUEST['id_allegato'],$this->oUser);
        if($allegato==null)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo allegato non valido (".$_REQUEST['id_allegato'].").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(!$object->DeleteAllegato($allegato))
        {   
            $task->SetError("Errore durante l'eliminazione dell'allegato: ".$allegato->GetEstremi());
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore durante l'eliminazione dell'allegato: ".$allegato->GetEstremi()."</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Allegato eliminato con successo.";
        $sTaskLog.="</content>";
        $task->SetLog($sTaskLog);

        return true;
    }

    //Task aggiungi dato contabile
    public function Task_GetSierModifyAllegatoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $object= new AA_Sier($_REQUEST['id'],$this->oUser);
        
        if(!$object->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Provvedimento non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare il provvedimento (".$object->GetId().").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $allegato=$object->GetAllegato($_REQUEST['id_allegato'],$this->oUser);
        if($allegato==null)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo allegato non valido (".$_REQUEST['id_allegato'].").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $sTaskLog.= $this->Template_GetSierModifyAllegatoDlg($object,$allegato)->toBase64();
        $sTaskLog.="</content>";
        $task->SetLog($sTaskLog);

        return true;
    }

    //Task aggiungi dato contabile
    public function Task_GetSierTrashAllegatoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $object= new AA_Sier($_REQUEST['id'],$this->oUser);
        
        if(!$object->isValid() || $object->GetId()<= 0)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Provvedimento non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare il provvedimento (".$object->GetId().").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $allegato=$object->GetAllegato($_REQUEST['id_allegato'],$this->oUser);
        if($allegato==null)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo allegato non valido (".$_REQUEST['id_allegato'].").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $sTaskLog.= $this->Template_GetSierTrashAllegatoDlg($object,$allegato)->toBase64();
        $sTaskLog.="</content>";
        $task->SetLog($sTaskLog);

        return true;
    }

    //Task filter dlg
    public function Task_GetSierPubblicateFilterDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $content=$this->TemplatePubblicateFilterDlg($_REQUEST);
        $sTaskLog.= base64_encode($content);
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task filter dlg
    public function Task_GetSierBozzeFilterDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $content=$this->TemplateBozzeFilterDlg($_REQUEST);
        $sTaskLog.= base64_encode($content);
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task NavBarContent
    public function Task_GetNavbarContent($task)
    {
        if(!$this->oUser->HasFlag(AA_Sier_Const::AA_USER_FLAG_SIER))
        {
            $_REQUEST['section']=static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX;
        }
        
        return $this->Task_GetGenericNavbarContent($task,$_REQUEST);
    }
    
    //Template filtro di ricerca
    public function TemplatePubblicateFilterDlg($params=array())
    {
        //Valori runtime
        $formData=array("id_assessorato"=>$params['id_assessorato'],"id_direzione"=>$params['id_direzione'],"struct_desc"=>$params['struct_desc'],"id_struct_tree_select"=>$params['id_struct_tree_select'],"descrizione"=>$params['descrizione'],"nome"=>$params['nome'],"cestinate"=>$params['cestinate'],"Tipo"=>$params['Tipo'],"Estremi"=>$params['Estremi']);
        
        //Valori default
        if($params['struct_desc']=="") $formData['struct_desc']="Qualunque";
        if($params['id_assessorato']=="") $formData['id_assessorato']=0;
        if($params['id_direzione']=="") $formData['id_direzione']=0;
        if($params['id_servizio']=="") $formData['id_servizio']=0;
        if($params['cestinate']=="") $formData['cestinate']=0;
        if($params['revisionate']=="") $formData['revisionate']=0;
        if($params['Tipo']=="") $formData['Tipo']=0;

        //Valori reset
        $resetData=array("id_assessorato"=>0,"id_direzione"=>0,"id_servizio"=>0, "struct_desc"=>"Qualunque","id_struct_tree_select"=>"","descrizione"=>"","nome"=>"","cestinate"=>0,"revisionate"=>0,"Estremi"=>"", "Tipo"=>0);
        
        //Azioni da eseguire dopo l'applicazione del filtro
        $applyActions="module.refreshCurSection()";
        
        $dlg = new AA_GenericFilterDlg(static::AA_UI_PREFIX."_Pubblicate_Filter", "Parametri di ricerca per le schede pubblicate",$this->GetId(),$formData,$resetData,$applyActions);
        
        $dlg->SetHeight(580);
                
        //Cestinate
        $dlg->AddSwitchBoxField("cestinate","Cestino",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede cestinate."));
      
        //Revisionate
        //$dlg->AddSwitchBoxField("revisionate","Revisionate",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede revisionate."));
        
        //oggetto
        $dlg->AddTextField("nome","Oggetto",array("bottomLabel"=>"*Filtra in base all'oggetto del provvedimento/accordo.", "placeholder"=>"Oggetto..."));
        
        //Struttura
        $dlg->AddStructField(array("targetForm"=>$dlg->GetFormId()),array("select"=>true),array("bottomLabel"=>"*Filtra in base alla struttura controllante."));
        
        //tipo
        /*
        $selectionChangeEvent="try{AA_MainApp.utils.getEventHandler('onTipoProvSelectChange','".$this->id."','".$this->id."_Field_Tipo')}catch(msg){console.error(msg)}";
        $options=array();
        $options[0]="Qualunque";
        foreach(AA_Sier_Const::GetListaTipologia() as $key=>$value)
        {
            $options[]=array("id"=>$key,"value"=>$value);
        }
        $dlg->AddSelectField("Tipo","Tipo",array("bottomLabel"=>"*filtra in base al tipo di provvedimento","placeholder"=>"Scegli una voce...","options"=>$options));

        //descrizione
        $dlg->AddTextField("descrizione","Descrizione",array("bottomLabel"=>"*Filtra in base alla descrizione del provvedimento/accordo.", "placeholder"=>"Descrizione..."));

        //Estremi provvedimento
        $dlg->AddTextField("Estremi","Estremi",array("bottomLabel"=>"*Filtra in base agli estremi del provvedimento/accordo.", "placeholder"=>"Estremi..."));*/
        
        $dlg->SetApplyButtonName("Filtra");

        return $dlg->GetObject();
    }
    
    //Template filtro di ricerca
    public function TemplateBozzeFilterDlg($params=array())
    {
        //Valori runtime
        $formData=array("id_assessorato"=>$params['id_assessorato'],"id_direzione"=>$params['id_direzione'],"struct_desc"=>$params['struct_desc'],"id_struct_tree_select"=>$params['id_struct_tree_select'],"descrizione"=>$params['descrizione'],"nome"=>$params['nome'],"cestinate"=>$params['cestinate'],"Tipo"=>$params['Tipo'],"Estremi"=>$params['Estremi']);
        
        //Valori default
        if($params['struct_desc']=="") $formData['struct_desc']="Qualunque";
        if($params['id_assessorato']=="") $formData['id_assessorato']=0;
        if($params['id_direzione']=="") $formData['id_direzione']=0;
        if($params['id_servizio']=="") $formData['id_servizio']=0;
        if($params['cestinate']=="") $formData['cestinate']=0;
        if($params['Tipo']=="") $formData['Tipo']=0;

        //Valori reset
        $resetData=array("id_assessorato"=>0,"id_direzione"=>0,"id_servizio"=>0, "struct_desc"=>"Qualunque","id_struct_tree_select"=>"","descrizione"=>"","nome"=>"","cestinate"=>0,"revisionate"=>0,"Estremi"=>"", "Tipo"=>0);
        
        //Azioni da eseguire dopo l'applicazione del filtro
        $applyActions="module.refreshCurSection()";
        
        $dlg = new AA_GenericFilterDlg(static::AA_UI_PREFIX."_Pubblicate_Filter", "Parametri di ricerca per le schede pubblicate",$this->GetId(),$formData,$resetData,$applyActions);
        
        $dlg->SetHeight(580);
                
        //Cestinate
        $dlg->AddSwitchBoxField("cestinate","Cestino",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede cestinate."));
      
        //Revisionate
        //$dlg->AddSwitchBoxField("revisionate","Revisionate",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede revisionate."));
        
        //oggetto
        $dlg->AddTextField("nome","Oggetto",array("bottomLabel"=>"*Filtra in base all'oggetto del provvedimento/accordo.", "placeholder"=>"Oggetto..."));
        
        //Struttura
        $dlg->AddStructField(array("targetForm"=>$dlg->GetFormId()),array("select"=>true),array("bottomLabel"=>"*Filtra in base alla struttura controllante."));
        
        //tipo
        /*$selectionChangeEvent="try{AA_MainApp.utils.getEventHandler('onTipoProvSelectChange','".$this->id."','".$this->id."_Field_Tipo')}catch(msg){console.error(msg)}";
        $options=array();
        $options[0]="Qualunque";
        foreach(AA_Sier_Const::GetListaTipologia() as $key=>$value)
        {
            $options[]=array("id"=>$key,"value"=>$value);
        }
        $dlg->AddSelectField("Tipo","Tipo",array("bottomLabel"=>"*filtra in base al tipo di provvedimento","placeholder"=>"Scegli una voce...","options"=>$options));*/

        //descrizione
        $dlg->AddTextField("descrizione","Descrizione",array("bottomLabel"=>"*Filtra in base alla descrizione del provvedimento/accordo.", "placeholder"=>"Descrizione..."));

        //Estremi provvedimento
        $dlg->AddTextField("Estremi","Estremi",array("bottomLabel"=>"*Filtra in base agli estremi del provvedimento/accordo.", "placeholder"=>"Estremi..."));

        $dlg->SetApplyButtonName("Filtra");

        return $dlg->GetObject();
    }
    
    //Funzione di esportazione in pdf (da specializzare)
    public function Template_PdfExport($ids=array(),$toBrowser=true,$title="Pubblicazione ai sensi dell'art.23 del d.lgs. 33/2013",$rowsForPage=20,$index=false,$subTitle="")
    {
        return $this->Template_GenericPdfExport($ids,$toBrowser,$title,"Template_SierPdfExport", $rowsForPage, $index,$subTitle);
    }

    //Template pdf export single
    public function Template_SierPdfExport($id="", $parent=null,$object=null,$user=null)
    {
        if(!($object instanceof AA_Sier))
        {
            return "";
        }
        
        if($id=="") $id="Template_SierPdfExport_".$object->GetId();

        return new AA_SierPublicReportTemplateView($id,$parent,$object,$user);
    }

    //Template dettaglio allegati
    public function TemplateDettaglio_Allegati($object=null,$id="", $canModify=false)
    {
        #documenti----------------------------------
        $curId=$id."_Layout_Allegati";
        $provvedimenti=new AA_JSON_Template_Layout($curId,array("type"=>"clean","css"=>array("border-left"=>"1px solid #dedede !important;")));

        $toolbar=new AA_JSON_Template_Toolbar($curId."_Toolbar_allegati",array("height"=>38, "css"=>array("background"=>"#dadee0 !important;")));
        $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));

        $toolbar->AddElement(new AA_JSON_Template_Generic($curId."_Toolbar_Allegati_Title",array("view"=>"label","label"=>"<span style='color:#003380'>Allegati e link</span>", "align"=>"center")));

        if($canModify)
        {
            //Pulsante di aggiunta documento
            $add_documento_btn=new AA_JSON_Template_Generic($curId."_AddAllegato_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-file-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "width"=>120,
                "tooltip"=>"Aggiungi allegato o link",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetSierAddNewAllegatoDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
            ));

            $toolbar->AddElement($add_documento_btn);
        }
        else 
        {
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
        }

        $provvedimenti->AddRow($toolbar);

        $options_documenti=array();

        if($canModify)
        {
            $options_documenti[]=array("id"=>"estremi", "header"=>"Descrizione", "fillspace"=>true,"css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }
        else
        {
            $options_documenti[]=array("id"=>"estremi", "header"=>"Descrizione", "fillspace"=>true,"css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }

        $documenti=new AA_JSON_Template_Generic($curId."_Allegati_Table",array("view"=>"datatable", "headerRowHeight"=>28, "select"=>true,"scrollX"=>false,"css"=>"AA_Header_DataTable","columns"=>$options_documenti));

        $documenti_data=array();
        foreach($object->GetAllegati() as $id_doc=>$curDoc)
        {
            if($curDoc->GetUrl() == "")
            {
                $view='AA_MainApp.utils.callHandler("pdfPreview", {url: "'.$curDoc->GetFilePublicPath().'&embed=1&id_object='.$object->GetId().'"},"'.$this->id.'")';
                $view_icon="mdi-floppy";
            }
            else 
            {
                $view='AA_MainApp.utils.callHandler("wndOpen", {url: "'.$curDoc->GetUrl().'"},"'.$this->id.'")';
                $view_icon="mdi-eye";
            }
            
            
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetSierTrashAllegatoDlg", params: [{id: "'.$object->GetId().'"},{id_allegato:"'.$curDoc->GetId().'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetSierModifyAllegatoDlg", params: [{id: "'.$object->GetId().'"},{id_allegato:"'.$curDoc->GetId().'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='Vedi' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="<div class='AA_DataTable_Ops' style='justify-content: center'><a class='AA_DataTable_Ops_Button' title='Vedi' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a></div>";
            $documenti_data[]=array("id"=>$id_doc,"estremi"=>$curDoc->GetEstremi(),"ops"=>$ops);
        }
        $documenti->SetProp("data",$documenti_data);
        if(sizeof($documenti_data) > 0) $provvedimenti->AddRow($documenti);
        else $provvedimenti->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        #--------------------------------------
        
        return $provvedimenti;
    }
}

#Classe template per la gestione del report pdf dell'oggetto
Class AA_SierPublicReportTemplateView extends AA_GenericObjectTemplateView
{
    public function __construct($id="AA_SierPublicReportTemplateView",$parent=null,$object=null)
    {
        if(!($object instanceof AA_Sier))
        {
            AA_Log::Log(__METHOD__." - oggetto non valido.", 100,false,true);
            return;
        }

        //Chiama il costruttore della classe base
        parent::__construct($id,$parent,$object);
        
        $this->SetStyle("width: 100%; display:flex; flex-direction: row; align-items: center; justify-content: space-between; border-bottom: 1px solid  gray; height: 100%");

        #Ufficio----------------------------------
        $struct=$object->GetStruct();
        $struct_desc=$struct->GetAssessorato();
        if($struct->GetDirezione(true) > 0) $struct_desc.="<br>".$struct->GetDirezione();
        if($struct->GetServizio(true) >0) $struct_desc.="<br>".$struct->GetServizio();

        $ufficio=new AA_XML_Div_Element($id."_ufficio",$this);
        $ufficio->SetStyle('width:30%; font-size: .6em; padding: .1em');
        $ufficio->SetText($struct_desc);
        #-----------------------------------------------
        
        #descrizione----------------------------------
        $oggetto=new AA_XML_Div_Element($id."_descrizione",$this);
        $oggetto->SetStyle('width:30%; font-size: .6em; padding: .1em; text-align: justify');
        $oggetto->SetText(substr($object->GetName(),0,320));
        #-----------------------------------------------

        /*if($object->GetTipo(true) == AA_Sier_Const::AA_TIPO_PROVVEDIMENTO_SCELTA_CONTRAENTE)
        {
            #modalità----------------------------------
            $oggetto=new AA_XML_Div_Element($id."_modalita",$this);
            $oggetto->SetStyle('width:20%; font-size: .5em; padding: .1em');
            $oggetto->SetText($object->GetModalita());
            #-----------------------------------------------
        }
        else
        {
            #contraente----------------------------------
            $oggetto=new AA_XML_Div_Element($id."_contraente",$this);
            $oggetto->SetStyle('width:20%; font-size: .6em; padding: .1em');
            $oggetto->SetText($object->GetProp("Contraente"));
            #-----------------------------------------------                        
        }*/

        #estremi----------------------------------
        $oggetto=new AA_XML_Div_Element($id."_estremi",$this);
        $oggetto->SetStyle('width:19%; font-size: .6em; padding: .1em');
        $oggetto->SetText($object->GetProp("Estremi"));
        #-----------------------------------------------        
    }
}

//Classe per la gestione degli allegati
Class AA_SierAllegati
{
    protected $id=0;
    public function GetId()
    {
        return $this->id;
    }
    public function SetId($id=0)
    {
        $this->id=$id;
    }
    
    protected $url="";
    public function GetUrl()
    {
        return $this->url;
    }
    public function SetUrl($url="")
    {
        $this->url=$url;
    }
    
    protected $estremi="";
    public function GetEstremi()
    {
        return $this->estremi;
    }
    public function SetEstremi($val="")
    {
        $this->estremi=$val;
    }

    public function GetFilePath()
    {
        if(is_file(AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$this->id.".pdf"))
        {
            return AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$this->id.".pdf";
        }
        
        return "";
    }

    public function GetFileLocalPath()
    {        
        return $this->GetFilePath();
    }
    
    public function GetFilePublicPath()
    {
        if(is_file(AA_Const::AA_UPLOADS_PATH.AA_Sier_Const::AA_SIER_ALLEGATI_PATH."/".$this->id.".pdf"))
        {
            return AA_Sier_Const::AA_WWW_ROOT.AA_Sier_Const::AA_SIER_ALLEGATI_PUBLIC_PATH."?id=".$this->id."&id_sier=".$this->id_sier;
        }
        
        return "";
    }
    
    protected $id_sier=0;
    public function GetIdProvvedimento()
    {
        return $this->id_sier;
    }
    public function SetIdProvvedimento($id=0)
    {
        $this->id_sier=$id;
    }
    
    public function __construct($id=0,$id_sier=0,$estremi="",$url="")
    {
        //AA_Log::Log(__METHOD__." id: $id, id_organismo: $id_organismo, tipo: $tipo, url: $url",100);
        
        $this->id=$id;
        $this->id_sier=$id_sier;
        $this->url=$url;
        $this->estremi=$estremi;
    }
    
    //Download del documento
    public function Download($embed=false)
    {
        $filename=$this->GetFilePath();

        if(is_file($filename))
        {
            header("Cache-control: private");
            header("Content-type: application/pdf");
            header("Content-Length: ".filesize($filename));
            if(!$embed) header('Content-Disposition: attachment; filename="'.$this->id.'.pdf"');

            $fd = fopen ($filename, "rb");
            echo fread ($fd, filesize ($filename));
            fclose ($fd);
            die();
        }
        else
        {
            die("file non trovato");
        }
    }
}