<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "config.php";
include_once "system_lib.php";

#Costanti
Class AA_Geser_Const extends AA_Const
{
    const AA_USER_FLAG_GESER="geser";

    const AA_USER_FLAG_GESER_RO="geser_ro";

    const AA_DBTABLE_CODICI_ISTAT="aa_patrimonio_codici_istat";

    //Stato impianto;
    static protected $nStatoImpianto=null;
    const AA_GESER_STATO_AUTORIZZAZIONE=1;
    const AA_GESER_STATO_AUTORIZZATO=2;
    const AA_GESER_STATO_INCOSTRUZIONE=64;
    const AA_GESER_STATO_ESERCIZIO=4;
    const AA_GESER_STATO_DISMISSIONE=8;
    const AA_GESER_STATO_DISMESSO=16;
    const AA_GESER_STATO_AMPLIAMENTO=32;
    const AA_GESER_STATO_FUORI_ESERCIZIO=64;
    public static function GetListaStatiImpianto()
    {
        if(static::$nStatoImpianto==null)
        {
            static::$nStatoImpianto=array(
                static::AA_GESER_STATO_AUTORIZZAZIONE=>"Richiesta autorizzazione",
                static::AA_GESER_STATO_AUTORIZZATO=>"Autorizzato",
                static::AA_GESER_STATO_INCOSTRUZIONE=>"In costruzione",
                static::AA_GESER_STATO_ESERCIZIO=>"In esercizio",
                static::AA_GESER_STATO_FUORI_ESERCIZIO=>"Inattivo",
                static::AA_GESER_STATO_AMPLIAMENTO=>"In fase di modifica",
                static::AA_GESER_STATO_DISMISSIONE=>"In dismissione",
                static::AA_GESER_STATO_DISMESSO=>"Dismesso"
            );
        }

        return static::$nStatoImpianto;
    }

    protected static $aTipoVia=null;
    const AA_GESER_TIPO_VIA_NESSUNO=1;
    const AA_GESER_TIPO_VIA_REGIONALE=2;
    const AA_GESER_TIPO_VIA_MINISTERIALE=4;
    public static function GetListaTipoVia()
    {
        if(static::$aTipoVia==null)
        {
            static::$aTipoVia=array(
                static::AA_GESER_TIPO_VIA_NESSUNO=>"Non soggetta",
                static::AA_GESER_TIPO_VIA_REGIONALE=>"Regionale",
                static::AA_GESER_TIPO_VIA_MINISTERIALE=>"Ministeriale"
            );
        }

        return static::$aTipoVia;
    }

    protected static $aStatoPratica=null;
    const AA_GESER_STATO_PRATICA_DAISTRUIRE=1;
    const AA_GESER_STATO_PRATICA_INLAVORAZIONE=2;
    const AA_GESER_STATO_PRATICA_AUTORIZZATA=4;
    const AA_GESER_STATO_PRATICA_SOSPESA_VIA=8;
    const AA_GESER_STATO_PRATICA_NEGATA=16;
    public static function GetListaStatiPratica()
    {
        if(static::$aStatoPratica==null)
        {
            static::$aStatoPratica=array(
                static::AA_GESER_STATO_PRATICA_DAISTRUIRE=>"Da istruire",
                static::AA_GESER_STATO_PRATICA_INLAVORAZIONE=>"In lavorazione",
                static::AA_GESER_STATO_PRATICA_AUTORIZZATA=>"Approvata",
                static::AA_GESER_STATO_PRATICA_SOSPESA_VIA=>"Sospesa per VIA",
                static::AA_GESER_STATO_PRATICA_NEGATA=>"Rigettata"
            );
        }

        return static::$aStatoPratica;
    }

    protected static $aTipoPratica=null;
    const AA_GESER_TIPO_PRATICA_AU=1;
    const AA_GESER_TIPO_PRATICA_VARIANTE=2;
    const AA_GESER_TIPO_PRATICA_VOLTURA=4;
    public static function GetListaTipoPratica()
    {
        if(static::$aTipoPratica==null)
        {
            static::$aTipoPratica=array(
                static::AA_GESER_TIPO_PRATICA_AU=>"Autorizzazione Unica",
                static::AA_GESER_TIPO_PRATICA_VARIANTE=>"Variante",
                static::AA_GESER_TIPO_PRATICA_VOLTURA=>"Voltura"
            );
        }

        return static::$aTipoPratica;
    }

    protected static $aTipoImpianti=null;
    const AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO=1;
    const AA_GESER_TIPOIMPIANTO_EOLICO=2;
    const AA_GESER_TIPOIMPIANTO_AGRIVOLTAICO=4;
    const AA_GESER_TIPOIMPIANTO_BIOGAS=8;
    const AA_GESER_TIPOIMPIANTO_BIOMASSA=16;
    const AA_GESER_TIPOIMPIANTO_IDROELETTRICO=32;
    const AA_GESER_TIPOIMPIANTO_ELETTRODOTTO=64;
    const AA_GESER_TIPOIMPIANTO_TERMODINAMICO=128;
    const AA_GESER_TIPOIMPIANTO_OFFSHORE=256;
    public static function GetListaTipoImpianti()
    {
        if(static::$aTipoImpianti==null)
        {
            static::$aTipoImpianti=array(
                static::AA_GESER_TIPOIMPIANTO_AGRIVOLTAICO=>"Agrivoltaico",
                static::AA_GESER_TIPOIMPIANTO_BIOGAS=>"Biogas",
                static::AA_GESER_TIPOIMPIANTO_BIOMASSA=>"Biomassa",
                static::AA_GESER_TIPOIMPIANTO_ELETTRODOTTO=>"Elettrodotto",
                static::AA_GESER_TIPOIMPIANTO_EOLICO=>"Eolico",
                static::AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO=>"Fotovoltaico",
                static::AA_GESER_TIPOIMPIANTO_IDROELETTRICO=>"Idroelettrico",
                static::AA_GESER_TIPOIMPIANTO_OFFSHORE=>"Off-shore",
                static::AA_GESER_TIPOIMPIANTO_TERMODINAMICO=>"Solare termodinamico",
            );
        }

        return static::$aTipoImpianti;
    }

    public static function GetListaComuni()
    {
        $db=new AA_Database();
        $query="SELECT id,comune FROM ".AA_Geser_Const::AA_DBTABLE_CODICI_ISTAT." ORDER BY comune ASC";
        //$query.=" LIMIT 10";

        //AA_Log::Log(__METHOD__." - query ".$query.print_r($_REQUEST,true),100);
        
        //errore nella query
        if(!$db->Query($query))
        {
            AA_Log::Log(__METHOD__." - ERRORE ".$db->GetErrorMessage(),100);
            die("[]");
        }

        //Query vuota
        if($db->GetAffectedRows() == 0)
        {
            die("[]");
        }
        
        $result=array();
        $count=1;
        foreach($db->GetResultSet() as $curRow)
        {
            $result[$curRow['id']]=$curRow['comune'];
            $count++;
        }

        return $result;
    }
}

#Classe oggetto geser
Class AA_Geser extends AA_Object_V2
{
    //tabella dati db
    const AA_DBTABLE_DATA="aa_geser_data";
    static protected $AA_DBTABLE_OBJECTS="aa_geser_objects";

    //Funzione di cancellazione
    protected function DeleteData($idData = 0, $user = null)
    {
        if(!$this->IsValid() || $this->IsReadOnly() || $idData == 0) return false;

        if($idData != $this->nId_Data && $idData != $this->nId_Data_Rev) return false;

        //Cancella tutti gli allegati
        $allegati=$this->GetAllegati();
        foreach( $allegati as $key=>$curAllegato)
        {
            if(!$this->DeleteAllegato($key,$user))
            {
                return false;
            }
        }

        return parent::DeleteData($idData,$user);
    }

    public function serialize()
    {
        $result=get_object_vars($this);
        return json_encode($result);
    }


    //geolocalizzazione
    protected $geolocalizzazione=null;
    public function GetGeolocalizzazione()
    {
        if(!$this->IsValid()) return array();

        if(!is_array($this->geolocalizzazione))
        {
            $this->geolocalizzazione=json_decode($this->GetProp('Geolocalizzazione'),true);
            if(!is_array($this->geolocalizzazione))
            {
                //AA_Log::Log(__METHOD__." - errore nel parsing",100);
                return array();
            }
        }

        return $this->geolocalizzazione;
    }

    public function GetTipo()
    {
        if($this->GetProp("Tipologia")<=0) return "Non definito";
        $tipologia=AA_Geser_Const::GetListaTipoImpianti();
        return $tipologia[$this->GetProp("Tipologia")];
    }

    public function GetStato()
    {
        if($this->GetProp("Stato")<=0) return "Non definito";
        $tipologia=AA_Geser_Const::GetListaStatiImpianto();
        return $tipologia[$this->GetProp("Stato")];
    }

    //pratiche
    protected $pratiche=null;
    public function GetPratiche()
    {
        if(!$this->IsValid()) return array();

        if(!is_array($this->pratiche))
        {
            $this->pratiche=json_decode($this->GetProp('Pratiche'),true);
            if(!is_array($this->pratiche))
            {
                AA_Log::Log(__METHOD__." - errore nel parsing",100);
                return array();
            }
        }

        return $this->pratiche;
    }

    //proprietario
    protected $proprietario=null;
    public function GetProprietario()
    {
        if(!$this->IsValid()) return array();

        if(!is_array($this->proprietario))
        {
            $this->proprietario=json_decode($this->GetProp('Proprietario'),true);
            if(!is_array($this->proprietario))
            {
                AA_Log::Log(__METHOD__." - errore nel parsing",100);
                return array();
            }
        }

        return $this->proprietario;
    }

    //proprietario
    protected $gseData=null;
    public function GetGseData()
    {
        if(!$this->IsValid()) return array();

        if(!is_array($this->gseData))
        {
            $this->gseData=json_decode($this->GetProp('GseData'),true);
            if(!is_array($this->gseData))
            {
                AA_Log::Log(__METHOD__." - errore nel parsing",100);
                return array();
            }
        }

        return $this->gseData;
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
        $this->AddProp("Note","","note");
        $this->AddProp("Tipologia",0,"tipologia");
        $this->AddProp("Superficie",0,"superficie");
        $this->AddProp("Stato",0,"stato");
        $this->AddProp("AnnoAutorizzazione","","anno_autorizzazione");
        $this->AddProp("InizioLavori","","inizio_lavori");
        $this->AddProp("AnnoCostruzione","","anno_costruzione");
        $this->AddProp("AnnoEsercizio","","anno_entrata_esercizio");
        $this->AddProp("AnnoDismissione","","anno_dismissione");
        $this->AddProp("Potenza",0,"potenza");
        $this->AddProp("Geolocalizzazione","","geolocalizzazione");
        $this->AddProp("Pratiche","","pratiche");
        $this->AddProp("Proprietario","","proprietario");
        $this->AddProp("GseData","","gse_data");
        //$this->AddProp("Allegati","","allegati");

        //disabilita la revisione
        $this->EnableRevision(false);

        //chiama il costruttore genitore
        parent::__construct($id,$user);
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
        $params['class']="AA_Geser";
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
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0 && !$user->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $perms = AA_Const::AA_PERMS_READ;
        }
        //---------------------------------------

        //Se l'utente ha il flag e può modificare la scheda allora può fare tutto
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0 && $user->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
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
        if(!$user->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            AA_Log::Log(__METHOD__." - L'utente corrente: ".$user->GetUserName()." non ha i permessi per inserire nuovi elementi.",100);
            return false;
        }

        //Verifica validità oggetto
        if(!($object instanceof AA_Geser))
        {
            AA_Log::Log(__METHOD__." - Errore: oggetto non valido (".print_r($object,true).").",100);
            return false;
        }

        $object->nId=0;
        $object->bValid=true;
        //----------------------------------------------

        return parent::AddNew($object,$user,$bSaveData);
    }

    public function Update($user = null, $bSaveData = true, $logMsg = '')
    {
        //AA_Log::Log(__METHOD__." - Aggiornamento: ".print_r($this,true),100);
        return parent::Update($user,true,$logMsg);
    }

    protected $allegati=null;

    //Restituisce gli allegati
    public function GetAllegati()
    {
         if(!$this->IsValid()) return array();

        if(!is_array($this->allegati))
        {
            $this->allegati=json_decode($this->GetProp('Allegati'),true);
            if(!is_array($this->allegati))
            {
                AA_Log::Log(__METHOD__." - errore nel parsing  degli allegati'",100);
                return array();
            }
        }

        return $this->allegati;
    }

    public function GetAllegato($id_allegato="")
    {
         if(!$this->IsValid() || $id_allegato <=0 || $id_allegato=="") return null;

        if(!is_array($this->allegati))
        {
            $this->allegati=json_decode($this->GetProp('Allegati'),true);
            if(!is_array($this->allegati))
            {
                AA_Log::Log(__METHOD__." - errore nel parsing  degli allegati'",100);
                return null;
            }
        }

        if(!isset($this->allegati[$id_allegato])) return null;
        $allegato=$this->allegati[$id_allegato];
        $allegato['id']=$id_allegato;

        return $allegato;
    }

    //Elimina un allegato esistente
    public function DeleteAllegato($id_allegato="", $user=null)
    {
        if(!$this->isValid())
        {
                AA_Log::Log(__METHOD__." - elemento non valido.", 100,false,true);
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
            AA_Log::Log(__METHOD__." - l'utente corrente non può modificare l'elemento.", 100,false,true);
            return false;
        }

        $allegati=$this->GetAllegati();
        if(!isset($allegati[$id_allegato]))
        {
            AA_Log::Log(__METHOD__." - Allegato/link non valido.", 100,false,true);
            return false;
        }

        $allegato=$allegati[$id_allegato];
        $fileHash=$allegato['filehash'];
        
        if($fileHash !="")
        {
            $storage=AA_Storage::GetInstance($user);
            if($storage->IsValid())
            {
                if(!$storage->DelFile($fileHash))
                {
                    AA_Log::Log(__METHOD__." - Errore nella rimozione del file sullo storage. (".$fileHash.")", 100,false,true);
                }
            }
        }
        
        unset($allegati[$id_allegato]);
        $this->SetAllegati($allegati);

        $this->IsChanged();

        //Aggiorna l'elemento e lo versiona se necessario
        if(!$this->Update($user,true, "Rimozione allegato/link: ".$id_allegato))
        {
            return false;
        }

        return true;
    }

    public function SetAllegati($val="")
    {
        if(is_array($val)) $this->aProps['Allegati']=json_encode($val);
        else $this->aProps['Allegati']=$val;
    }
}

/**
 * Classe AA_GeserModule
 * 
 * Questa classe rappresenta un modulo per la gestione di impianti e pratiche correlate.
 * Estende la classe AA_GenericModule e implementa funzionalità specifiche per il sistema GESER.
 * 
 * Caratteristiche principali:
 * - Gestione di impianti di varie tipologie (fotovoltaico, eolico, ecc.)
 * - Gestione delle pratiche associate agli impianti
 * - Implementazione di interfacce utente per l'inserimento, modifica e visualizzazione dei dati
 * - Gestione di allegati e link associati agli impianti e alle pratiche
 * - Implementazione di funzionalità di ricerca e filtraggio
 * 
 * La classe include numerosi metodi per la creazione di finestre di dialogo e form
 * per l'interazione con l'utente, come ad esempio:
 * - Aggiunta di nuovi impianti
 * - Modifica di impianti esistenti
 * - Gestione delle pratiche
 * - Gestione degli allegati
 * 
 * Inoltre, la classe implementa metodi per la gestione dei dati, inclusi:
 * - Ricerca di impianti
 * - Aggiornamento dei dati degli impianti
 * - Eliminazione di impianti
 * 
 * La classe fa uso estensivo di costanti per definire identificatori e nomi di sezioni,
 * e utilizza un sistema di gestione dei task per l'esecuzione di operazioni specifiche.
 * 
 * Note:
 * - La classe fa uso di diverse classi di supporto come AA_GenericFormDlg, AA_FieldSet, ecc.
 * - Implementa un sistema di controllo degli accessi basato su flag utente
 * - Utilizza un sistema di logging per tracciare le operazioni e gli errori
 * 
 * Attenzione:
 * - La classe contiene molti metodi lunghi e complessi che potrebbero beneficiare di una refactoring
 * - Alcuni commenti e nomi di variabili sono in italiano, sarebbe preferibile uniformare la lingua utilizzata
 */
Class AA_GeserModule extends AA_GenericModule
{
    const AA_UI_PREFIX="AA_Geser";

    //Id modulo
    const AA_ID_MODULE="AA_MODULE_GESER";

    //main ui layout box
    const AA_UI_MODULE_MAIN_BOX="AA_Geser_module_layout";

    const AA_MODULE_OBJECTS_CLASS="AA_Geser";

    //Task per la gestione dei dialoghi standard
    const AA_UI_TASK_PUBBLICATE_FILTER_DLG="GetGeserPubblicateFilterDlg";
    const AA_UI_TASK_BOZZE_FILTER_DLG="GetGeserBozzeFilterDlg";
    const AA_UI_TASK_REASSIGN_DLG="GetGeserReassignDlg";
    const AA_UI_TASK_PUBLISH_DLG="GetGeserPublishDlg";
    const AA_UI_TASK_TRASH_DLG="GetGeserTrashDlg";
    const AA_UI_TASK_RESUME_DLG="GetGeserResumeDlg";
    const AA_UI_TASK_DELETE_DLG="GetGeserDeleteDlg";
    const AA_UI_TASK_ADDNEW_DLG="GetGeserAddNewDlg";
    const AA_UI_TASK_MODIFY_DLG="GetGeserModifyDlg";
    const AA_UI_TASK_ADDNEWMULTI_DLG="GetGeserAddNewMultiDlg";
    //------------------------------------

    //Dialoghi
    
    //report
   
    //Section id
    const AA_ID_SECTION_CRITERI="Criteri";
    //section ui ids
    const AA_UI_DETAIL_GENERALE_BOX = "Generale_Box";
    const AA_UI_DETAIL_PRATICHE_BOX = "Pratiche_Box";

    const AA_UI_TEMPLATE_PRATICHE="Pratiche";

    public function __construct($user=null,$bDefaultSections=true)
    {
        if(!($user instanceof AA_user))
        {
            $user=AA_User::GetCurrentUser();
        }

        parent::__construct($user,$bDefaultSections);

        #-------------------------------- Registrazione dei task -----------------------------
        $taskManager=$this->GetTaskManager();
        
        //Dialoghi di filtraggio
        $taskManager->RegisterTask("GetGeserPubblicateFilterDlg");
        $taskManager->RegisterTask("GetGeserBozzeFilterDlg");

        //dati
        $taskManager->RegisterTask("GetGeserModifyDlg");
        $taskManager->RegisterTask("GetGeserAddNewDlg");
        $taskManager->RegisterTask("GetGeserAddNewMultiDlg");
        $taskManager->RegisterTask("GetGeserAddNewMultiPreviewCalc");
        $taskManager->RegisterTask("GetGeserAddNewMultiPreviewDlg");
        $taskManager->RegisterTask("AddNewMultiGeser");
        $taskManager->RegisterTask("GetGeserAddNewMultiResultDlg");

        $taskManager->RegisterTask("GetGeserTrashDlg");
        $taskManager->RegisterTask("TrashGeser");
        $taskManager->RegisterTask("GetGeserDeleteDlg");
        $taskManager->RegisterTask("DeleteGeser");
        $taskManager->RegisterTask("GetGeserResumeDlg");
        $taskManager->RegisterTask("ResumeGeser");
        $taskManager->RegisterTask("GetGeserReassignDlg");
        $taskManager->RegisterTask("GetGeserPublishDlg");
        $taskManager->RegisterTask("ReassignGeser");
        $taskManager->RegisterTask("AddNewGeser");
        $taskManager->RegisterTask("UpdateGeserDatiGenerali");
        $taskManager->RegisterTask("PublishGeser");
        $taskManager->RegisterTask("GetGeserListaCodiciIstat");
        
        //pratiche
        $taskManager->RegisterTask("GetGeserAddNewPraticaDlg");
        $taskManager->RegisterTask("AddNewGeserPratica");
        $taskManager->RegisterTask("GetGeserModifyPraticaDlg");
        $taskManager->RegisterTask("UpdateGeserPratica");
        $taskManager->RegisterTask("GetGeserTrashPraticaDlg");
        $taskManager->RegisterTask("DeleteGeserPratica");
        $taskManager->RegisterTask("GetGeserCopyPraticaDlg");

        //Allegati
        $taskManager->RegisterTask("GetGeserAddNewAllegatoDlg");
        $taskManager->RegisterTask("AddNewGeserAllegato");
        $taskManager->RegisterTask("GetGeserModifyAllegatoDlg");
        $taskManager->RegisterTask("UpdateGeserAllegato");
        $taskManager->RegisterTask("GetGeserTrashAllegatoDlg");
        $taskManager->RegisterTask("DeleteGeserAllegato");
        
        //template dettaglio
        $this->SetSectionItemTemplate(static::AA_ID_SECTION_DETAIL,array(
            array("id"=>static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_".static::AA_UI_DETAIL_GENERALE_BOX, "value"=>"Generale","tooltip"=>"Dati generali","template"=>"TemplateGeserDettaglio_Generale_Tab"),
            array("id"=>static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_".static::AA_UI_DETAIL_PRATICHE_BOX, "value"=>"Pratiche","tooltip"=>"Pratiche","template"=>"TemplateGeserDettaglio_Pratiche_Tab")
        ));

        //$criteri=new AA_GenericModuleSection(static::AA_ID_SECTION_CRITERI,"Criteri e modalita'",true,static::AA_UI_PREFIX."_".static::AA_UI_SECTION_CRITERI,$this->GetId(),false,true,false,false,'mdi-text-box-multiple',"TemplateSection_Criteri");
        //$this->AddSection($criteri);

        //$pubblicate=$this->GetSection(static::AA_ID_SECTION_PUBBLICATE);
        //$pubblicate->SetNavbarTemplate(array($this->TemplateGenericNavbar_Bozze(1)->toArray(),$this->TemplateGenericNavbar_Section($criteri,2,true)->toArray()));

        //$criteri->SetNavbarTemplate(array($this->TemplateGenericNavbar_Atti(1,true,true)->toArray()));

        //Custom object template
        //$this->AddObjectTemplate(static::AA_UI_PREFIX."_".static::AA_UI_WND_RENDICONTI_COMUNALI."_".static::AA_UI_LAYOUT_RENDICONTI_COMUNALI,"Template_GetGeserComuneRendicontiViewLayout");
    }
    
    static public function GeserDownloadGSEData($url="", $from=0,$count=19)
    {

        $maxCount=0;
        $numImpiantiForBatch=5000;
        $log_file=sys_get_temp_dir().'/log_gse_fetch.log';
        $resultFile=sys_get_temp_dir().'/export_gse.json';
        $impianti=null;
        if(file_exists($resultFile))
        {
            $impianti=json_decode(file_get_contents($resultFile),true);
        }

        if(!is_array($impianti)) $impianti=array();
        
        //file_put_contents($log_file,date("Y-m-d h:i:s")." - Recupero i primi 20 impianti dal sito del GSE");
        if(empty($url)) $url="https://atla.gse.it/atlaimpianti/project/Atlaimpianti_Internet.html";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, sys_get_temp_dir().'/gse_cookie.txt');
        $http_headers = array(
                            'Host: atla.gse.it',
                            'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:131.0) Gecko/20100101 Firefox/131.0',
                            'Accept: text/javascript, text/html, application/xml, application/json, text/xml',
                            'Accept-Language: it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3',
                            'Connection: keep-alive'
                        );
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $output = curl_exec($ch);
        curl_close($ch);

        //richiesta lista primi impianti
        $firstBatch=$from+19;
        if($count < $firstBatch && $count > 1) $firstBatch=$from+$count;

        $url = 'https://atla.gse.it/atlaimpianti/rest/attributesJsonRest/Atlaimpianti_Internet/impianti_internet/?query=requestBody';
        $poststring = '{"filters":[{"condition":"AND","columnName":"ai_regione","attributeGwid":"137615","operator":"IN","filterType":"STRING","value":["SARDEGNA"]}],"parameters":{}}';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, sys_get_temp_dir().'/gse_cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, sys_get_temp_dir().'/gse_cookie.txt');
        $http_headers = array(
                            'Host: atla.gse.it',
                            'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:131.0) Gecko/20100101 Firefox/131.0',
                            'Accept: text/javascript, text/html, application/xml, application/json, text/xml',
                            'Accept-Language: it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3',
                            'Connection: keep-alive',
                            'Referer: https://atla.gse.it/atlaimpianti/project/Atlaimpianti_Internet.html',
                            'X-Range: items='.intVal($from).'-'.$firstBatch,
                            'Content-Type: application/json',
                            'X-Requested-With: XMLHttpRequest'
                        );
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $poststring);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $output = curl_exec ($ch);
        
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = explode("\r",substr($output, 0, $header_size));
        $firstBatchImpianti = json_decode(substr($output, $header_size),true);
        curl_close($ch);

        if(!is_array($header) || $header[0] != "HTTP/1.1 200 OK")
        {
            //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Errore nel recupero dei primi ".($firstBatch-$from)." impianti: ".$output,FILE_APPEND);
            die("\nErrore nel recupero dei primi ".($firstBatch-$from)." impianti: ".$output);
        }

        if(!is_array($firstBatchImpianti))
        {
            //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Errore nel parsing dei primi ".($firstBatch-$from)." impianti: ".$output,FILE_APPEND);
            die("\nErrore nel parsing dei primi ".($firstBatch-$from)." impianti: ".$firstBatchImpianti." - out: ".$output." - header: ".print_r($http_headers,true));
        }
        else
        {
            //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - I primi ".($firstBatch-$from)." impianti sono stati recuperati con successo.",FILE_APPEND);
        }

        $maxCount=explode("/",$header[2]);
        if(!empty($maxCount[1])) 
        {
            $maxCount=intVal($maxCount['1']);
            //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Sono stati trovati n. ".$maxCount." impianti",FILE_APPEND);
            echo "\nSono stati trovati n. ".$maxCount." impianti";
        }
        else
        {
            //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Non sono stati trovati impianti. - ".print_r($header,true),FILE_APPEND);
            die("Non sono stati trovati impianti. - ".print_r($header,true));
        }

        if(sizeof($impianti) < $maxCount)
        {
            $impianti=$firstBatchImpianti;
            $fetched=sizeof($firstBatchImpianti);

            //recupero i dati relativi agli impianti successivi
            if($maxCount-$from > $count && $count > 0) $maxCount=$from+$count;

            for($i=$from+$firstBatch; $i < $maxCount; $i+=$numImpiantiForBatch)
            {
                $nextTo=$i+$numImpiantiForBatch;
                if($nextTo > $maxCount) $nextTo=$maxCount;

                //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Recupero i dati degli impianti dal: ".($i+1)." al: ".$nextTo. " - ImpiantiforBatch: ".$numImpiantiForBatch,FILE_APPEND);
                echo "\n".date("Y-m-d h:i:s")." - Recupero i dati degli impianti dal: ".($i+1)." al: ".$nextTo. " - ImpiantiforBatch: ".$numImpiantiForBatch;

                $url = 'https://atla.gse.it/atlaimpianti/rest/attributesJsonRest/Atlaimpianti_Internet/impianti_internet/?query=requestBody';
                $poststring = '{"filters":[{"condition":"AND","columnName":"ai_regione","attributeGwid":"137615","operator":"IN","filterType":"STRING","value":["SARDEGNA"]}],"parameters":{}}';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_COOKIEJAR, sys_get_temp_dir().'/gse_cookie.txt');
                curl_setopt($ch, CURLOPT_COOKIEFILE, sys_get_temp_dir().'/gse_cookie.txt');
                $http_headers = array(
                                    'Host: atla.gse.it',
                                    'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:131.0) Gecko/20100101 Firefox/131.0',
                                    'Accept: text/javascript, text/html, application/xml, application/json, text/xml',
                                    'Accept-Language: it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3',
                                    'Connection: keep-alive',
                                    'Referer: https://atla.gse.it/atlaimpianti/project/Atlaimpianti_Internet.html',
                                    'X-Range: items='.intVal($i+1).'-'.$nextTo,
                                    'Content-Type: application/json',
                                    'X-Requested-With: XMLHttpRequest'
                                );
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt ($ch, CURLOPT_POST, 1);
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $poststring);
                //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                $output = curl_exec ($ch);
                
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = explode("\r",substr($output, 0, $header_size));
                $nextImpianti=json_decode(substr($output, $header_size),true);
                if(!is_array($header) || $header[0] != "HTTP/1.1 200 OK")
                {
                    //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Errore nel recupero degli impianti dal: ".($i+1)." al: ".$nextTo." ".$output,FILE_APPEND);
                    die("Errore nel recupero degli impianti dal: ".($i+1)." al: ".$nextTo." ".$output);
                }

                if(!is_array($nextImpianti))
                {
                    //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Errore nel parsing degli impianti dal: ".($i+1)." al: ".$nextTo." ".$output,FILE_APPEND);
                    die("Errore nel parsing degli impianti dal: ".($i+1)." al: ".$nextTo." ".$output);
                }
                else
                {
                    //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Gli impianti dal: ".($i+1)." al: ".$nextTo." sono stati recuperati con successo.",FILE_APPEND);
                }

                $fetched+=sizeof($nextImpianti);
                $impianti = array_merge($impianti,$nextImpianti);
                //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Salvo gli impianti ".sizeof($impianti),FILE_APPEND);
                file_put_contents($resultFile,json_encode($impianti));

                curl_close($ch);
            }
        }
        else
        {
            //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Sono presenti n. ".sizeof($impianti)." impianti",FILE_APPEND);
            echo "\n".date("Y-m-d h:i:s")." - sono presenti n. ".sizeof($impianti)." impianti.";
        }

        //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Sono stati recuperati n. ".$fetched." nuovi impianti",FILE_APPEND);
        echo "\n".date("Y-m-d h:i:s")." - sono stati recuperati n. ".$fetched." nuovi impianti.";

        //richiesta info singolo impianto
        $fetched=0;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, sys_get_temp_dir().'/gse_cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, sys_get_temp_dir().'/gse_cookie.txt');
        $http_headers = array(
                            'Host: atla.gse.it',
                            'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:131.0) Gecko/20100101 Firefox/131.0',
                            'Accept: text/javascript, text/html, application/xml, application/json, text/xml',
                            'Accept-Language: it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3',
                            'Connection: keep-alive',
                            'Referer: https://atla.gse.it/atlaimpianti/project/Atlaimpianti_Internet.html',
                            'Content-Type: application/x-www-form-urlencoded',
                            'X-Requested-With: XMLHttpRequest',
                            'Sec-Fetch-Dest: empty',
                            'Sec-Fetch-Mode: cors',
                            'Sec-Fetch-Site: same-origin',
                            'Priority: u=0'
                        );
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_POST, 1);
        
        for($i=0; $i<sizeof($impianti); $i++ )
        {
            $itemId=$impianti[$i]['pk_sequ_georeferenze'];
            if(empty($impianti[$i]['details']))
            {
                //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Recupero delle info per l'impianto: ".$itemId." - (".$i."/".$maxCount.")",FILE_APPEND);
                echo "\n".date("Y-m-d h:i:s")." - Recupero delle info per l'impianto: ".$itemId." - (".$i."/".$maxCount.")";

                $url = 'https://atla.gse.it/atlaimpianti/rest/retrieveUserActionsForSingleRecord?request.preventCache='.time();
                $poststring = 'itemId='.$itemId.'&classGwid=137591&projectGwid=137590&projectName=Atlaimpianti_Internet';
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $poststring);
                //curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                $output = curl_exec ($ch);
                
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($output, 0, $header_size);
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = explode("\r",substr($output, 0, $header_size));
                $infoImpianto=json_decode(substr($output, $header_size),true);
                $bInsert=true;

                if(!is_array($header) || $header[0] != "HTTP/1.1 200 OK")
                {
                    //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Errore nel recupero delle info dell'impianto: ".print_r($impianti[$i],true)." - ".$output,FILE_APPEND);
                    echo " - Errore nel recupero delle informazioni dell'impianto: ".$itemId." - ".$output;
                    $bInsert=false;
                }

                if(!is_array($infoImpianto) || empty($infoImpianto['responseHashMap']['data']['itemDB']))
                {
                    //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Errore nel parsing delle info dell'impianto: ".print_r($impianti[$i],true)." - ".$output,FILE_APPEND);
                    echo " - Errore nel parsing delle informazioni dell'impianto: ".$itemId." - ".$output;
                    $bInsert=false;
                }
                
                if($bInsert)
                {
                    $impianti[$i]['details']=$infoImpianto['responseHashMap']['data']['itemDB'];
                    $fetched++;
                    
                    //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Le info dell'impianto: ".$impianti[$i]['pk_sequ_georeferenze']." sono state recuperate con successo.",FILE_APPEND);
                    echo " - OK";

                    if($fetched>=10) 
                    {
                        //file_put_contents($log_file,"\n------------------------------------------\n".date("Y-m-d h:i:s")." - Salvo il file impianti\n------------------------------------------\n",FILE_APPEND);
                        echo "\n------------------------------------\n".date("Y-m-d h:i:s")." - Salvo il file impianti\n------------------------------------\n";
                        file_put_contents($resultFile,json_encode($impianti));
                        $fetched=0;
                    }
                }
            }
            else
            {
                //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Le info dell'impianto: ".$impianti[$i]['pk_sequ_georeferenze']." sono gia' presenti.",FILE_APPEND);
                echo "\n".date("Y-m-d h:i:s")." - Le info dell'impianto: ".$impianti[$i]['pk_sequ_georeferenze']." sono gia' presenti.";
            }
        }
        curl_close($ch);

        if($fetched > 0)
        {
            //file_put_contents($log_file,"\n".date("Y-m-d h:i:s")." - Salvo il file impianti ".sizeof($impianti));
            echo "\n------------------------------------------\n".date("Y-m-d h:i:s")." - Salvo il file impianti n. ".sizeof($impianti);
            file_put_contents($resultFile,json_encode($impianti));
            $fetched=0;
        }
        //file_put_contents($resultFile,json_encode($impianti));
        //file_put_contents($log_file,"\n------------------------------------------\n".date("Y-m-d h:i:s")." - sono stati salvati n. ".sizeof($impianti));
        echo "\n------------------------------------------\n".date("Y-m-d h:i:s")." - sono stati salvati n. ".sizeof($impianti);
    }

    protected function TemplateGenericNavbar_Atti($level = 1, $last = false, $refresh_view = true)
    {
        $class = "n" . $level;
        if ($last) $class .= " AA_navbar_terminator_left";
        $navbar =  new AA_JSON_Template_Template(
            "",
            array(
                "type" => "clean",
                "section_id" => static::AA_ID_SECTION_PUBBLICATE,
                "module_id" => $this->GetId(),
                "refresh_view" => $refresh_view,
                "tooltip" => "Fai click per visualizzare la sezione relativa agli atti di concessione",
                "template" => "<div class='AA_navbar_link_box_left #class#'><a class='" . static::AA_UI_PREFIX . "_Navbar_Link_" . static::AA_UI_SECTION_PUBBLICATE_NAME . "' onClick='AA_MainApp.utils.callHandler(\"setCurrentSection\",\"".static::AA_ID_SECTION_PUBBLICATE."\",\"" . $this->id . "\")'><span class='#icon#' style='margin-right: .5em'></span><span>#label#</span></a></div>",
                "data" => array("label" => "Atti di concessione", "icon" => "mdi mdi-certificate", "class" => $class)
            )
        );
        return $navbar;
    }
    //istanza
    protected static $oInstance=null;
    
    //Restituisce l'istanza corrente
    public static function GetInstance($user=null)
    {
        if(self::$oInstance==null)
        {
            self::$oInstance=new AA_GeserModule($user);
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
        if($this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $bCanModify=true;
        }

        $content=$this->TemplateGenericSection_Pubblicate($params,$bCanModify);
        $content->EnableExportFunctions(false);
        //$content->EnableTrash(false);

        return $content->toObject();
    }

    //Template pubblicate content
    public function TemplateSection_Bozze($params=array())
    {
        $bCanModify=false;
        if($this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $bCanModify=true;
        }

        $params['enableAddNewMultiFromCsv']=true;
        $content=$this->TemplateGenericSection_Bozze($params,null);

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
        //tipo
        if(isset($params['tipo']) && $params['tipo'] > 0)
        {
            $params['where'][]=" AND ".AA_Geser::AA_DBTABLE_DATA.".tipologia = '".addslashes($params['tipo'])."'";
        }

        //stato
        if(isset($params['stato']) && $params['stato'] > 0)
        {
            $params['where'][]=" AND ".AA_Geser::AA_DBTABLE_DATA.".stato = '".addslashes($params['stato'])."'";
        }

        //comune
        if(isset($params['comune']) && $params['comune'] !="Qualunque")
        {
            $params['where'][]=" AND ".AA_Geser::AA_DBTABLE_DATA.".geolocalizzazione like '{\"comune\":\"".addslashes($params['comune'])."\"%'";
        }

        return $params;
    }

     //Personalizza il template dei dati delle schede pubblicate per il modulo corrente
     protected function GetDataSectionPubblicate_CustomDataTemplate($data = array(),$object=null)
     {
        $data['pretitolo']=$object->GetTipo();
        $tags="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$object->GetStato()."</span>";
        $potenza=$object->GetProp("Potenza");
        if(intVal($potenza)>0)
        {
            if($potenza < 1000) $tags.="&nbsp;<span class='AA_DataView_Tag AA_Label AA_Label_Orange'>".AA_Utils::number_format($object->GetProp("Potenza"),2,",",".")." KWatt</span>";
            else $tags.="&nbsp;<span class='AA_DataView_Tag AA_Label AA_Label_Orange'>".AA_Utils::number_format($object->GetProp("Potenza")/1000,2,",",".")." MWatt</span>";
        }
        $data['tags']=$tags;
        $geolocalizzazione=$object->GetGeolocalizzazione();
        if($geolocalizzazione['localita'] != "") $data['sottotitolo']="<span>".$geolocalizzazione['localita'].", ".$geolocalizzazione['comune']."</span>";
        else $data['sottotitolo']="<span>".$geolocalizzazione['comune']."</span>";

        return $data;
     }

    //Restituisce i dati delle bozze
    public function GetDataSectionBozze_List($params=array())
    {
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER) && !$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER_RO))
        {
            AA_Log::Log(__METHOD__." - ERRORE: l'utente corrente: ".$this->oUser->GetUserName()." non è abilitato alla visualizzazione delle bozze.",100);
            return array();
        }

        return $this->GetDataGenericSectionBozze_List($params,"GetDataSectionBozze_CustomFilter","GetDataSectionBozze_CustomDataTemplate");
    }

    //Personalizza il filtro delle bozze per il modulo corrente
    protected function GetDataSectionBozze_CustomFilter($params = array())
    {
        //tipo
        if(isset($params['tipo']) && $params['tipo'] > 0)
        {
            $params['where'][]=" AND ".AA_Geser::AA_DBTABLE_DATA.".tipologia = '".addslashes($params['tipo'])."'";
        }

        //stato
        if(isset($params['stato']) && $params['stato'] > 0)
        {
            $params['where'][]=" AND ".AA_Geser::AA_DBTABLE_DATA.".stato = '".addslashes($params['stato'])."'";
        }

        //comune
        if(isset($params['comune']) && $params['comune'] !="Qualunque")
        {
            $params['where'][]=" AND ".AA_Geser::AA_DBTABLE_DATA.".geolocalizzazione like '{\"comune\":\"".addslashes($params['comune'])."\"%'";
        }

        return $params;
    }

    //Personalizza il template dei dati delle bozze per il modulo corrente
    protected function GetDataSectionBozze_CustomDataTemplate($data = array(),$object=null)
    {
        
        if($object instanceof AA_Geser)
        {

            $data['pretitolo']=$object->GetTipo();
            $tags="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$object->GetStato()."</span>";
            $potenza=$object->GetProp("Potenza");
            if(intVal($potenza)>0)
            {
                if($potenza < 1000) $tags.="&nbsp;<span class='AA_DataView_Tag AA_Label AA_Label_Orange'>".AA_Utils::number_format($object->GetProp("Potenza"),2,",",".")." KWatt</span>";
                else $tags.="&nbsp;<span class='AA_DataView_Tag AA_Label AA_Label_Orange'>".AA_Utils::number_format($object->GetProp("Potenza")/1000,2,",",".")." MWatt</span>";
            }
            $data['tags']=$tags;
            $geolocalizzazione=$object->GetGeolocalizzazione();
            if($geolocalizzazione['localita'] != "" && $geolocalizzazione['localita'] !="n.d.") $data['sottotitolo']="<span>".$geolocalizzazione['localita'].", ".$geolocalizzazione['comune']."</span>";
            else $data['sottotitolo']="<span>".$geolocalizzazione['comune']."</span>";
        }

        return $data;
    }
    
    //Template publish dlg
    public function Template_GetGeserPublishDlg($params)
    {
        //lista organismi da pubblicare
        if($params['ids'])
        {
            $ids= json_decode($params['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Geser($curId,$this->oUser);
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
                else $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente elemento/accordo verrà pubblicato, vuoi procedere?")));

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
                $wnd->SetSaveTask('PublishGeser');
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
    public function Template_GetGeserDeleteDlg($params)
    {
        return $this->Template_GetGenericObjectDeleteDlg($params,"DeleteGeser");
    }
        
    //Template dlg addnew
    public function Template_GetGeserAddNewDlg()
    {
        $id=$this->GetId()."_AddNew_Dlg_".uniqid();
        
        $form_data=array();
        
        $form_data['Note']="";
        $form_data['AnnoAutorizzazione']="";
        $form_data['AnnoCostruzione']="";
        $form_data['AnnoEsercizio']="";
        $form_data['AnnoDismissione']="";
        $form_data['Stato']=0;
        $form_data['Tipologia']=0;
        $form_data['nome']="";
        $form_data['Potenza']="";
        $form_data['Superficie']="";
        $form_data['Geo_comune']="";
        $form_data['Geo_localita']="";
        $form_data['Geo_coordinate']="";

        $stato=AA_Geser_Const::GetListaStatiImpianto();
        $stato_options=array();
        foreach($stato as $num=>$val)
        {
            $stato_options[]=array("id"=>$num,"value"=>$val);
        }

        $tipologia=AA_Geser_Const::GetListaTipoImpianti();
        $tipo_options=array();
        foreach($tipologia as $num=>$val)
        {
            $tipo_options[]=array("id"=>$num,"value"=>$val);
        }

        $wnd=new AA_GenericFormDlg($id, "Aggiungi un nuovo impianto", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(1080);
        $wnd->SetHeight(720);
        $wnd->EnableValidation();

        //Tipologia
        $wnd->AddSelectField("Tipologia","Tipologia",array("required"=>true,"gravity"=>1.5,"validateFunction"=>"IsSelected","bottomPadding"=>32, "bottomLabel"=>"*Selezionare la tipologia di impianto.", "placeholder"=>"...","options"=>$tipo_options));
        
        //Stato
        $wnd->AddSelectField("Stato","Stato attuale",array("required"=>true,"gravity"=>1.5,"validateFunction"=>"IsSelected","bottomPadding"=>32, "bottomLabel"=>"*Selezionare lo stato attuale dell'impianto.", "placeholder"=>"...","options"=>$stato_options),false);
        
        //superficie
        $wnd->AddTextField("Superficie","Superficie",array("required"=>true,"gravity"=>1,"bottomPadding"=>32,"bottomLabel"=>"*Inserisci la superficie (mq) dell'impianto.", "placeholder"=>"es. 150"),false);

        //Nome
        $wnd->AddTextField("nome","Titolo",array("required"=>true,"gravity"=>3,"bottomPadding"=>32,"bottomLabel"=>"*Inserisci una denominazione per l'impianto.", "placeholder"=>"..."));

        //potenza
        $wnd->AddTextField("Potenza","Potenza",array("required"=>true,"gravity"=>1,"bottomPadding"=>32,"bottomLabel"=>"*Inserisci la potenza in megawatt dell'impianto.", "placeholder"=>"es. 150"),false);

        $section=new AA_FieldSet($id."_Riferimenti","Riferimenti temporali");

        //anno autorizzazione
        $section->AddDateField("AnnoAutorizzazione","Data autorizzazione",array("bottomPadding"=>32, "labelWidth"=>150,"bottomLabel"=>"*Inserisci l'anno in cui e' stata autorizzata la costruzione dell'impianto.", "placeholder"=>"es. 2024"));
        
        //anno costruzione
        $section->AddDateField("AnnoCostruzione","Data costruzione",array("bottomPadding"=>32, "labelWidth"=>150,"bottomLabel"=>"*Inserisci l'anno in cui e' stata terminata la costruzione dell'impianto.", "placeholder"=>"es. 2024"),false);

        //anno esercizio
        $section->AddDateField("AnnoEsercizio","Data esercizio",array("bottomPadding"=>32, "labelWidth"=>150,"bottomLabel"=>"*Inserisci l'anno in cui l'impianto e' entrato in esercizio.", "placeholder"=>"es. 2024"));

        //anno dismissione
        $section->AddDateField("AnnoDismissione","Data dismissione",array("bottomPadding"=>32,"labelWidth"=>150, "bottomLabel"=>"*Inserisci l'anno in cui l'impianto e' stato dismesso.", "placeholder"=>"es. 2024"),false);

        $wnd->AddGenericObject($section);

        //Norma
        $section=new AA_FieldSet($id."_Geolocalizzazione","Geolocalizzazione");

        //localita'
        $section->AddTextField("Geo_localita","Localita'",array("required"=>true, "gravity"=>3,"labelWidth"=>90,"bottomLabel"=>"*Inserisci la localita'/indirizzo dell'impianto.", "placeholder"=>"..."));

        //comune
        $section->AddTextField("Geo_comune","Comune",array("required"=>true, "gravity"=>2,"bottomPadding"=>38,"labelWidth"=>90,"bottomLabel"=>"*Inserisci il Comune in cui e' sito l'impianto.", "placeholder"=>"es. Cagliari","suggest"=>array("template"=>"#value#","url"=>$this->taskManagerUrl."?task=GetGeserListaCodiciIstat")));

        //coordinate
        $section->AddTextField("Geo_coordinate","Coordinate",array("gravity"=>1,"bottomPadding"=>38,"labelWidth"=>90, "bottomLabel"=>"*Coordinate geografiche dell'impianto (formato: latitudine,longitudine).", "placeholder"=>"es. 39.217199,9.113311"),false);

        $wnd->AddGenericObject($section);

        //Note
        $label="Note";
        $wnd->AddTextareaField("Note",$label,array("labelWidth"=>90,"bottomLabel"=>"*Eventuali annotazioni (max 4096 caratteri).", "placeholder"=>"Inserisci qui le note..."));
        
        $wnd->EnableCloseWndOnSuccessfulSave();

        $wnd->SetSaveTask("AddNewGeser");
        
        return $wnd;
    }

    //Template dlg addnew geco da csv
    public function Template_GetGeserAddNewMultiDlg()
    {
        $id=static::AA_UI_PREFIX."_GetGeserAddNewMultiDlg_".uniqid();

        $form_data=array();

        $platform=AA_Platform::GetInstance($this->oUser);

        $wnd=new AA_GenericFormDlg($id, "Caricamento multiplo da file CSV", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(600);
        $wnd->SetBottomPadding(36);
        $wnd->EnableValidation();

        $descr="<ul>Il file csv deve avere le seguenti caratteristiche:";
        $descr.="<li>la prima riga deve contenere i nomi dei campi;</li>";
        $descr.="<li>la codifica dei caratteri deve essere in formato UTF-8;</li>";
        $descr.="<li>il carattere \"|\" (pipe) deve essere utilizzato come separatore dei campi;</li>";
        $descr.="</ul>";
        //$descr.="<p>Tramite il seguente <a href='".$platform->GetModulePathURL($this->GetId())."/docs/geco_addnew_multi.ods' target='_blank'>link</a> è possibile scaricare un foglio elettronico da utilizzarsi come base per la predisposizione del file csv.</p>";
        $descr.="<p>Per la generazione del file csv si consiglia l'utilizzo del software opensource <a href='https://www.libreoffice.org' target='_blank'>Libreoffice</a> in quanto consente di impostare il carattere di delimitazione dei campi e la codifica dei caratteri in fase di esportazione senza dover apportare modifiche al sistema.</p>";
        $descr.="<hr/>";

        $wnd->AddGenericObject(new AA_JSON_Template_Template("",array("type"=>"clean","autoheight"=>true,"template"=>"<div style='margin-bottom: 1em;'>Questa funzionalità permette di generare più bozze tramite importazione da file csv.".$descr."</div>")));
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("height"=>30)));

        $options=array(
            array("id"=>5,"value"=>"Ass. Ambiente - VIA Regionale"),
            array("id"=>5,"value"=>"Ass. Ambiente - VIA Nazionale"),
            array("id"=>2,"value"=>"Ass. Industria"),
            array("id"=>3,"value"=>"Suape"),
            array("id"=>1,"value"=>"Terna"),
            array("id"=>4,"value"=>"GSE")
        );

        $wnd->AddSelectField("tracciato","Tipo tracciato",array("required"=>true,"validateFunction"=>"IsSelected","bottomPadding"=>32, "bottomLabel"=>"*Selezionare il tipo di importazione.", "placeholder"=>"...","options"=>$options));
        
        //csv
        $wnd->AddFileUploadField("GeserAddNewMultiCSV","Scegli il file csv...", array("required"=>true,"validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti in formato csv (dimensione max: 2Mb).","accept"=>"application/csv"));

        $wnd->EnableCloseWndOnSuccessfulSave();

        $wnd->enableRefreshOnSuccessfulSave(false);

        $wnd->SetApplyButtonName("Procedi");

        $wnd->SetSaveTask("GetGeserAddNewMultiPreviewCalc");
        
        return $wnd;
    }

    //Template dlg addnew multi preview
    public function Template_GetGeserAddNewMultiPreviewDlg()
    {
        $id=static::AA_UI_PREFIX."_GetGeserAddNewMultiPreviewDlg_".uniqid();

        $form_data=array();
        
        $wnd=new AA_GenericFormDlg($id, "Caricamento multiplo da file CSV - fase 2 di 3", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        //$wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(1280);
        $wnd->SetHeight(720);
        //$wnd->SetBottomPadding(36);
        //$wnd->EnableValidation();
        //anno	titolo	descrizione	responsabile	norma_estremi	norma_link	modalita_tipo	modalita_link	importo_impegnato	importo_erogato	beneficiario_nominativo	beneficiario_cf	beneficiario_piva	beneficiario_persona_fisica	beneficiario_privacy	note

        $columns=array(
            //array("id"=>"anno","header"=>array("<div style='text-align: center'>Anno</div>",array("content"=>"selectFilter")),"width"=>60, "css"=>array("text-align"=>"left"),"sort"=>"text"),
            array("id"=>"titolo","header"=>array("<div style='text-align: center'>Descrizione</div>",array("content"=>"textFilter")),"fillspace"=>true,"sort"=>"text","css"=>"PraticheTable_left"),
            array("id"=>"tipologia","header"=>array("<div style='text-align: center'>Tipologia</div>",array("content"=>"selectFilter")),"width"=>200, "sort"=>"text","css"=>"PraticheTable"),
            array("id"=>"potenza","header"=>array("<div style='text-align: center'>Potenza (KW)</div>",array("content"=>"textFilter")),"width"=>120, "sort"=>"text","css"=>"PraticheTable"),
            array("id"=>"comune","header"=>array("<div style='text-align: center'>Comune</div>",array("content"=>"selectFilter")),"width"=>250, "sort"=>"text","css"=>"PraticheTable"),
            array("id"=>"date","header"=>array("<div style='text-align: center'>Date</div>",array("content"=>"textFilter")),"width"=>250, "css"=>"PraticheTable_left"),
            array("id"=>"nuovo","header"=>array("<div style='text-align: center'>Nuovo</div>",array("content"=>"selectFilter")),"width"=>60, "css"=>"PraticheTable")
        );

        $data=AA_SessionVar::Get("GeserAddNewMultiFromCSV_ParsedData")->GetValue();

        if(!is_array($data))
        {
            AA_Log::Log(__METHOD__." - dati csv non validi: ".print_r($data,TRUE),100);
            $data=array();
        }

        $tipologiaImpianti=AA_Geser_Const::GetListaTipoImpianti();
        $tabledata=array();
        $nuovi_inserimenti=0;
        foreach($data as $key=>$row)
        {
            if($row['id_impianto']!=0) 
            {
                $impianto=new AA_Geser($row['id_impianto'],$this->oUser);
                $geolocalizzazione=$impianto->GetProp('geolocalizzazione');
                $tabledata[]=array(
                    "titolo"=>$impianto->GetProp('nome'),
                    "tipologia"=>$impianto->GetTipo(),
                    "potenza"=>AA_Utils::number_format($impianto->GetProp('Potenza'),2,",","."),
                    "comune"=>$geolocalizzazione['comune'],
                    "date"=>"<div style='display: flex;flex-direction: column;justify-content: space-between;align-items: start;font-size: smaller;'><div>autorizzazione: ".$impianto->GetProp('AnnoAutorizzazione')."</div><div>inizio lavori: ".$impianto->GetProp('InizioLavori')."</div><div>costruzione: ".$impianto->GetProp('AnnoCostruzione')."</div><div>esercizio: ".$impianto->GetProp('AnnoEsercizio')."</div><div>dismissione: ".$impianto->GetProp('AnnoDismissione')."</div></div>",
                    "nuovo"=>"No"
                );
            }
            else
            {
                $tabledata[]=array(
                    "titolo"=>$row['nome'],
                    "tipologia"=>$tipologiaImpianti[$row['Tipologia']],
                    "potenza"=>AA_Utils::number_format($row['Potenza'],2,",","."),
                    "comune"=>$row['Geo_comune'],
                    "date"=>"<div style='display: flex;flex-direction: column;justify-content: space-between;align-items: start;font-size: smaller;'><div>autorizzazione: ".$row['AnnoAutorizzazione']."</div><div>inizio lavori: ".$row['InizioLavori']."</div><div>costruzione: ".$row['AnnoCostruzione']."</div><div>esercizio: ".$row['AnnoEsercizio']."</div><div>dismissione: ".$row['AnnoDismissione']."</div></div>",
                    "nuovo"=>"Si"
                );
                $nuovi_inserimenti++;
            }
        }
        //AA_Log::Log(__METHOD__." - dati csv: ".print_r($data,TRUE),100);

        $desc="<p>Sono stati riconosciuti <b>".$nuovi_inserimenti." nuovi impianti</b>.<br>Verranno aggiornati ".(sizeof((array)$data)-$nuovi_inserimenti)." impianti esistenti</p>";
        $wnd->AddGenericObject(new AA_JSON_Template_Template("",array("style"=>"clean","template"=>$desc,"autoheight"=>true)));

        $scrollview=new AA_JSON_Template_Generic($id."_ScrollCsvImportPreviewTable",array(
            "type"=>"clean",
            "view"=>"scrollview",
            "scroll"=>"x"
        ));
        $table=new AA_JSON_Template_Generic($id."_CsvImportPreviewTable", array(
            "view"=>"datatable",
            "css"=>"AA_Header_DataTable",
            "hover"=>"AA_DataTable_Row_Hover",
            "fixedRowHeight"=>false,
            "rowHeight"=>90,
            "rowLineHeight"=>18,
            "eventHandlers"=>array("onresize"=>array("handler"=>"adjustRowHeight","module_id"=>$this->GetId())),
            "columns"=>$columns,
            "data"=>array_values($tabledata)
        ));
        $scrollview->addRowToBody($table);

        $wnd->AddGenericObject($scrollview);

        $wnd->EnableCloseWndOnSuccessfulSave();

        //$wnd->enableRefreshOnSuccessfulSave();

        $wnd->SetApplyButtonName("Procedi");

        $wnd->SetSaveTask("AddNewMultiGeser");
        
        return $wnd;
    }

    //Visualizza il risultato dell'importazione da csv
    public function Template_GetGeserAddNewMultiResultDlg()
    {
        $id=$this->GetId()."_AddNewMultiResult_Dlg_".uniqid();
        
        $wnd=new AA_GenericWindowTemplate($id, "Caricamento multiplo da file CSV - fase 3 di 3");
        
        //$wnd->SetLabelAlign("right");
        //$wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(350);
        //$wnd->SetBottomPadding(36);
        //$wnd->EnableValidation();

        $data=AA_SessionVar::Get("GeserAddNewMultiResult")->GetValue();
        //elimina le variabili di sessione
        AA_SessionVar::UnsetVar("GeserAddNewMultiResult");

        if(!is_array($data))
        {
            AA_Log::Log(__METHOD__." - dati result non validi: ".print_r($data,TRUE),100);
            $data=array();
            $desc="Non sono stati trovati i risultati di importazione da csv.";
            $wnd->AddView(new AA_JSON_Template_Template("",array("style"=>"clean","template"=>$desc,"autoheight"=>true)));
            return $wnd;
        }

        $desc="<p>Sono stati inseriti <b>".$data[0]." nuovi impianti in bozza</b>.</p>";
        if($data[1] > 0) $desc.="<p>Sono stati modificati <b>".$data[1]." impianti pubblicati esistenti</b>.</p>";
        $wnd->AddView(new AA_JSON_Template_Template("",array("style"=>"clean","template"=>$desc,"autoheight"=>true)));
        
        return $wnd;
    }

    //Template confirm 
    public function Template_GetGeserConfirmPrivacyDlg($form_id='')
    {
        $id=$this->GetId()."_".uniqid();

        $wnd=new AA_GenericWindowTemplate($id, "Conferma oscuramento dati personali", $this->id);
        
        $wnd->SetWidth(540);
        $wnd->SetHeight(400);
        
        $layout=new AA_JSON_Template_Layout("",array("type"=>"clean"));

        $template="<div style='display: flex; justify-content: center; align-items: center; flex-direction:column'><p class='blinking' style='font-size: larger;font-weight:900;color: red'>ATTENZIONE!</p><p style='padding:10px'>Dalla pubblicazione e' possibile ricavare, <u>anche solo potenzialmente</u>, informazioni relative allo <b>stato di salute</b> e/o alla situazione di <b>disagio economico-sociale</b> del beneficiario?</p></div>";
        $layout->AddRow(new AA_JSON_Template_Template($id."_Content",array("type"=>"clean","autoheight"=>true,"template"=>$template)));

        $flag_action='AA_MainApp.utils.callHandler("flagPrivacy", { form: "'.$form_id.'",value : 1}, "'.$this->GetId().'");$$("'.$id.'_Wnd").close();';
        $unflag_action='AA_MainApp.utils.callHandler("flagPrivacy", { form: "'.$form_id.'",value : 0}, "'.$this->GetId().'");$$("'.$id.'_Wnd").close();';

        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));
        $toolbar=new AA_JSON_Template_Toolbar("",array("type"=>"clean","borderless"=>true));

        //oscura i dati personali
        $flag_btn=new AA_JSON_Template_Generic("",array(
            "view"=>"button",
            "type"=>"icon",
            "icon"=>"mdi mdi-check-circle",
            "label"=>"Si",
            "css"=>"webix_primary",
            "align"=>"center",
            "inputWidth"=>80,
            "click"=>$flag_action,
            "tooltip"=>"Oscura i dati personali."
        ));

        //manuale operatore comunale
        $unflag_btn=new AA_JSON_Template_Generic("",array(
            "view"=>"button",
            "type"=>"icon",
            "icon"=>"mdi mdi-alert-circle",
            "label"=>"No",
            "align"=>"center",
            "inputWidth"=>80,
            "click"=>$unflag_action,
            "tooltip"=>"Lascia in chiaro i dati personali."
        ));

        $toolbar->addElement($unflag_btn);
        $toolbar->addElement(new AA_JSON_Template_Generic(""));
        $toolbar->addElement($flag_btn);
        $layout->AddRow($toolbar);
        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));

        $wnd->AddView($layout);
        
        return $wnd;
    }

    //Template dlg aggiungi allegato/link
    public function Template_GetGeserAddNewAllegatoDlg($object=null)
    {
        $id=uniqid();
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array();
        $wnd=new AA_GenericFormDlg($id, "Aggiungi allegato/link", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(520);

        //Tipo
        $options=array();
        $tipo_allegati=AA_Geser_Const::GetListaTipoAllegati();
        foreach($tipo_allegati as $key=>$val)
        {
            $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("tipo", "Tipologia", array("gravity"=>1,"required"=>true,"validateFunction"=>"IsSelected","bottomLabel" => "*Scegliere la tipologia di allegato/link", "placeholder" => "Scegli un elemento della lista...","options"=>$options));
        
        //Descrizione
        $wnd->AddTextField("descrizione", "Descrizione", array("gravity"=>1,"required"=>true,"bottomLabel" => "*Inserisci una breve descrizione dell'allegato/link","placeholder" => "es. DGR..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>30)));
        
        //categorie
        /*$tipi=AA_Geser_Const::GetCategorieAllegati();$curRow=1;
        $section=new AA_FieldSet($id."_Section_Tipo","Categorie");
        $curRow=0;
        foreach($tipi as $tipo=>$descr)
        {
            $newLine=false;
            if($curRow%4 == 0 && $curRow >= 4) $newLine=true;
            $section->AddCheckBoxField("tipo_".$tipo, $descr, array("value"=>1,"bottomPadding"=>8,"labelWidth"=>160),$newLine);
            $curRow++;
        }
        $wnd->AddGenericObject($section);
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>30)));
        //----------------------
        */
        //file upload------------------
        $wnd->SetFileUploaderId($id."_Section_Url_FileUpload_Field");

        $section=new AA_FieldSet($id."_Section_Url","Inserire un'url oppure scegliere un file");

        //url
        $section->AddTextField("url", "Url", array("validateFunction"=>"IsUrl","bottomLabel"=>"*Indicare un'URL sicura, es. https://www.regione.sardegna.it", "placeholder"=>"https://..."));
        
        $section->AddGenericObject(new AA_JSON_Template_Template("",array("type"=>"clean","template"=>"<hr/>","height"=>18)));

        //file
        $section->AddFileUploadField("NewAllegatoDoc","", array("validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti pdf o file zip (dimensione max: 30Mb).","accept"=>"application/pdf,application/zip"));
        
        $wnd->AddGenericObject($section);
        //---------------------------------

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("AddNewGeserAllegato");
        
        return $wnd;
    }

    //Template dlg aggiungi pratica
    public function Template_GetGeserAddNewPraticaDlg($object=null)
    {
        $id=uniqid();
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        if(!($object instanceof AA_Geser))
        {
            return new AA_GenericWindowTemplate(uniqid(),"Aggiungi nuova pratica",$this->GetId());
        }

        $form_data=array();
        $form_data['id']=$object->GetId();
        $wnd=new AA_GenericFormDlg($id, "Aggiungi nuova pratica", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(980);
        $wnd->SetHeight(680);

        //tipo
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaTipoPratica();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("tipo","Tipo",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare il tipo di pratica.","options"=>$options));

        //stato
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaStatiPratica();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("stato","Stato",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare lo stato della pratica.","options"=>$options),false);

        //Estremi
        $wnd->AddTextField("estremi", "Estremi", array("gravity"=>2,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci il numero e la data della pratica.","placeholder" => "es. prot. n.xx del xxxx/xx/xx..."));

        //via
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaTipoVia();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("via","Tipo VIA",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare il tipo di VIA.","options"=>$options),false);

        //descrizione
        $wnd->AddTextField("descrizione", "Descrizione", array("gravity"=>2,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci una breve descrizione (max 200 caratteri).","placeholder" => "..."));
        
        //societa'
        $wnd->AddTextField("societa", "Ragione sociale'", array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci la denominazione della societa' richiedente.","placeholder" => "..."));

        //riferimenti temporali
        $section=new AA_FieldSet($id."_Riferimenti","Riferimenti temporali");

        //data inizio
        $section->AddDateField("data_inizio","Data inizio",array("bottomPadding"=>32, "labelAlign"=>"right","labelWidth"=>150,"bottomLabel"=>"*Indica la data di inizio del procedimento."));
        //data fine
        $section->AddDateField("data_fine","Data fine",array("bottomPadding"=>32, "labelAlign"=>"right","labelWidth"=>150,"bottomLabel"=>"*Indica la data di conclusione del procedimento."),false);
        $wnd->AddGenericObject($section);

        //note
        $wnd->AddTextareaField("note", "Note", array("gravity"=>1,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*eventuali note (max 1024 caratteri).","placeholder" => "..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>20)));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("AddNewGeserPratica");
        
        return $wnd;
    }

    //Template dlg modifica pratica
    public function Template_GetGeserModifyPraticaDlg($object=null,$pratica=null)
    {
        $id=uniqid();
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        if(!($object instanceof AA_Geser) || !is_array($pratica))
        {
            return new AA_GenericWindowTemplate(uniqid(),"Modifica pratica esistente",$this->GetId());
        }

        $form_data=array();
        $form_data['id']=$object->GetId();
        $form_data['id_pratica']=$pratica['id'];
        $form_data['stato']=$pratica['stato'];
        $form_data['tipo']=$pratica['tipo'];
        $form_data['estremi']=$pratica['estremi'];
        $form_data['descrizione']=$pratica['descrizione'];
        $form_data['via']=$pratica['via'];
        $form_data['societa']=$pratica['societa'];
        $form_data['data_inizio']=$pratica['data_inizio'];
        $form_data['data_fine']=$pratica['data_fine'];
        $form_data['note']=$pratica['note'];

        $wnd=new AA_GenericFormDlg($id, "Modifica pratica n. ".$pratica['id'], $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(980);
        $wnd->SetHeight(680);

        //tipo
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaTipoPratica();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("tipo","Tipo",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare il tipo di pratica.","options"=>$options));

        //stato
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaStatiPratica();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("stato","Stato",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare lo stato della pratica.","options"=>$options),false);

        //Estremi
        $wnd->AddTextField("estremi", "Estremi", array("gravity"=>2,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci il numero e la data della pratica.","placeholder" => "es. prot. n.xx del xxxx/xx/xx..."));

        //via
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaTipoVia();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("via","Tipo VIA",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare il tipo di VIA.","options"=>$options),false);

        //descrizione
        $wnd->AddTextField("descrizione", "Descrizione", array("gravity"=>2,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci una breve descrizione (max 200 caratteri).","placeholder" => "..."));
        
        //societa'
        $wnd->AddTextField("societa", "Ragione sociale'", array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci la denominazione della societa' richiedente.","placeholder" => "..."));

        //riferimenti temporali
        $section=new AA_FieldSet($id."_Riferimenti","Riferimenti temporali");

        //data inizio
        $section->AddDateField("data_inizio","Data inizio",array("bottomPadding"=>32, "labelAlign"=>"right","labelWidth"=>150,"bottomLabel"=>"*Indica la data di inizio del procedimento."));
        //data fine
        $section->AddDateField("data_fine","Data fine",array("bottomPadding"=>32, "labelAlign"=>"right","labelWidth"=>150,"bottomLabel"=>"*Indica la data di conclusione del procedimento."),false);
        $wnd->AddGenericObject($section);

        //note
        $wnd->AddTextareaField("note", "Note", array("gravity"=>1,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*eventuali note (max 1024 caratteri).","placeholder" => "..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>20)));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("UpdateGeserPratica");
        
        return $wnd;
    }

    //Template dlg copia pratica
    public function Template_GetGeserCopyPraticaDlg($object=null,$pratica=null)
    {
        $id=uniqid();
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        if(!($object instanceof AA_Geser) || !is_array($pratica))
        {
            return new AA_GenericWindowTemplate(uniqid(),"Copia pratica esistente",$this->GetId());
        }

        $form_data=array();
        $form_data['id']=$object->GetId();
        $form_data['stato']=$pratica['stato'];
        $form_data['tipo']=$pratica['tipo'];
        $form_data['estremi']=$pratica['estremi'];
        $form_data['descrizione']=$pratica['descrizione'];
        $form_data['via']=$pratica['via'];
        $form_data['societa']=$pratica['societa'];
        $form_data['data_inizio']=$pratica['data_inizio'];
        $form_data['data_fine']=$pratica['data_fine'];
        $form_data['note']=$pratica['note'];

        $wnd=new AA_GenericFormDlg($id, "Copia pratica n. ".$pratica['id'], $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(980);
        $wnd->SetHeight(680);

        //tipo
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaTipoPratica();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("tipo","Tipo",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare il tipo di pratica.","options"=>$options));

        //stato
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaStatiPratica();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("stato","Stato",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare lo stato della pratica.","options"=>$options),false);

        //Estremi
        $wnd->AddTextField("estremi", "Estremi", array("gravity"=>2,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci il numero e la data della pratica.","placeholder" => "es. prot. n.xx del xxxx/xx/xx..."));

        //via
        $options=array();
        $listaTipo=AA_Geser_Const::GetListaTipoVia();
        foreach($listaTipo as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("via","Tipo VIA",array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","validateFunction"=>"IsSelected","bottomLabel"=>"*Selezionare il tipo di VIA.","options"=>$options),false);

        //descrizione
        $wnd->AddTextField("descrizione", "Descrizione", array("gravity"=>2,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci una breve descrizione (max 200 caratteri).","placeholder" => "..."));
        
        //societa'
        $wnd->AddTextField("societa", "Ragione sociale'", array("gravity"=>1,"required"=>true,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*Inserisci la denominazione della societa' richiedente.","placeholder" => "..."));

        //riferimenti temporali
        $section=new AA_FieldSet($id."_Riferimenti","Riferimenti temporali");

        //data inizio
        $section->AddDateField("data_inizio","Data inizio",array("bottomPadding"=>32, "labelAlign"=>"right","labelWidth"=>150,"bottomLabel"=>"*Indica la data di inizio del procedimento."));
        //data fine
        $section->AddDateField("data_fine","Data fine",array("bottomPadding"=>32, "labelAlign"=>"right","labelWidth"=>150,"bottomLabel"=>"*Indica la data di conclusione del procedimento."),false);
        $wnd->AddGenericObject($section);

        //note
        $wnd->AddTextareaField("note", "Note", array("gravity"=>1,"labelWidth"=>150,"labelAlign"=>"right","bottomLabel" => "*eventuali note (max 1024 caratteri).","placeholder" => "..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>20)));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("AddNewGeserPratica");
        
        return $wnd;
    }

    //Template dlg modifca allegato/link
    public function Template_GetGeserModifyAllegatoDlg($object=null,$allegato=null)
    {
        $id=static::AA_UI_PREFIX."_GetGeserModifyAllegatoDlg";
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array();
        $form_data["descrizione"]=$allegato['descrizione'];
        $form_data["url"]=$allegato['url'];
        $form_data["tipo"]=$allegato['tipo'];

        $wnd=new AA_GenericFormDlg($id, "Modifica allegato/link", $this->id,$form_data,$form_data);

        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(520);

        //Tipo
        $options=array();
        $tipo_allegati=AA_Geser_Const::GetListaTipoAllegati();
        foreach($tipo_allegati as $key=>$val)
        {
            $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddSelectField("tipo", "Tipologia", array("gravity"=>1,"required"=>true,"validateFunction"=>"IsSelected","bottomLabel" => "*Scegliere la tipologia di allegato/link", "placeholder" => "Scegli un elemento della lista...","options"=>$options));
        
        //Descrizione
        $wnd->AddTextField("descrizione", "Descrizione", array("gravity"=>1,"required"=>true,"bottomLabel" => "*Inserisci una breve descrizione dell'allegato/link","placeholder" => "es. DGR..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>30)));
        
        //file upload------------------
        $wnd->SetFileUploaderId($id."_Section_Url_FileUpload_Field");

        $section=new AA_FieldSet($id."_Section_Url","Inserire un'url oppure scegliere un file");

        //url
        $section->AddTextField("url", "Url", array("validateFunction"=>"IsUrl","bottomLabel"=>"*Indicare un'URL sicura, es. https://www.regione.sardegna.it", "placeholder"=>"https://..."));
        
        $section->AddGenericObject(new AA_JSON_Template_Template("",array("type"=>"clean","template"=>"<hr/>","height"=>18)));

        //file
        $section->AddFileUploadField("NewAllegatoDoc","", array("validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti pdf o file zip (dimensione max: 30Mb).","accept"=>"application/pdf,application/zip"));
        
        $wnd->AddGenericObject($section);
        //---------------------------------

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_allegato"=>$allegato['id']));
        $wnd->SetSaveTask("UpdateGeserAllegato");
        
        return $wnd;
    }

    //Template dlg trash pratica
    public function Template_GetGeserTrashPraticaDlg($object=null,$pratica=null)
    {
        $id=uniqid();
        
        $form_data=array();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina pratica", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(400);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $tabledata[]=array("descrizione"=>$pratica['descrizione'],"estremi"=>$pratica['estremi']);
      
        $template="<div style='display: flex; justify-content: center; align-items: center; flex-direction:column'><p class='blinking' style='font-size: larger;font-weight:900;color: red'>ATTENZIONE!</p></div>";
        $wnd->AddGenericObject(new AA_JSON_Template_Template($id."_Content",array("type"=>"clean","autoheight"=>true,"template"=>$template)));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"La seguente pratica verrà eliminata, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "columns"=>array(
              array("id"=>"descrizione", "header"=>"Descrizione", "fillspace"=>true),
              array("id"=>"estremi", "header"=>"Estremi", "fillspace"=>true)
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("DeleteGeserPratica");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_pratica"=>$pratica['id']));
        
        return $wnd;
    }

    //Template dlg trash allegato
    public function Template_GetGeserTrashAllegatoDlg($object=null,$allegato=null)
    {
        $id=uniqid();
        
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
        $url=$allegato['url'];
        if($url =="") $url="file locale";
        $tabledata[]=array("descrizione"=>$allegato['descrizione'],"url"=>$url);
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente allegato/link verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "columns"=>array(
              array("id"=>"descrizione", "header"=>"Descrizione", "fillspace"=>true),
              array("id"=>"url", "header"=>"Url", "fillspace"=>true)
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("DeleteGeserAllegato");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_allegato"=>$allegato['id']));
        
        return $wnd;
    }

    //Task Aggiungi allegato
    public function Task_AddNewGeserAllegato($task)
    {        
        $uploadedFile = AA_SessionFileUpload::Get("NewAllegatoDoc");

        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);
            
            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }     

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'], $this->oUser);
        
        if(!$object->isValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo elemento non valido o permessi insufficienti. (".$_REQUEST['id'].")",false);

            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }     

            return false;
        }
        
        if($object->IsReadOnly())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente (".$this->oUser->GetNome().") non ha i privileggi per modificare l'elemento: ".$object->GetName(),false);

            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }     

            return false;            
        }

        if(!isset($_REQUEST['descrizione']) || $_REQUEST['descrizione'] == "")
        {   
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($uploadedFile,true)." - ".print_r($_REQUEST,true),100);
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Parametri non validi occorre specificare una descrizione.",false);
            
            return false;
        }

        if(!isset($_REQUEST['tipo']) || $_REQUEST['tipo'] <= 0)
        {   
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($uploadedFile,true)." - ".print_r($_REQUEST,true),100);
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Parametri non validi occorre specificare una tipo di allegato/link.",false);
            
            return false;
        }

        if(!$uploadedFile->isValid() && $_REQUEST['url'] == "")
        {   
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($uploadedFile,true)." - ".print_r($_REQUEST,true),100);
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Parametri non validi occorre indicare un url o un file.",false);
            
            return false;
        }
        
        $fileHash="";
        if($uploadedFile->isValid()) 
        {
            //Se c'è un file uploadato l'url non viene salvata.
            $_REQUEST['url']="";

            $storage=AA_Storage::GetInstance($this->oUser);
            if($storage->IsValid())
            {
                $file=$uploadedFile->GetValue();
                $storageFile=$storage->Addfile($file['tmp_name'],$file['name'],$file['type'],1);
                if($storageFile->IsValid())
                {
                    $fileHash=$storageFile->GetFileHash();
                }
                else
                {
                    AA_Log::Log(__METHOD__." - errore nell'aggiunta allo storage. file non salvato.",100);
                }
            }
            else AA_Log::Log(__METHOD__." - storage non inizializzato. file non salvato.",100);

            //Elimina il file temporaneo
            if(file_exists($file['tmp_name']))
            {
                if(!unlink($file['tmp_name']))
                {
                    AA_Log::Log(__METHOD__." - errore nella rimozione del file: ".$file['tmp_name'],100);
                }
            }
        }

        $allegati=$object->GetAllegati();
        $allegati[uniqid()]=array(
            "descrizione"=>$_REQUEST['descrizione'],
            "tipo"=>$_REQUEST['tipo'],
            "url"=>$_REQUEST['url'],
            "filehash"=>$fileHash
        );

        if(sizeof($allegati) > 0)
        {
            $object->SetAllegati($allegati);

            if(!$object->Update($this->oUser,true,"Aggiunta allegato/link"))
            {
                $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
                $task->SetError("Errore nell'aggiunta allegato/link.",false);

                return false;
            }
            else
            {
                $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
                $task->SetContent("Allegato/link aggiunto con successo.",false);

                return true;
            }
        }

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent("Nessun allegato o link da aggiungere.",false);
        return true;
    }

    //Template dlg modify geser
    public function Template_GetGeserModifyDlg($object=null)
    {
        $id=$this->GetId()."_Modify_Dlg_".uniqid();
        if(!($object instanceof AA_Geser)) return new AA_GenericWindowTemplate($id, "Modifica i dati generali dell'impianto", $this->id);

        $form_data=array();
        
        $form_data['id']=$object->GetId();
        $form_data['Note']=$object->GetProp("Note");
        $form_data['AnnoAutorizzazione']=$object->GetProp("AnnoAutorizzazione");
        $form_data['AnnoCostruzione']=$object->GetProp("AnnoCostruzione");
        $form_data['AnnoEsercizio']=$object->GetProp("AnnoEsercizio");
        $form_data['AnnoDismissione']=$object->GetProp("AnnoDismissione");
        $form_data['Stato']=$object->GetProp("Stato");;
        $form_data['Tipologia']=$object->GetProp("Tipologia");
        $form_data['nome']=$object->GetName();
        $form_data['Potenza']=AA_Utils::number_format($object->GetProp("Potenza"),2,",",".");
        $form_data['Superficie']=AA_Utils::number_format($object->GetProp("Superficie"),2,",",".");
       
        $geolocalizzazione=$object->GetGeolocalizzazione();
        if(sizeof($geolocalizzazione)==0)
        {
            $form_data['Geo_comune']="";
            $form_data['Geo_localita']="";
            $form_data['Geo_coordinate']="";
        }
        else
        {
            $form_data['Geo_comune']=$geolocalizzazione['comune'];
            $form_data['Geo_localita']=$geolocalizzazione['localita'];
            $form_data['Geo_coordinate']=$geolocalizzazione['coordinate'];
        }

        $stato=AA_Geser_Const::GetListaStatiImpianto();
        $stato_options=array();
        foreach($stato as $num=>$val)
        {
            $stato_options[]=array("id"=>$num,"value"=>$val);
        }

        $tipologia=AA_Geser_Const::GetListaTipoImpianti();
        $tipo_options=array();
        foreach($tipologia as $num=>$val)
        {
            $tipo_options[]=array("id"=>$num,"value"=>$val);
        }

        $wnd=new AA_GenericFormDlg($id, "Aggiungi un nuovo impianto", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(1280);
        $wnd->SetHeight(720);
        $wnd->EnableValidation();

        //Tipologia
        $wnd->AddSelectField("Tipologia","Tipologia",array("required"=>true,"gravity"=>1.5,"validateFunction"=>"IsSelected","bottomPadding"=>32, "bottomLabel"=>"*Selezionare la tipologia di impianto.", "placeholder"=>"...","options"=>$tipo_options));
        
        //Stato
        $wnd->AddSelectField("Stato","Stato attuale",array("required"=>true,"gravity"=>1.5,"validateFunction"=>"IsSelected","bottomPadding"=>32, "bottomLabel"=>"*Selezionare lo stato attuale dell'impianto.", "placeholder"=>"...","options"=>$stato_options),false);
        
        //superficie
        $wnd->AddTextField("Superficie","Superficie",array("required"=>true,"gravity"=>1,"bottomPadding"=>32,"bottomLabel"=>"*Inserisci la superficie (mq) dell'impianto.", "placeholder"=>"es. 150"),false);

        //Nome
        $wnd->AddTextField("nome","Titolo",array("required"=>true,"gravity"=>3,"bottomPadding"=>32,"bottomLabel"=>"*Inserisci una denominazione per l'impianto.", "placeholder"=>"..."));

        //potenza
        $wnd->AddTextField("Potenza","Potenza",array("required"=>true,"gravity"=>1,"bottomPadding"=>32,"bottomLabel"=>"*Inserisci la potenza in megawatt dell'impianto.", "placeholder"=>"es. 150"),false);

        $section=new AA_FieldSet($id."_Riferimenti","Riferimenti temporali");

        //anno autorizzazione
        $section->AddDateField("AnnoAutorizzazione","Data autorizzazione",array("bottomPadding"=>32, "labelWidth"=>145,"bottomLabel"=>"*Data in cui e' stata autorizzata la costruzione dell'impianto.", "placeholder"=>"es. 2024-01-01"));
        
        //anno costruzione
        $section->AddDateField("AnnoCostruzione","Data costruzione",array("bottomPadding"=>32, "labelWidth"=>145,"bottomLabel"=>"*Data in cui e' stata terminata la costruzione dell'impianto.", "placeholder"=>"es. 2024-01-01"),false);

        //anno esercizio
        $section->AddDateField("AnnoEsercizio","Data esercizio",array("bottomPadding"=>32, "labelWidth"=>145,"bottomLabel"=>"*Data in cui l'impianto e' entrato in esercizio.", "placeholder"=>"es. 2024-01-01"),false);

        //anno dismissione
        $section->AddDateField("AnnoDismissione","Data dismissione",array("bottomPadding"=>32,"labelWidth"=>145, "bottomLabel"=>"*Data in cui l'impianto e' stato dismesso.", "placeholder"=>"es. 2024-01-01"),false);

        $wnd->AddGenericObject($section);

        //Norma
        $section=new AA_FieldSet($id."_Geolocalizzazione","Geolocalizzazione");

        //localita'
        $section->AddTextField("Geo_localita","Ubicazione",array("required"=>true, "gravity"=>3,"labelWidth"=>90,"bottomLabel"=>"*Inserisci la localita'/indirizzo dell'impianto.", "placeholder"=>"..."));

        //comune
        $section->AddTextField("Geo_comune","Comune",array("required"=>true, "gravity"=>2,"bottomPadding"=>38,"labelWidth"=>90,"bottomLabel"=>"*Inserisci il Comune in cui e' sito l'impianto.", "placeholder"=>"es. Cagliari","suggest"=>array("template"=>"#value#","url"=>$this->taskManagerUrl."?task=GetGeserListaCodiciIstat")));

        //coordinate
        $section->AddTextField("Geo_coordinate","Coordinate",array("gravity"=>1,"bottomPadding"=>38,"labelWidth"=>90, "bottomLabel"=>"*Coordinate geografiche dell'impianto (formato: latitudine,longitudine).", "placeholder"=>"es. 39.217199,9.113311"),false);

        $wnd->AddGenericObject($section);

        //Note
        $label="Note";
        $wnd->AddTextareaField("Note",$label,array("labelWidth"=>90,"bottomLabel"=>"*Eventuali annotazioni (max 4096 caratteri).", "placeholder"=>"Inserisci qui le note..."));

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("UpdateGeserDatiGenerali");
        
        return $wnd;
    }

    //Template dlg modify beneficiario
    public function Template_GetGeserBeneficiarioModifyDlg($object=null)
    {
        $id=$this->GetId()."_Modify_Dlg";
        if(!($object instanceof AA_Geser)) return new AA_GenericWindowTemplate($id, "Modifica i dati beneficiario", $this->id);

        $beneficiario=$object->GetBeneficiario();
        $form_data=array();
        $form_data['id']=$object->GetId();
        $form_data['Beneficiario_nome']=$beneficiario['nome'];
        $form_data['Beneficiario_cf']=$beneficiario['cf'];
        $form_data['Beneficiario_piva']=$beneficiario['piva'];
        $form_data['Beneficiario_tipo']=$beneficiario['tipo'];
        $form_data['Beneficiario_privacy']=$beneficiario['privacy'];

        $wnd=new AA_GenericFormDlg($id, "Modifica i dati beneficiario", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(1080);
        $wnd->SetHeight(820);
        $wnd->EnableValidation();
              
        //Beneficiario
        //$section=new AA_FieldSet($id."_Beneficario","Beneficiario");
        
        //Nome e cognome
        $wnd->AddTextField("Beneficiario_nome","Nominativo",array("required"=>true,"gravity"=>2,"bottomPadding"=>32, "bottomLabel"=>"*Inserisci il nominativo/ragione sociale (max 255 caratteri).", "placeholder"=>"es. Mario Rossi..."));
        
        //cf
        $wnd->AddTextField("Beneficiario_cf","C.F.",array("required"=>true, "gravity"=>1,"bottomPadding"=>32,"labelWidth"=>60,"bottomLabel"=>"*Inserisci il codice fiscale del beneficiario."),false);

        //piva
        $wnd->AddTextField("Beneficiario_piva","P.IVA",array("gravity"=>1,"labelWidth"=>60,"bottomPadding"=>32,"bottomLabel"=>"*Inserisci la partita iva del beneficiario (se applicabile)."),false);

        //Tipo
        $wnd->AddCheckBoxField("Beneficiario_tipo"," ",array("bottomPadding"=>32,"labelWidth"=>60, "labelRight"=>"<b>Persona fisica/Ditta individuale/Libero professionista</b>", "gravity"=>1, "bottomLabel"=>"*Abilita se il beneficiario e' una persona fisica, una ditta individuale o un libero professionista.","eventHandlers"=>array("onChange"=>array("handler"=>"onPersonaFisicaChange","module_id"=>$this->GetId()))));

        //Privacy
        $wnd->AddCheckBoxField("Beneficiario_privacy"," ",array("bottomPadding"=>32,"gravity"=>1,"labelWidth"=>60,"labelRight"=>"<b>Oscuramento dati personali</b>", "bottomLabel"=>"*Abilita se dalla pubblicazione sia possibile ricavare informazioni relative allo stato di salute e alla situazione di disagio economico-sociale degli interessati."),false);

        //$wnd->AddGenericObject($section);
        $wnd->EnableCloseWndOnSuccessfulSave();

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("UpdateGeserDatiBeneficiario");
        
        return $wnd;
    }

    public function Template_GetGeserHelpDlg()
    {
        $id=$this->GetId()."_Help_Dlg";
        
        $wnd=new AA_GenericWindowTemplate($id, "Aiuto", $this->id);
        
        $wnd->SetWidth(350);

        $platform=AA_Platform::GetInstance($this->oUser);
        $manualPath=$platform->GetModulePathURL($this->GetId())."/docs/manuale_oc.pdf";
        $action='AA_MainApp.utils.callHandler("pdfPreview", { url: "'.$manualPath.'" }, "'.$this->GetId().'");';

        $layout=new AA_JSON_Template_Layout($id."_Aiuto_box",array("type"=>"clean"));
        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));
        $toolbar_oc=new AA_JSON_Template_Toolbar($id."_ToolbarOC",array("type"=>"clean","borderless"=>true));

        //manuale operatore comunale
        $btn=new AA_JSON_Template_Generic($id."_Manuale_btn",array(
            "view"=>"button",
            "type"=>"icon",
            "icon"=>"mdi mdi-help-circle",
            "label"=>"Manuale caricamento risultati",
            "align"=>"center",
            "inputWidth"=>300,
            "click"=>$action,
            "tooltip"=>"Visualizza o scarica il manuale operatore comunale per iul caricamento dei risultati elettorali"
        ));

        $toolbar_oc->AddCol($btn);
        $layout->AddRow($toolbar_oc);

        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));

        $toolbar_oc=new AA_JSON_Template_Toolbar($id."_ToolbarOC",array("type"=>"clean","borderless"=>true));
        $manualPath=$platform->GetModulePathURL($this->GetId())."/docs/manuale_oc_rendiconti.pdf";
        $action='AA_MainApp.utils.callHandler("pdfPreview", { url: "'.$manualPath.'" }, "'.$this->GetId().'");';
        //manuale operatore comunale rendiconti
        $btn=new AA_JSON_Template_Generic($id."_ManualeRendiconti_btn",array(
            "view"=>"button",
            "type"=>"icon",
            "icon"=>"mdi mdi-help-circle",
            "label"=>"Manuale caricamento rendiconti",
            "align"=>"center",
            "inputWidth"=>300,
            "click"=>$action,
            "tooltip"=>"Visualizza o scarica il manuale operatore comunale per la compilazione dei rendiconti"
        ));

        $toolbar_oc->AddCol($btn);
        $layout->AddRow($toolbar_oc);

        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));

        $wnd->AddView($layout);        

        return $wnd;
    }

    //Template detail (da specializzare)
    public function TemplateSection_Detail($params)
    {
        //Gestione dei tab
        //$id=static::AA_UI_PREFIX."_Detail_Generale_Tab_".$params['id'];
        //$params['DetailOptionTab']=array(array("id"=>$id, "value"=>"Generale","tooltip"=>"Dati generali","template"=>"TemplateGeserDettaglio_Generale_Tab"));
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER)) $params['readonly']=true;
        
        $params['MultiviewEventHandlers']=array("onViewChange"=>array("handler"=>"onDetailViewChange"));

        $params['disable_SaveAsPdf']=true;
        $params['disable_SaveAsCsv']=true;
        //$params['disable_trash']=true;
        //$params['disable_public_trash']=true;

        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER)) $params['disable_MenuAzioni']=true;
        
        $detail = $this->TemplateGenericSection_Detail($params);

        return $detail;
    }

    //lista pratiche
    public function TemplateDettaglio_Pratiche($object=null)
    {
        $id=static::AA_UI_PREFIX."_".static::AA_UI_TEMPLATE_PRATICHE;
        $canModify=false;

        #pratiche----------------------------------
        if($this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER)) $canModify=true;

        $stati_pratica=AA_Geser_Const::GetListaStatiPratica();
        $tipo_pratica=AA_Geser_Const::GetListaTipoPratica();
        $tipo_via=AA_Geser_Const::GetListaTipoVia();
        $pratiche=$object->GetPratiche();
        foreach($pratiche as $id_pratica=>$curPratica)
        {
            //AA_Log::Log(__METHOD__." - criterio: ".print_r($curDoc,true),100);
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserTrashPraticaDlg", params: [{id:"'.$object->GetId().'"},{id_pratica:"'.$id_pratica.'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserModifyPraticaDlg", params: [{id:"'.$object->GetId().'"},{id_pratica:"'.$id_pratica.'"}]},"'.$this->id.'")';
            $copy='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserCopyPraticaDlg", params: [{id:"'.$object->GetId().'"},{id_pratica:"'.$id_pratica.'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops' style='justify-content: space-between;width: 100%'><a class='AA_DataTable_Ops_Button' title='Copia' onClick='".$copy."'><span class='mdi mdi-content-copy'></span></a><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="&nbsp;";

            $pratiche_data[]=array("id"=>$id_pratica,"rif_temporali"=>"<div style='display:flex; flex-direction:column; justify-content:center'><span><b>Data inizio</b>: ".$curPratica['data_inizio']."</span><span><b>Data fine</b>: ".$curPratica['data_fine']."</span></div>","stato"=>$stati_pratica[$curPratica['stato']],"tipo"=>$tipo_pratica[$curPratica['tipo']],"estremi"=>$curPratica['estremi'],"descrizione"=>$curPratica['descrizione'],"via"=>$tipo_via[$curPratica['via']],"societa"=>$curPratica['societa'],"note"=>$curPratica['note'],"ops"=>$ops);
        }

        $template=new AA_GenericDatatableTemplate($id,"<span style='color:#003380'>Gestione pratiche</span>",9,null,array("css"=>"AA_Header_DataTable"));
        $template->SetHeaderCss(array("background-color"=>"#dadee0 !important"));
        $template->SetAddNewBtnCss("webix_primary");
        $template->EnableScroll(false,true);
        $template->EnableRowOver();
        $template->EnableHeader();
        $template->SetHeaderHeight(38);

        if($canModify) 
        {
            $template->EnableAddNew(true,"GetGeserAddNewPraticaDlg");
            $template->SetAddNewTaskParams(array("postParams"=>array("id"=>$object->GetId())));
        }

        $template->SetColumnHeaderInfo(0,"stato","<div style='text-align: center'>Stato</div>",120,"selectFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(1,"tipo","<div style='text-align: center'>Tipologia</div>",160,"selectFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(2,"rif_temporali","<div style='text-align: center'>Rif. temporali</div>",200,"textFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(3,"descrizione","<div style='text-align: center'>Descrizione</div>","fillspace","textFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(4,"estremi","<div style='text-align: center'>Estremi</div>","fillspace","textFilter","text","PraticheTable");
        $template->SetColumnHeaderInfo(5,"via","<div style='text-align: center'>Tipo VIA</div>",120,"selectFilter","text","PraticheTable");
        $template->SetColumnHeaderInfo(6,"societa","<div style='text-align: center'>Ragione sociale</div>",200,"selectFilter","text","PraticheTable");
        $template->SetColumnHeaderInfo(7,"note","<div style='text-align: center'>Note</div>","fillspace","textFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(8,"ops","<div style='text-align: center'>Operazioni</div>",120,null,null,"PraticheTable");

        $template->SetData($pratiche_data);

        return $template;
    }
    
    //Template section detail, tab generale
    public function TemplateGeserDettaglio_Generale_Tab($object=null)
    {
        $id=static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_".static::AA_UI_DETAIL_GENERALE_BOX;

        if(!($object instanceof AA_Geser)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));

        $rows_fixed_height=50;
        $canModify=false;
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0 && $this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER)) $canModify=true;

        $toolbar=new AA_JSON_Template_Toolbar("",array("height"=>32,"type"=>"clean","borderless"=>true));
        $toolbar->AddElement(new AA_JSON_Template_Generic("",array("width"=>120)));
        $toolbar->AddElement(new AA_JSON_Template_Generic());

        $toolbar->AddElement(new AA_JSON_Template_Generic());
        /*if(($object->GetStatus()&AA_Const::AA_STATUS_PUBBLICATA)>0)
        {   
            $revision_btn=new AA_JSON_Template_Generic("",array(
                "view"=>"button",
                 "type"=>"icon",
                 "icon"=>"mdi mdi-table-eye",
                 "label"=>"Revisioni",
                 "align"=>"right",
                 "autowidth"=>true,
                 "tooltip"=>"Visualizza i dati di revisione",
                 "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetGeserRevisionViewDlg\", params: [{id: ".$object->GetId()."}]},'".$this->id."')"
             ));
             $toolbar->AddElement($revision_btn);
        }
        else*/
        {
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("width"=>120)));
        }

        $layout=$this->TemplateGenericDettaglio_Header_Generale_Tab($object,$id,$toolbar,$canModify);
        
        //stato
        $value="<span class='AA_Label AA_Label_Green'>".$object->GetStato()."</span>";
        $stato=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "gravity"=>1,
            "data"=>array("title"=>"Stato:","value"=>$value),
            "css"=>array("border-bottom"=>"1px solid #dadee0 !important")
        ));

        //tipologia
        $value="<span class='AA_Label AA_Label_Blue_Simo'>".$object->GetTipo()."</span>";
        $tipo=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "gravity"=>1,
            "data"=>array("title"=>"Tipologia impianto:","value"=>$value),
            "css"=>array("border-bottom"=>"1px solid #dadee0 !important")
        ));

        //potenza
        $value=$object->GetProp("Potenza");
        if(floatVal($value) > 0) 
        {
            if($value < 1000 ) $value="<span class='AA_Label AA_Label_Orange'>".AA_Utils::number_format($value,2,",",".")." KWatt</span>";
            else $value="<span class='AA_Label AA_Label_Orange'>".AA_Utils::number_format($value/1000,2,",",".")." MWatt</span>";
        }
        else $value="n.d.";
        $potenza=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "gravity"=>1,
            "data"=>array("title"=>"Potenza:","value"=>$value),
            "css"=>array("border-bottom"=>"1px solid #dadee0 !important")
        ));

        //superficie
        $value=$object->GetProp("Superficie");
        if(floatVal($value)>0) $value=AA_Utils::number_format($value,2,",",".")." mq";
        else $value="n.d.";
        $superficie=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "gravity"=>1,
            "data"=>array("title"=>"Superficie:","value"=>$value),
            "css"=>array("border-bottom"=>"1px solid #dadee0 !important")
        ));

        //denominazione
        $value=$object->GetDescr();
        $nome=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "gravity"=>1,
            "data"=>array("title"=>"Denominazione:","value"=>$value),
            "css"=>array("border-bottom"=>"1px solid #dadee0 !important")
        ));

        //anno autorizzazione
        $value=$object->GetProp("AnnoAutorizzazione");
        if($value=="")$value="n.d.";
        $anno_autorizzazione=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "gravity"=>1,
            "width"=>180,
            "data"=>array("title"=>"Data autorizzazione:","value"=>$value)
        ));

        //inizio lavori
        $value=$object->GetProp("InizioLavori");
        if($value=="")$value="n.d.";
        $inizio_lavori=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "gravity"=>1,
            "width"=>180,
            "data"=>array("title"=>"Data inizio lavori:","value"=>$value)
        ));

        //anno costruzione
        $value=$object->GetProp("AnnoCostruzione");
        if($value=="")$value="n.d.";
        $anno_costruzione=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "gravity"=>1,
            "width"=>180,
            "data"=>array("title"=>"Data costruzione:","value"=>$value)
        ));

        //anno esercizio
        $value=$object->GetProp("AnnoEsercizio");
        if($value=="")$value="n.d.";
        $anno_esercizio=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "gravity"=>1,
            "width"=>200,
            "data"=>array("title"=>"Data entrata in esercizio:","value"=>$value)
        ));

        //anno dismissione
        $value=$object->GetProp("AnnoDismissione");
        if($value=="")$value="n.d.";
        $anno_dismissione=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "gravity"=>1,
            "width"=>150,
            "data"=>array("title"=>"Data dismissione:","value"=>$value)
        ));
        
        //note
        $value = $object->GetProp("Note");
        $note=new AA_JSON_Template_Template($id."_Note",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "data"=>array("title"=>"Note:","value"=>$value)
        ));

        //geolocalizzazione
        $geolocalizzazione=$object->GetGeolocalizzazione();

        $value = $geolocalizzazione['localita'];
        $localita=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "data"=>array("title"=>"Localita':","value"=>$value)
        ));
        $value = $geolocalizzazione['comune'];
        $comune=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "data"=>array("title"=>"Comune:","value"=>$value)
        ));
        $value = $geolocalizzazione['coordinate'];
        $coordinate=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "data"=>array("title"=>"Coordinate:","value"=>$value)
        ));
        
        //prima riga
        $riga=new AA_JSON_Template_Layout("",array("height"=>$rows_fixed_height,"css"=>array("border-bottom"=>"1px solid #dadee0 !important")));
        $riga->AddCol($tipo);
        $riga->AddCol($stato);
        $riga->AddCol($potenza);
        $riga->AddCol($superficie);
        $riga->AddCol($anno_autorizzazione);
        $riga->AddCol($inizio_lavori);
        $riga->AddCol($anno_costruzione);
        $riga->AddCol($anno_esercizio);
        $riga->AddCol($anno_dismissione);
        $layout->AddRow($riga);

        //seconda riga
        $riga=new AA_JSON_Template_Layout("",array("gravity"=>1,"height"=>180,"css"=>array("border-bottom"=>"1px solid #dadee0 !important")));
        $layout_gen=new AA_JSON_Template_Layout("",array("gravity"=>2,"type"=>"clean"));
        $layout_geo=new AA_JSON_Template_Layout("",array("gravity"=>1,"type"=>"clean"));
        //$layout_gen->addRow($nome);
        $layout_gen->addRow($note);
        $layout_geo->AddRow($localita);
        $layout_geo->AddRow($comune);
        $layout_geo->AddRow($coordinate);
        $riga->addCol($layout_geo);
        $riga->addCol($layout_gen);
        $layout->AddRow($riga);

        $layout->AddRow(new AA_JSON_Template_Generic(""));
        //-------------------- Allegati --------------------------------------
        //$allegati_box->AddRow($this->TemplateDettaglio_Allegati($object,$id,$canModify));
        //$riga->AddCol($allegati_box);
        //------------------------------------------------------------------------
      
        //-------------------- Pratiche --------------------------------------
        //$toolbar=new AA_JSON_Template_Toolbar("",array("height"=>38, "css"=>array("background"=>"#dadee0 !important;")));
        //$toolbar->AddElement(new AA_JSON_Template_Generic(""));
        //$toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"<span style='color:#003380'>Gestione Pratiche</span>", "align"=>"center")));
        //$toolbar->AddElement(new AA_JSON_Template_Generic(""));
        //$layout->AddRow($toolbar);
        //$layout->AddRow($this->TemplateDettaglio_Pratiche($object));
        //------------------------------------------------------------------------

        return $layout;
    }

    public function TemplateGeserDettaglio_Pratiche_Tab($object=null)
    {
        $id=static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_".static::AA_UI_DETAIL_PRATICHE_BOX;

        if(!($object instanceof AA_Geser)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));

        $rows_fixed_height=50;
        $canModify=false;
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0 && $this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER)) $canModify=true;

        $stati_pratica=AA_Geser_Const::GetListaStatiPratica();
        $tipo_pratica=AA_Geser_Const::GetListaTipoPratica();
        $tipo_via=AA_Geser_Const::GetListaTipoVia();
        $pratiche=$object->GetPratiche();
        foreach($pratiche as $id_pratica=>$curPratica)
        {
            //AA_Log::Log(__METHOD__." - criterio: ".print_r($curDoc,true),100);
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserTrashPraticaDlg", params: [{id:"'.$object->GetId().'"},{id_pratica:"'.$id_pratica.'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserModifyPraticaDlg", params: [{id:"'.$object->GetId().'"},{id_pratica:"'.$id_pratica.'"}]},"'.$this->id.'")';
            $copy='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserCopyPraticaDlg", params: [{id:"'.$object->GetId().'"},{id_pratica:"'.$id_pratica.'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops' style='justify-content: space-between;width: 100%'><a class='AA_DataTable_Ops_Button' title='Copia' onClick='".$copy."'><span class='mdi mdi-content-copy'></span></a><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="&nbsp;";

            $pratiche_data[]=array("id"=>$id_pratica,"rif_temporali"=>"<div style='display:flex; flex-direction:column; justify-content:center'><span><b>Data inizio</b>: ".$curPratica['data_inizio']."</span><span><b>Data fine</b>: ".$curPratica['data_fine']."</span></div>","stato"=>$stati_pratica[$curPratica['stato']],"tipo"=>$tipo_pratica[$curPratica['tipo']],"estremi"=>$curPratica['estremi'],"descrizione"=>$curPratica['descrizione'],"via"=>$tipo_via[$curPratica['via']],"societa"=>$curPratica['societa'],"note"=>$curPratica['note'],"ops"=>$ops);
        }

        $template=new AA_GenericDatatableTemplate($id,"<span style='color:#003380'>Gestione pratiche</span>",9,null,array("css"=>"AA_Header_DataTable"));
        $template->SetHeaderCss(array("background-color"=>"#dadee0 !important"));
        $template->SetAddNewBtnCss("webix_primary");
        $template->EnableScroll(false,true);
        $template->EnableRowOver();
        $template->EnableHeader();
        $template->SetHeaderHeight(38);

        if($canModify) 
        {
            $template->EnableAddNew(true,"GetGeserAddNewPraticaDlg");
            $template->SetAddNewTaskParams(array("postParams"=>array("id"=>$object->GetId())));
        }

        $template->SetColumnHeaderInfo(0,"stato","<div style='text-align: center'>Stato</div>",120,"selectFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(1,"tipo","<div style='text-align: center'>Tipologia</div>",160,"selectFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(2,"rif_temporali","<div style='text-align: center'>Rif. temporali</div>",200,"textFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(3,"descrizione","<div style='text-align: center'>Descrizione</div>","fillspace","textFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(4,"estremi","<div style='text-align: center'>Estremi</div>","fillspace","textFilter","text","PraticheTable");
        $template->SetColumnHeaderInfo(5,"via","<div style='text-align: center'>Tipo VIA</div>",120,"selectFilter","text","PraticheTable");
        $template->SetColumnHeaderInfo(6,"societa","<div style='text-align: center'>Ragione sociale</div>",200,"selectFilter","text","PraticheTable");
        $template->SetColumnHeaderInfo(7,"note","<div style='text-align: center'>Note</div>","fillspace","textFilter","text","PraticheTable_left");
        $template->SetColumnHeaderInfo(8,"ops","<div style='text-align: center'>Operazioni</div>",120,null,null,"PraticheTable");

        $template->SetData($pratiche_data);

        return $template;
    }

    //Template section detail, tab generale
    public function TemplateGeserDettaglio_Allegati_Tab($object=null)
    {
        $id=static::AA_UI_PREFIX."_".static::AA_ID_SECTION_DETAIL."_".static::AA_UI_DETAIL_ALLEGATI_BOX;

        if(!($object instanceof AA_Geser)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));
        
        $rows_fixed_height=50;
        $canModify=false;
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0) $canModify=true;

        #documenti----------------------------------
        $curId=$id;
        $layout=new AA_JSON_Template_Layout($curId,array("type"=>"clean","gravity"=>4));

        $toolbar=new AA_JSON_Template_Toolbar($curId."_Toolbar_allegati",array("height"=>38,"css"=>array("border-bottom"=>"1px solid #dadee0 !important")));
        $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));

        $toolbar->AddElement(new AA_JSON_Template_Generic($curId."_Toolbar_Allegati_Title",array("view"=>"label","label"=>"<span style='color:#003380'>Documenti</span>", "align"=>"center")));

        if($canModify)
        {
            //Pulsante di aggiunta documento
            $add_documento_btn=new AA_JSON_Template_Generic($curId."_AddAllegato_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-file-plus",
                "label"=>"Aggiungi",
                "css"=>"webix_primary",
                "align"=>"right",
                "width"=>120,
                "tooltip"=>"Aggiungi allegato o link",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetGeserAddNewAllegatoDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
            ));

            $toolbar->AddElement($add_documento_btn);
        }
        else 
        {
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
        }

        $layout->AddRow($toolbar);

        $options_documenti=array();

        if($canModify)
        {
            $options_documenti[]=array("id"=>"ordine","header"=>array("<div style='text-align: center'>n.</div>",array("content"=>"textFilter")),"width"=>60, "css"=>array("text-align"=>"center"),"sort"=>"int");
            $options_documenti[]=array("id"=>"aggiornamento","header"=>array("<div style='text-align: center'>Data</div>",array("content"=>"textFilter")),"width"=>100, "css"=>array("text-align"=>"left"),"sort"=>"text");
            $options_documenti[]=array("id"=>"tipoDescr","header"=>array("<div style='text-align: center'>Categorie</div>",array("content"=>"textFilter")),"width"=>300, "css"=>array("text-align"=>"center"),"sort"=>"text");
            $options_documenti[]=array("id"=>"destinatariDescr","header"=>array("<div style='text-align: center'>Destinatari</div>",array("content"=>"textFilter")),"width"=>300, "css"=>array("text-align"=>"center"),"sort"=>"text");
            $options_documenti[]=array("id"=>"estremi","header"=>array("<div style='text-align: center'>Descrizione</div>",array("content"=>"textFilter")),"fillspace"=>true, "css"=>array("text-align"=>"left"),"sort"=>"text");
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>120,"css"=>array("text-align"=>"center"));
        }
        else
        {
            $options_documenti[]=array("id"=>"ordine","header"=>array("<div style='text-align: center'>n.</div>",array("content"=>"textFilter")),"width"=>60, "css"=>array("text-align"=>"center"),"sort"=>"int");
            $options_documenti[]=array("id"=>"aggiornamento","header"=>array("<div style='text-align: center'>Data</div>",array("content"=>"textFilter")),"width"=>100, "css"=>array("text-align"=>"left"),"sort"=>"text");
            $options_documenti[]=array("id"=>"tipoDescr","header"=>array("<div style='text-align: center'>Categorie</div>",array("content"=>"textFilter")),"width"=>300, "css"=>array("text-align"=>"center"),"sort"=>"text");
            $options_documenti[]=array("id"=>"destinatariDescr","header"=>array("<div style='text-align: center'>Destinatari</div>",array("content"=>"textFilter")),"width"=>300, "css"=>array("text-align"=>"center"),"sort"=>"text");
            $options_documenti[]=array("id"=>"estremi","header"=>array("<div style='text-align: center'>Descrizione</div>",array("content"=>"textFilter")),"fillspace"=>true, "css"=>array("text-align"=>"left"),"sort"=>"text");
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }

        $documenti=new AA_JSON_Template_Generic($curId."_Allegati_Table",array("view"=>"datatable", "select"=>true,"scrollX"=>false,"css"=>"AA_Header_DataTable","hover"=>"AA_DataTable_Row_Hover","columns"=>$options_documenti));

        $storage=AA_Storage::GetInstance();

        $documenti_data=array();
        foreach($object->GetAllegati() as $id_doc=>$curDoc)
        {
            if($curDoc->GetUrl() == "")
            {
                $view='AA_MainApp.utils.callHandler("wndOpen", {url: "storage.php?object='.$curDoc->GetFileHash().'"},"'.$this->id.'")';
                $view_icon="mdi-floppy";
                $tip="Scarica";

                if($storage->IsValid())
                {
                    $file=$storage->GetFileByHash($curDoc->GetFileHash());
                    if($file->IsValid())
                    {
                        if(strpos($file->GetmimeType(),"pdf",0) !==false)
                        {
                            $view='AA_MainApp.utils.callHandler("pdfPreview", {url: "storage.php?object='.$curDoc->GetFileHash().'"},"'.$this->id.'")';
                            $view_icon="mdi-eye";
                            $tip="Consulta";
                        }
                    }
                }
            }
            else 
            {
                $view='AA_MainApp.utils.callHandler("wndOpen", {url: "'.$curDoc->GetUrl().'"},"'.$this->id.'")';
                $view_icon="mdi-eye";
                $tip="Naviga (in un'altra finestra)";
            }
            
            
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserTrashAllegatoDlg", params: [{id: "'.$object->GetId().'"},{id_allegato:"'.$curDoc->GetId().'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserModifyAllegatoDlg", params: [{id: "'.$object->GetId().'"},{id_allegato:"'.$curDoc->GetId().'"}]},"'.$this->id.'")';
            $copy='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserCopyAllegatoDlg", params: [{id: "'.$object->GetId().'"},{id_allegato:"'.$curDoc->GetId().'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='".$tip."' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a><a class='AA_DataTable_Ops_Button' title='Copia' onClick='".$copy."'><span class='mdi mdi-content-copy'></span></a><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="<div class='AA_DataTable_Ops' style='justify-content: center'><a class='AA_DataTable_Ops_Button' title='".$tip."' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a></div>";
            $docDestinatari=array();
            foreach($curDoc->GetDestinatariDescr(true) as $curDestinatario)
            {
                $docDestinatari[]="<span class='AA_Label AA_Label_LightGreen'>".$curDestinatario."</span>";
            }
            $docTipo=array();
            foreach($curDoc->GetTipoDescr(true) as $curTipo)
            {
                $docTipo[]="<span class='AA_Label AA_Label_LightGreen'>".$curTipo."</span>";
            }
            
            $documenti_data[]=array("id"=>$id_doc,"ordine"=>$curDoc->GetOrdine(),"destinatariDescr"=>implode("&nbsp;",$docDestinatari),"estremi"=>$curDoc->GetEstremi(),"tipoDescr"=>implode("&nbsp;",$docTipo),"tipo"=>$curDoc->GetTipo(),"aggiornamento"=>$curDoc->GetAggiornamento(),"ops"=>$ops);
        }
        $documenti->SetProp("data",$documenti_data);
        if(sizeof($documenti_data) > 0) $layout->AddRow($documenti);
        else $layout->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        #--------------------------------------
        
        return $layout;
    }

    //Task Update Geser
    public function Task_UpdateGeserDatiGenerali($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());

        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        //----------- verify values ---------------------
        if(trim($_REQUEST['nome']) == "")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Il titolo non puo' essere vuoto o composto da soli spazi.",false);

            return false;
        }

        //date
        if(isset($_REQUEST['AnnoAutorizzazione'])) $_REQUEST['AnnoAutorizzazione']=substr($_REQUEST['AnnoAutorizzazione'],0,10);
        if(isset($_REQUEST['AnnoCostruzione'])) $_REQUEST['AnnoCostruzione']=substr($_REQUEST['AnnoCostruzione'],0,10);
        if(isset($_REQUEST['AnnoEsercizio'])) $_REQUEST['AnnoEsercizio']=substr($_REQUEST['AnnoEsercizio'],0,10);
        if(isset($_REQUEST['AnnoDismissione'])) $_REQUEST['AnnoDismissione']=substr($_REQUEST['AnnoDismissione'],0,10);

        //potenza
        if(isset($_REQUEST['Potenza'])) $_REQUEST['Potenza']=AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Potenza'])),2,".","");
        //superficie
        if(isset($_REQUEST['Superficie'])) $_REQUEST['Superficie']=AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Superficie'])),2,".","");

        $geolocalizzazione=array();
        
        if(isset($_REQUEST['Geo_comune'])) $geolocalizzazione['comune']=trim($_REQUEST['Geo_comune']);
        if(isset($_REQUEST['Geo_localita'])) $geolocalizzazione['localita']=trim($_REQUEST['Geo_localita']);
        if(isset($_REQUEST['Geo_coordinate'])) $geolocalizzazione['coordinate']=trim($_REQUEST['Geo_coordinate']);

        if(sizeof($geolocalizzazione)>0) $_REQUEST['Geolocalizzazione']=json_encode($geolocalizzazione);
        //-----------------------------------------------
        
        $object->Parse($_REQUEST);

        if(!$object->Update($this->oUser,true,"Aggiornamento dati generali"))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nell'aggiornamento dei dati generali.",false);

            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent("Dati aggiornati.",false);

            return true;
        }
    }

    //Task Update Geser
    public function Task_UpdateGeserDatiBeneficiario($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $beneficiario=array();

        //----------- verify values ---------------------
        if(isset($_REQUEST['Beneficiario_nome'])) $beneficiario['nome']=trim($_REQUEST['Beneficiario_nome']);
        if(isset($_REQUEST['Beneficiario_cf'])) $beneficiario['cf']=trim($_REQUEST['Beneficiario_cf']);

        if(trim($_REQUEST['Beneficiario_nome']) == "" || trim($_REQUEST['Beneficiario_cf']) =="")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Il nome e il codice fiscale del beneficiario non possono essere vuoti o composti da soli spazi.",false);

            return false;
        }
        if(isset($_REQUEST['Beneficiario_piva'])) $beneficiario['piva']=trim($_REQUEST['Beneficiario_piva']);
        if(isset($_REQUEST['Beneficiario_tipo'])) $beneficiario['tipo']=intVal($_REQUEST['Beneficiario_tipo']);
        if(isset($_REQUEST['Beneficiario_privacy'])) $beneficiario['privacy']=intVal($_REQUEST['Beneficiario_privacy']);

        //Se il beneficiario non e' una persona fisica disabilita l'oscuramento dei dati personali.
        if($beneficiario['tipo'] == 0) 
        {
            $beneficiario['privacy'] = 0;
        }
        //-----------------------------------------------
        
        $_REQUEST['Beneficiario']=json_encode($beneficiario);
        $object->Parse($_REQUEST);

        if(!$object->Update($this->oUser,true,"Aggiornamento dati beneficiario"))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nell'aggiornamento dei dati beneficiario.",false);

            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent("Dati aggiornati.",false);

            return true;
        }
    }
    
    //Task trash Geser
    public function Task_TrashGeser($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetError("L'utente corrente non ha i permessi per cestinare l'elemento");
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente non ha i permessi per cestinare l'elemento</error>";
            $task->SetLog($sTaskLog);

            return false;
        }

        return $this->Task_GenericTrashObject($task,$_REQUEST);
    }
    
    //Task resume Geser
    public function Task_ResumeGeser($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        return $this->Task_GenericResumeObject($task,$_REQUEST);
    }
    
    //Task publish Geser
    public function Task_PublishGeser($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        //torna alla lista
        //$_REQUEST['goBack']=1;

        return $this->Task_GenericPublishObject($task,$_REQUEST);
    }
    
    //Task reassign Geser
    public function Task_ReassignGeser($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        return $this->Task_GenericReassignObject($task,$_REQUEST);
    }
    
    //Task delete Geser
    public function Task_DeleteGeser($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
         
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetError("L'utente corrente non ha i permessi per eliminare l'elemento");
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente non ha i permessi per eliminare l'elemento</error>";
            $task->SetLog($sTaskLog);

            return false;
        }

        return $this->Task_GenericDeleteObject($task,$_REQUEST);
    }
    
    //Task Aggiungi provvedimenti
    public function Task_AddNewGeser($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per aggiungere nuovi elementi",false);

            return false;
        }
        
        //----------- verify values ---------------------
        if(trim($_REQUEST['nome']) == "")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Il titolo non puo' essere vuoto o composto da soli spazi.",false);

            return false;
        }

        //date
        if(isset($_REQUEST['AnnoAutorizzazione'])) $_REQUEST['AnnoAutorizzazione']=substr($_REQUEST['AnnoAutorizzazione'],0,10);
        if(isset($_REQUEST['AnnoCostruzione'])) $_REQUEST['AnnoCostruzione']=substr($_REQUEST['AnnoCostruzione'],0,10);
        if(isset($_REQUEST['AnnoEsercizio'])) $_REQUEST['AnnoEsercizio']=substr($_REQUEST['AnnoEsercizio'],0,10);
        if(isset($_REQUEST['AnnoDismissione'])) $_REQUEST['AnnoDismissione']=substr($_REQUEST['AnnoDismissione'],0,10);

        //potenza
        if(isset($_REQUEST['Potenza'])) $_REQUEST['Potenza']=AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Potenza'])),2,".","");
        //superficie
        if(isset($_REQUEST['Superficie'])) $_REQUEST['Superficie']=AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Superficie'])),2,".","");

        $geolocalizzazione=array();
        
        if(isset($_REQUEST['Geo_comune'])) $geolocalizzazione['comune']=trim($_REQUEST['Geo_comune']);
        if(isset($_REQUEST['Geo_localita'])) $geolocalizzazione['localita']=trim($_REQUEST['Geo_localita']);
        if(isset($_REQUEST['Geo_coordinate'])) $geolocalizzazione['coordinate']=trim($_REQUEST['Geo_coordinate']);

        $_REQUEST['Geolocalizzazione']=json_encode($geolocalizzazione);
        //-----------------------------------------------

        return $this->Task_GenericAddNew($task,$_REQUEST);
    }

    //Task Aggiungi nuovi impianti da csv
    public function Task_AddNewMultiGeser($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per aggiungere nuovi elementi",false);

            return false;
        }
        
        $data=AA_SessionVar::Get("GeserAddNewMultiFromCSV_ParsedData")->GetValue();
        AA_SessionVar::UnsetVar("GeserAddNewMultiFromCSV_ParsedData");

        if(!is_array($data))
        {
            AA_Log::Log(__METHOD__." - dati csv non validi: ".print_r($data,TRUE),100);

            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Dati CSV non validi",false);

            return false;
        }

        $count=array("inseriti"=>0,"modificati"=>0);

        foreach($data as $curData)
        {
            if($curData['id_impianto'] > 0)
            {
                if($curData['societa'] !="")
                {
                    $impianto=new AA_Geser($curData['id_impianto'],$this->oUser);
                    if($impianto->IsValid())
                    {
                        $pratiche=$impianto->GetPratiche();
                        $pratica=array();
                        if(isset($curData['pratica_tipo'])) $pratica["tipo"]=$curData['pratica_tipo'];
                        else $pratica["tipo"]=AA_Geser_Const::AA_GESER_TIPO_PRATICA_AU;
                        if(isset($curData['pratica_stato'])) $pratica["stato"]=$curData['pratica_stato'];
                        else $pratica["stato"]=AA_Geser_Const::AA_GESER_STATO_PRATICA_DAISTRUIRE;
                        if(isset($curData['pratica_estremi'])) $pratica["estremi"]=$curData['pratica_estremi'];
                        else $pratica["estremi"]='';
                        if(isset($curData['pratica_descrizione'])) $pratica["descrizione"]=$curData['pratica_descrizione'];
                        else $pratica["descrizione"]='';
                        if(isset($curData['pratica_via'])) $pratica["via"]=$curData['pratica_via'];
                        else $pratica["via"]=AA_Geser_Const::AA_GESER_TIPO_VIA_NESSUNO;
                        if(isset($curData['pratica_societa'])) $pratica["societa"]=trim($curData['pratica_societa']);
                        else $pratica["societa"]='';
                        if(isset($curData['pratica_data_inizio'])) $pratica["data_inizio"]=$curData['pratica_data_inizio'];
                        else $pratica["data_inizio"]='';
                        if(isset($curData['pratica_data_fine'])) $pratica["data_fine"]=$curData['pratica_data_fine'];
                        else $pratica["data_fine"]='';
                        if(isset($curData['pratica_note'])) $pratica["note"]=$curData['pratica_note'];
                        else $pratica["note"]='';
                        $newId=uniqid();
                        $pratiche[$newId]=$pratica;
                        $impianto->SetProp('pratiche',json_encode($pratiche));
                        
                        if(!$impianto->Update($this->oUser,true,"Aggiunta pratica - id: ".$newId))
                        {
                            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
                            $task->SetError("Errore nell'aggiunta della nuova pratica all'impianto: ".$impianto->GetName(),false);
    
                            return false;
                        }

                        $count['modificati']++;
                    }
                }
            }
            else
            {
                $newImpianto=new AA_Geser(0,$this->oUser);
                $geolocalizzazione=array();
                $geolocalizzazione['comune']=$curData['Geo_comune'];
                $geolocalizzazione['localita']=$curData['Geo_localita'];
                $geolocalizzazione['coordinate']=$curData['Geo_coordinate'];
                $newImpianto->SetProp('Geolocalizzazione',json_encode($geolocalizzazione));

                $proprietario=$newImpianto->GetProprietario();
                $proprietario['denominazione']=$curData['Proprietario_nome'];
                $proprietario['cf']=$curData['Proprietario_cf'];
                $newImpianto->SetProp('Proprietario',json_encode($proprietario));

                $newImpianto->Parse($curData);

                if(!AA_Geser::AddNew($newImpianto,$this->oUser))
                {
                    $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
                    $task->SetError("Errore nell'aggiunta del nuovo impianto: ".$newImpianto->GetName(),false);

                    return false;
                }

                if($newImpianto->IsValid())
                {
                    if(isset($curData['societa']))
                    {
                        $pratiche=$newImpianto->GetPratiche();
                        $pratica=array();
                        if(isset($curData['pratica_tipo'])) $pratica["tipo"]=$curData['pratica_tipo'];
                        else $pratica["tipo"]=AA_Geser_Const::AA_GESER_TIPO_PRATICA_AU;
                        if(isset($curData['pratica_stato'])) $pratica["stato"]=$curData['pratica_stato'];
                        else $pratica["stato"]=AA_Geser_Const::AA_GESER_STATO_PRATICA_DAISTRUIRE;
                        if(isset($curData['pratica_estremi'])) $pratica["estremi"]=$curData['pratica_estremi'];
                        else $pratica["estremi"]='';
                        if(isset($curData['pratica_descrizione'])) $pratica["descrizione"]=$curData['pratica_descrizione'];
                        else $pratica["descrizione"]='';
                        if(isset($curData['pratica_via'])) $pratica["via"]=$curData['pratica_via'];
                        else $pratica["via"]=AA_Geser_Const::AA_GESER_TIPO_VIA_NESSUNO;
                        if(isset($curData['pratica_societa'])) $pratica["societa"]=trim($curData['pratica_societa']);
                        else $pratica["societa"]='';
                        if(isset($curData['pratica_data_inizio'])) $pratica["data_inizio"]=$curData['pratica_data_inizio'];
                        else $pratica["data_inizio"]='';
                        if(isset($curData['pratica_data_fine'])) $pratica["data_fine"]=$curData['pratica_data_fine'];
                        else $pratica["data_fine"]='';
                        if(isset($curData['pratica_note'])) $pratica["note"]=$curData['pratica_note'];
                        else $pratica["note"]='';

                        $newId=uniqid();
                        $pratiche[$newId]=$pratica;

                        $newImpianto->SetProp('Pratiche',json_encode($pratiche));

                        if(!$newImpianto->Update($this->oUser,true,"Aggiunta pratica - id: ".$newId))
                        {
                            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
                            $task->SetError("Errore nell'aggiunta della nuova pratica all'impianto: ".$impianto->GetName(),false);

                            return false;
                        }
                    }
                    
                    $count['inseriti']++;
                }
            }
        }

        AA_SessionVar::Set("GeserAddNewMultiResult",$count,false);

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent("Impianti aggiunti con successo",false);
        $task->SetStatusAction("dlg",json_encode(array("params"=>array("task"=>"GetGeserAddNewMultiResultDlg"))));
        return true;
    }

    //Task modifica dati generali elemento
    public function Task_GetGeserModifyDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }
            
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserModifyDlg($object),true);
        return true;
    }

    //Task richiesta oscurtamento dati personali
    public function Task_GetGeserConfirmPrivacyDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());

        $form_id=$_REQUEST['form'];
        if($form_id=="")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Non e' stato impostato l'identificativo del form corrispondente.",false);
        
            return false;
        }
        
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserConfirmPrivacyDlg($form_id),true);
        
        return true;
    }

    //Task modifica dati beneficiario
    public function Task_GetGeserBeneficiarioModifyDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserBeneficiarioModifyDlg($object),true);

        return true;
    }

    //Task resume
    public function Task_GetGeserResumeDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per ripristinare elementi.");
            return false;
        }

        if($_REQUEST['ids']!="")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGenericResumeObjectDlg($_REQUEST,"ResumeGeser"),true);
            return true;
        }    
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativi non presenti.",false);
            return false;
        }
    }
    
    //Task publish organismo
    public function Task_GetGeserPublishDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per ripristinare elementi.");
            return false;
        }
        
        if($_REQUEST['ids']!="")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGenericPublishObjectDlg($_REQUEST,"PublishGeser"),true);
            return true;
        }    
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativi non presenti.",false);
            return false;
        }
    }
    
    //Task Riassegna
    public function Task_GetGeserReassignDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per ripristinare elementi.");
            return false;
        }

        if($_REQUEST['ids']!="")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGenericReassignObjectDlg($_REQUEST,"ReassignGeser"),true);
            return true;
        }    
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativi non presenti.",false);
            return false;
        }
    }
    
    //Task elimina
    public function Task_GetGeserTrashDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per ripristinare elementi.");
            return false;
        }
        if($_REQUEST['ids']!="")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGenericObjectTrashDlg($_REQUEST,"TrashGeser"),true);
            return true;
        }    
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativi non presenti.",false);
            return false;
        }
    }
       
    //Task dialogo elimina
    public function Task_GetGeserDeleteDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per ripristinare elementi.");
            return false;
        }
        if($_REQUEST['ids']!="")
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGeserDeleteDlg($_REQUEST),true);
            return true;
        }    
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativi non presenti.",false);
            return false;
        }
    }
    
    //Task lista
    public function Task_GetGeserListaCodiciIstat($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
       
        $filter=$_REQUEST["filter"];

        $db=new AA_Database();
        $query="SELECT codice,comune FROM ".AA_Geser_Const::AA_DBTABLE_CODICI_ISTAT;
        if($filter !="") $query.=" WHERE codice like '".addslashes($filter['value'])."%' OR comune like '".addslashes($filter['value'])."%'";
        //$query.=" LIMIT 10";

        //AA_Log::Log(__METHOD__." - query ".$query.print_r($_REQUEST,true),100);
        
        //errore nella query
        if(!$db->Query($query))
        {
            AA_Log::Log(__METHOD__." - ERRORE ".$db->GetErrorMessage(),100);
            die("[]");
        }

        //Query vuota
        if($db->GetAffectedRows() == 0)
        {
            die("[]");
        }
        
        $result=array();
        $count=1;
        foreach($db->GetResultSet() as $curRow)
        {
            $result[]=array("id"=>$count,"codice"=>$curRow['codice'],"value"=>$curRow['comune']);
            $count++;
        }

        die(json_encode($result));
    }

    //Task aggiunta 
    public function Task_GetGeserAddNewDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
       
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per istanziare nuovi elementi.",false);
            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGeserAddNewDlg(),true);
            return true;
        }
    }

    //Task Add new pratica
    public function Task_AddNewGeserPratica($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());

        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        //----------- verify values --------------------

        if($_REQUEST['stato'] != AA_Geser_Const::AA_GESER_STATO_PRATICA_DAISTRUIRE && $_REQUEST['data_inizio']=="")
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Occorre indicare la data di inizio",false);

            return false;
        }

        if($_REQUEST['stato'] == AA_Geser_Const::AA_GESER_STATO_PRATICA_AUTORIZZATA && $_REQUEST['data_fine']=="")
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Occorre indicare la data di fine procedimento",false);

            return false;
        }

        if($_REQUEST['data_fine'] < $_REQUEST['data_inizio'])
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("La data di fine non puo' essere precedente a quella di inizio",false);

            return false;
        }

        if($_REQUEST['stato'] == AA_Geser_Const::AA_GESER_STATO_PRATICA_NEGATA && $_REQUEST['data_fine']=="")
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Occorre indicare la data di fine procedimento",false);

            return false;
        }

        $pratiche=$object->GetPratiche();
        $pratica=array(
            "tipo"=>$_REQUEST['tipo'],
            "stato"=>$_REQUEST['stato'],
            "estremi"=>$_REQUEST['estremi'],
            "descrizione"=>$_REQUEST['descrizione'],
            "via"=>$_REQUEST['via'],
            "societa"=>$_REQUEST['societa'],
            "data_inizio"=>substr($_REQUEST['data_inizio'],0,10),
            "data_fine"=>substr($_REQUEST['data_fine'],0,10),
            "note"=>$_REQUEST['note'],
        );
        $newId=uniqid();
        $pratiche[$newId]=$pratica;
        $_REQUEST["Pratiche"]=json_encode($pratiche);
        //-----------------------------------------------
        
        $object->Parse($_REQUEST);

        if(!$object->Update($this->oUser,true,"Aggiunta pratica - id: ".$newId))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nell'aggiunta della nuova pratica.",false);

            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent("Dati aggiornati.",false);

            return true;
        }
    }

    //Task update pratica
    public function Task_UpdateGeserPratica($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());

        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $pratiche=$object->GetPratiche();
        if(!isset($pratiche[$_REQUEST['id_pratica']]))
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo pratica mancante o non corretto",false);

            return false;
        }
        $id_pratica=$_REQUEST['id_pratica'];

        //----------- verify values ---------------------
        if($_REQUEST['stato'] != AA_Geser_Const::AA_GESER_STATO_PRATICA_DAISTRUIRE && $_REQUEST['data_inizio']=="")
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Occorre indicare la data di inizio",false);

            return false;
        }

        if($_REQUEST['stato'] == AA_Geser_Const::AA_GESER_STATO_PRATICA_AUTORIZZATA && $_REQUEST['data_fine']=="")
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Occorre indicare la data di fine procedimento",false);

            return false;
        }

        if($_REQUEST['stato'] == AA_Geser_Const::AA_GESER_STATO_PRATICA_NEGATA && $_REQUEST['data_fine']=="")
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Occorre indicare la data di fine procedimento",false);

            return false;
        }

        if($_REQUEST['data_fine'] < $_REQUEST['data_inizio'])
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("La data di fine non puo' essere precedente a quella di inizio",false);

            return false;
        }

        $pratica=array(
            "tipo"=>$_REQUEST['tipo'],
            "stato"=>$_REQUEST['stato'],
            "estremi"=>$_REQUEST['estremi'],
            "descrizione"=>$_REQUEST['descrizione'],
            "via"=>$_REQUEST['via'],
            "societa"=>$_REQUEST['societa'],
            "data_inizio"=>substr($_REQUEST['data_inizio'],0,10),
            "data_fine"=>substr($_REQUEST['data_fine'],0,10),
            "note"=>$_REQUEST['note'],
        );

        $pratiche[$id_pratica]=$pratica;
        $_REQUEST["Pratiche"]=json_encode($pratiche);
        //-----------------------------------------------
        
        $object->Parse($_REQUEST);

        if(!$object->Update($this->oUser,true,"Modifica pratica - id: ".$id_pratica))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nell'aggiornamento della pratica id: ".$id_pratica,false);

            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent("Dati aggiornati.",false);

            return true;
        }
    }

    //Task delete pratica
    public function Task_DeleteGeserPratica($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());

        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $pratiche=$object->GetPratiche();
        if(!isset($pratiche[$_REQUEST['id_pratica']]))
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo pratica mancante o non corretto",false);

            return false;
        }
        $id_pratica=$_REQUEST['id_pratica'];
        unset($pratiche[$id_pratica]);
        $_REQUEST["Pratiche"]=json_encode($pratiche);
        //-----------------------------------------------
        
        $object->Parse($_REQUEST);

        if(!$object->Update($this->oUser,true,"Elimina pratica - id: ".$id_pratica))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nell'eliminazione della pratica id: ".$id_pratica,false);

            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent("Dati aggiornati.",false);

            return true;
        }
    }

    //Task aggiunta multipla
    public function Task_GetGeserAddNewMultiDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
       
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per istanziare nuovi elementi.",false);
            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGeserAddNewMultiDlg(),true);
            return true;
        }
    }

    //Task aggiunta multipla preview
    public function Task_GetGeserAddNewMultiPreviewDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
       
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per istanziare nuovi elementi.",false);
            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGeserAddNewMultiPreviewDlg(),true);
            return true;
        }
    }

    //Task aggiunta multipla result
    public function Task_GetGeserAddNewMultiResultDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
       
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per istanziare nuovi elementi.",false);
            return false;
        }
        else
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
            $task->SetContent($this->Template_GetGeserAddNewMultiResultDlg(),true);
            return true;
        }
    }

    //Task aggiunta geco da csv, passo 2 di 3
    public function Task_GetGeserAddNewMultiPreviewCalc($task)
    {
        $csvFile=AA_SessionFileUpload::Get("GeserAddNewMultiCSV");
        if(!$csvFile->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("File non valido",false);        
            return false;
        }

        $csv=$csvFile->GetValue();
        if(!is_file($csv["tmp_name"]))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("File non valido (1)",false);
            return false;
        }

        if($_REQUEST['tracciato'] != 4) $csvRows=explode("\n",str_replace("\r","",file_get_contents($csv["tmp_name"])));
        else $csvRows=json_decode(file_get_contents($csv["tmp_name"]),true);

        //Elimina il file temporaneo
        if(is_file($csv["tmp_name"]))
        {
            unlink($csv["tmp_name"]);
        }

        $data=false;

        if($_REQUEST['tracciato']==1)
        {
            $data=$this->ElaborateCsvImportTerna($csvRows);
        }
        
        if($_REQUEST['tracciato']==2)
        {
            $data=$this->ElaborateCsvImportAssIndustria($csvRows);
        }

        if($_REQUEST['tracciato']==3)
        {
            $data=$this->ElaborateCsvImportSuape($csvRows);
        }

        if($_REQUEST['tracciato']==4)
        {
            $data=$this->ImportGseJson($csvRows);
        }

        if($data===false)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nell'elaborazione del file",false);
            return false;
        }

        if(is_array($data) && sizeof($data) > 0)
        {
            AA_SessionVar::Set("GeserAddNewMultiFromCSV_ParsedData",$data,false);
        }

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetStatusAction('dlg',array("task"=>"GetGeserAddNewMultiPreviewDlg"),true);
        $task->SetContent("Csv elaborato.",false);
                
        return true;
    }

    protected function ImportGseJson($impianti=null)
    {
        if(!is_array($impianti))
        {
           AA_Log::Log(__METHOD__." - file JSON non formattato correttamente.",100);
           return false;
        }

        $tipo_impianti=AA_Geser_Const::GetListaTipoImpianti();
        $impianti_esistenti=AA_Geser::Search(array("stato"=>AA_Const::AA_STATUS_PUBBLICATA),$this->oUser);
        $data=array();

        $tipo_impianti_match=array(
            "biogas"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOGAS,
            "biomasse liquide"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "biomasse solide"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "rifiuti"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "solare"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_AGRIVOLTAICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_TERMODINAMICO,
            "eolica"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_OFFSHORE,
            "eolico on-shore"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "idraulica"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_IDROELETTRICO,
        );

        $tipo_impianti_match_new=array(
            "biogas"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOGAS,
            "biomasse liquide"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "biomasse solide"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "rifiuti"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "solare"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO,
            "eolica"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "eolico on-shore"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "idraulica"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_IDROELETTRICO,
        );

        foreach($impianti as $curGseImpianto)
        {
            if($curGseImpianto['ai_fonte'] != "NO FER")
            {
                foreach($impianti_esistenti[1] as $curImpianto)
                {
                    $matching=0;
                    //comune
                    $geolocalizzazione=$curImpianto->GetGeolocalizzazione();
                    if(isset($geolocalizzazione['comune']) && strpos(strtolower($geolocalizzazione['comune']),strtolower($curGseImpianto['ai_comune'])) !== false)
                    {
                        $matching++;
                    }
    
                    //potenza (+- 10%)
                    if(floatVal($curImpianto->GetProp('potenza'))-floatVal($curGseImpianto['ai_potenza']) <=.1)
                    {
                        $matching++;
                    }
    
                    //Tipo impianto
                    $tipo_impianto=$curImpianto->GetProp('tipologia');
                    if(isset($tipo_impianti_match[strtolower($curGseImpianto['ai_fonte'])]) && ($tipo_impianto & $tipo_impianti_match[strtolower($curGseImpianto['ai_fonte'])]) > 0)
                    {
                        $matching++;
                    }
    
                    if($matching > 0 && $matching > $max_matching)
                    {
                        $impianto_matched=$curImpianto;
                        $max_matching=$matching;
                    }
                }

                $curDataValues=array();
                    
                if($impianto_matched) 
                {
                    $curDataValues['id_impianto']=$impianto_matched->GetId();
                }
                else 
                {
                    $curDataValues['id_impianto']=0;
                    $curDataValues['nome']="Impianto ad energia rinnovabile sito in  ".$$curGseImpianto['ai_comune'];
                    if(isset($tipo_impianti_match_new[strtolower($curGseImpianto['ai_fonte'])])) 
                    {
                        $curDataValues['Tipologia']=$tipo_impianti_match_new[strtolower($curGseImpianto['ai_fonte'])];
                        $curDataValues['nome']="Impianto ".$tipo_impianti[$curDataValues['Tipologia']]." sito in  ".$curGseImpianto['ai_comune'];
                    }
                    $curDataValues['Stato']=AA_Geser_Const::AA_GESER_STATO_ESERCIZIO;
                    $curDataValues['AnnoAutorizzazione']="";
                    $curDataValues['AnnoCostruzione']="";
                    $curDataValues['InizioLavori']="";
                    $curDataValues['AnnoEsercizio']=date("Y-m-d",intVal($curGseImpianto['details']['ai_data_esercizio']/1000));
                    $curDataValues['AnnoDismissione']="";
                    $curDataValues['Potenza']=AA_Utils::number_format(floatVal($curGseImpianto['ai_potenza']),2,".","");

                    $curDataValues['Superficie']="";
                    $curDataValues['Geo_comune']=trim($curGseImpianto['ai_comune']);
                    $curDataValues['Geo_localita']=trim($curGseImpianto['details']['ai_indirizzo']);
                    $curDataValues['Geo_coordinate']="";

                    $curDataValues['Note']="Impianto importato da GSE - ".date("d/m/Y H:i:s");
                    //^([A-Z]{6}[0-9LMNPQRSTUV]{2}[ABCDEHLMPRST]{1}[0-9LMNPQRSTUV]{2}[A-Z]{1}[0-9LMNPQRSTUV]{3}[A-Z]{1})$
                    if(preg_match('/^([A-Z]{6}[0-9LMNPQRSTUV]{2}[ABCDEHLMPRST]{1}[0-9LMNPQRSTUV]{2}[A-Z]{1}[0-9LMNPQRSTUV]{3}[A-Z]{1})$/',$curGseImpianto['details']['ai_codfisc_operatore']))
                    {
                        $curDataValues['nome']="Impianto ".$tipo_impianti[$curDataValues['Tipologia']]." residenziale sito in  ".$curGseImpianto['ai_comune'];
                        $curDataValues['Proprietario_nome']="Privato cittadino";
                        $curDataValues['Proprietario_cf']="";
                    }
                    else
                    {
                        $curDataValues['nome']="Impianto ".$tipo_impianti[$curDataValues['Tipologia']]." - ".$curGseImpianto['details']['ai_nome_impianto']." - sito in  ".$curGseImpianto['ai_comune'];
                        $curDataValues['Proprietario_nome']=$curGseImpianto['details']['ai_rag_soc_operatore'];
                        $curDataValues['Proprietario_cf']=$curGseImpianto['details']['ai_codfisc_operatore'];
                    }

                    $curDataValues['GseData']=json_encode($curGseImpianto);
                }

                $data[]=$curDataValues;
            }
        }

        return $data;
        
    }
    protected function ElaborateCsvImportTerna($csvRows=null)
    {
        if($csvRows==null)
        {
            return false;
        }

        //Parsing della posizione dei campi
        $fieldPos=array(
            "ragione sociale"=>-1,
            "classificazione"=>-1,
            "comune"=>-1,
            "data esercizio"=>-1,
            "potenza"=>-1
        );
        
        $recognizedFields=0;
        foreach(explode("|",$csvRows[0]) as $pos=>$curFieldName)
        {
            if($fieldPos[trim(strtolower($curFieldName))] == -1)
            {
                $fieldPos[trim(strtolower($curFieldName))] = $pos;
                $recognizedFields++;
            }
        }
        //----------------------------------------

        if($fieldPos['ragione sociale']==-1 || $fieldPos['classificazione'] ==-1 || $fieldPos['comune'] ==-1 || $fieldPos['data esercizio'] ==-1 || $fieldPos['potenza'] ==-1)
        {
            AA_Log::Log(__METHOD__." - Non sono stati trovati tutti i campi relativi a: ragione sociale,classificazione,comune,data esercizio,potenza. - ".print_r($fieldPos,true),100);
           return false;
        }

        //parsing dei dati
        $data=array();
        $curRowNum=0;
        $tipo_impianti_match=array(
            "biomasse"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOGAS,
            "solare"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_AGRIVOLTAICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_TERMODINAMICO,
            "eolico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_OFFSHORE,
            "eolico on-shore"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "idroelettrico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_IDROELETTRICO,
        );

        $tipo_impianti_match_new=array(
            "biomasse"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "solare"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO,
            "eolico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "eolico on-shore"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "idroelettrico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_IDROELETTRICO,
        );

        $tipo_impianti=AA_Geser_Const::GetListaTipoImpianti();
        $impianti_esistenti=AA_Geser::Search(array("stato"=>AA_Const::AA_STATUS_PUBBLICATA),$this->oUser);
        
        foreach($csvRows as $curCsvRow)
        {
            //salta la prima riga
            if($curRowNum > 0 && $curCsvRow !="")
            {
                $csvValues=explode("|",$curCsvRow);
                if(sizeof($csvValues) >= $recognizedFields)
                {
                    //cerca un match tra gli impianti esistenti
                    $impianto_matched=null;
                    $max_matching=0;
                    foreach($impianti_esistenti[1] as $curImpianto)
                    {
                        $matching=0;
                        //comune
                        $geolocalizzazione=$curImpianto->GetGeolocalizzazione();
                        if(isset($geolocalizzazione['comune']) && strpos(strtolower($geolocalizzazione['comune']),strtolower($csvValues[$fieldPos['comune']])) !== false)
                        {
                            $matching++;
                        }

                        //potenza (+- 10%)
                        if(floatVal($curImpianto->GetProp('potenza'))-floatVal(str_replace(",",".",str_replace(".","",$csvValues[$fieldPos['potenza']]))) <=.1)
                        {
                            $matching++;
                        }

                        //Tipo impianto
                        $tipo_impianto=$curImpianto->GetProp('tipologia');
                        if(isset($tipo_impianti_match[strtolower($csvValues[$fieldPos['classificazione']])]) && ($tipo_impianto & $tipo_impianti_match[strtolower($csvValues[$fieldPos['classificazione']])]) > 0)
                        {
                            $matching++;
                        }

                        if($matching > 0 && $matching > $max_matching)
                        {
                            $impianto_matched=$curImpianto;
                            $max_matching=$matching;
                        }
                    }

                    $curDataValues=array();
                    
                    if($impianto_matched) 
                    {
                        $curDataValues['id_impianto']=$impianto_matched->GetId();
                    }
                    else 
                    {
                        $curDataValues['id_impianto']=0;
                        $curDataValues['nome']="Impianto ad energia rinnovabile sito in  ".$csvValues[$fieldPos['comune']];
                        if(isset($tipo_impianti_match_new[strtolower($csvValues[$fieldPos['classificazione']])])) 
                        {
                            $curDataValues['Tipologia']=$tipo_impianti_match_new[strtolower($csvValues[$fieldPos['classificazione']])];
                            $curDataValues['nome']="Impianto ".$tipo_impianti[$curDataValues['Tipologia']]." sito in  ".$csvValues[$fieldPos['comune']];
                        }
                        $curDataValues['Stato']=0;
                        $curDataValues['AnnoAutorizzazione']="";
                        $curDataValues['AnnoCostruzione']="";
                        $curDataValues['AnnoEsercizio']="";
                        $curDataValues['AnnoDismissione']="";
                        $curDataValues['Potenza']=AA_Utils::number_format(floatVal(str_replace(",",".",str_replace(".","",$csvValues[$fieldPos['potenza']]))),2,".","");

                        $curDataValues['Superficie']="";
                        $curDataValues['Geo_comune']=trim($csvValues[$fieldPos['comune']]);
                        $curDataValues['Geo_localita']="";
                        $curDataValues['Geo_coordinate']="";

                        if(strtolower($csvValues[$fieldPos['data esercizio']]) !="")
                        {
                            $curDataValues['AnnoEsercizio']=date("Y-m-d",strtotime(str_replace(array("gen","feb","mar","apr","mag","giu","lug","ago","set","ott","nov","dic"),array("15-01","15-02","15-03","15-04","15-05","15-06","15-07","15-08","15-09","15-10","15-11","15-12"),$csvValues[$fieldPos['data esercizio']])));
                            $curDataValues['AnnoAutorizzazione']=$curDataValues['AnnoEsercizio'];
                            $curDataValues['AnnoCostruzione']=$curDataValues['AnnoEsercizio'];
                            $curDataValues['Stato']=AA_Geser_Const::AA_GESER_STATO_ESERCIZIO;
                        }

                        $curDataValues['Note']="Impianto importato da csv Terna - ".date("d/m/Y H:i:s");
                    }

                    $curDataValues['pratica_societa']=trim($csvValues[$fieldPos['ragione sociale']]);
                    $curDataValues['pratica_note']="Pratica importata da csv Terna - ".date("d/m/Y H:i:s");

                    $data[]=$curDataValues;
                }
            }
            $curRowNum++;
        }

        return $data;
    }

    protected function ElaborateCsvImportAssIndustria($rows=null)
    {
        return false;
    }

    protected function ElaborateCsvImportAssAmbiente($rows=null)
    {
        return false;
    }

    protected function ElaborateCsvImportSuape($csvRows=null)
    {
        if($csvRows==null)
        {
            return false;
        }

        //Parsing della posizione dei campi
        $fieldPos=array(
            "soggetto richiesta"=>-1,
            "impianto"=>-1,
            "comune"=>-1,
            "oggetto"=>-1,
            "potenza"=>-1,
            "stato"=>-1,
            "interventi"=>-1,
            "data_presentazione"=>-1,
            "protocollo_suape"=>-1
        );
        
        $recognizedFields=0;
        foreach(explode("|",$csvRows[0]) as $pos=>$curFieldName)
        {
            if($fieldPos[trim(strtolower($curFieldName))] == -1)
            {
                $fieldPos[trim(strtolower($curFieldName))] = $pos;
                $recognizedFields++;
            }
        }
        //----------------------------------------

        if($fieldPos['soggetto richiesta']==-1 || $fieldPos['impianto'] ==-1 || $fieldPos['comune'] ==-1 || $fieldPos['data_presentazione'] ==-1 || $fieldPos['potenza'] ==-1 || $fieldPos['stato'] ==-1 || $fieldPos['interventi'] ==-1)
        {
            AA_Log::Log(__METHOD__." - Non sono stati trovati tutti i campi relativi a: Soggetto Richiesta,impianto,comune,data_presentazione,potenza,stato,interventi. - ".print_r($fieldPos,true),100);
           return false;
        }

        //parsing dei dati
        $data=array();
        $curRowNum=0;
        $tipo_impianti_match=array(
            "biomasse"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOGAS,
            "fotovoltaico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_TERMODINAMICO,
            "agrivoltaico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_AGRIVOLTAICO,
            "eolico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO|AA_Geser_Const::AA_GESER_TIPOIMPIANTO_OFFSHORE,
            "eolico on-shore"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "idroelettrico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_IDROELETTRICO,
        );

        $tipo_impianti_match_new=array(
            "biomasse"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_BIOMASSA,
            "fotovoltaico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_FOTOVOLTAICO,
            "agrivoltaico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_AGRIVOLTAICO,
            "eolico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "eolico on-shore"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_EOLICO,
            "idroelettrico"=>AA_Geser_Const::AA_GESER_TIPOIMPIANTO_IDROELETTRICO,
        );

        $tipo_impianti=AA_Geser_Const::GetListaTipoImpianti();
        $impianti_esistenti=AA_Geser::Search(array("stato"=>AA_Const::AA_STATUS_PUBBLICATA),$this->oUser);
        
        foreach($csvRows as $curCsvRow)
        {
            //salta la prima riga
            if($curRowNum > 0 && $curCsvRow !="")
            {
                $csvValues=explode("|",$curCsvRow);
                if(sizeof($csvValues) >= $recognizedFields)
                {
                    //cerca un match tra gli impianti esistenti
                    $impianto_matched=null;
                    $max_matching=0;
                    foreach($impianti_esistenti[1] as $curImpianto)
                    {
                        $matching=0;
                        //comune
                        $geolocalizzazione=$curImpianto->GetGeolocalizzazione();
                        if(isset($geolocalizzazione['comune']) && strpos(strtolower($geolocalizzazione['comune']),strtolower($csvValues[$fieldPos['comune']])) !== false)
                        {
                            $matching++;
                        }

                        //potenza (+- 10%)
                        if(floatVal($curImpianto->GetProp('potenza'))-floatVal(str_replace(",",".",str_replace(".","",$csvValues[$fieldPos['potenza']]))) <=.1)
                        {
                            $matching++;
                        }

                        //Tipo impianto
                        $tipo_impianto=$curImpianto->GetProp('tipologia');
                        if(isset($tipo_impianti_match[strtolower($csvValues[$fieldPos['impianto']])]) && ($tipo_impianto & $tipo_impianti_match[strtolower($csvValues[$fieldPos['impianto']])]) > 0)
                        {
                            $matching++;
                        }

                        if($matching > 0 && $matching > $max_matching)
                        {
                            $impianto_matched=$curImpianto;
                            $max_matching=$matching;
                        }
                    }

                    $curDataValues=array();
                    $data_inizio=date("Y-m-d",strtotime(substr($csvValues[$fieldPos['data_presentazione']],6,4)."-".substr($csvValues[$fieldPos['data_presentazione']],3,2)."-".substr($csvValues[$fieldPos['data_presentazione']],0,2)));

                    if($impianto_matched) 
                    {
                        $curDataValues['id_impianto']=$impianto_matched->GetId();
                    }
                    else 
                    {
                        $curDataValues['id_impianto']=0;
                        $curDataValues['nome']="Impianto ad energia rinnovabile sito in  ".$csvValues[$fieldPos['comune']];
                        if(isset($tipo_impianti_match_new[strtolower($csvValues[$fieldPos['impianto']])])) 
                        {
                            $curDataValues['Tipologia']=$tipo_impianti_match_new[strtolower($csvValues[$fieldPos['impianto']])];
                            $curDataValues['nome']="Impianto ".$tipo_impianti[$curDataValues['Tipologia']]." sito in  ".$csvValues[$fieldPos['comune']];
                        }
                        $curDataValues['Stato']=AA_Geser_Const::AA_GESER_STATO_AUTORIZZAZIONE;
                        $curDataValues['AnnoAutorizzazione']="";
                        $curDataValues['AnnoCostruzione']="";
                        $curDataValues['AnnoEsercizio']="";
                        $curDataValues['AnnoDismissione']="";
                        $curDataValues['Potenza']=AA_Utils::number_format(floatVal(str_replace(",",".",str_replace(".","",$csvValues[$fieldPos['potenza']]))),2,".","");

                        $curDataValues['Superficie']="";
                        $curDataValues['Geo_comune']=trim($csvValues[$fieldPos['comune']]);
                        $curDataValues['Geo_localita']="";
                        $curDataValues['Geo_coordinate']="";

                        if(strtolower($csvValues[$fieldPos['data_presentazione']]) !="")
                        {
                            $curDataValues['AnnoAutorizzazione']=$data_inizio;
                            //$curDataValues['AnnoEsercizio']=$curDataValues['AnnoAutorizzazione'];
                            //$curDataValues['AnnoCostruzione']=$curDataValues['AnnoEsercizio'];
                            $curDataValues['Stato']=AA_Geser_Const::AA_GESER_STATO_AUTORIZZAZIONE;
                        }

                        $curDataValues['Note']="Impianto importato da csv Suape - ".date("d/m/Y H:i:s");
                    }

                    $curDataValues['pratica_societa']=trim($csvValues[$fieldPos['soggetto richiesta']]);
                    $curDataValues['pratica_stato']=AA_Geser_Const::AA_GESER_STATO_PRATICA_INLAVORAZIONE;
                    $curDataValues['pratica_data_inizio']=$data_inizio;
                    $curDataValues['pratica_note']=trim($csvValues[$fieldPos['oggetto']]);

                    $data[]=$curDataValues;
                }
            }
            $curRowNum++;
        }

        return $data;
    }

    //Task aggiungi allegato
    public function Task_GetGeserAddNewAllegatoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserAddNewAllegatoDlg($object),true);
        return true;
    }

    //Task aggiungi allegato
    public function Task_GetGeserAddNewPraticaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserAddNewPraticaDlg($object),true);
        return true;
    }

    //Task modifica pratica esistente
    public function Task_GetGeserModifyPraticaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $pratiche=$object->GetPratiche();
        if(!isset($pratiche[$_REQUEST['id_pratica']]))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo pratica non presente",false);

            return false;
        }

        $pratica=$pratiche[$_REQUEST['id_pratica']];
        $pratica['id']=$_REQUEST['id_pratica'];

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserModifyPraticaDlg($object,$pratica),true);
        return true;
    }

    //Task modifica pratica esistente
    public function Task_GetGeserCopyPraticaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $pratiche=$object->GetPratiche();
        if(!isset($pratiche[$_REQUEST['id_pratica']]))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo pratica non presente",false);

            return false;
        }

        $pratica=$pratiche[$_REQUEST['id_pratica']];
        $pratica['id']=$_REQUEST['id_pratica'];

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserCopyPraticaDlg($object,$pratica),true);
        return true;
    }

    //Task elimina pratica esistente
    public function Task_GetGeserTrashPraticaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $pratiche=$object->GetPratiche();
        if(!isset($pratiche[$_REQUEST['id_pratica']]))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo pratica non presente",false);

            return false;
        }

        $pratica=$pratiche[$_REQUEST['id_pratica']];
        $pratica['id']=$_REQUEST['id_pratica'];

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserTrashPraticaDlg($object,$pratica),true);
        return true;
    }
    
    
    //Task aggiorna allegato
    public function Task_UpdateGeserAllegato($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        $uploadedFile = AA_SessionFileUpload::Get("NewAllegatoDoc");

        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);
            
            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }     

            return false;
        }

        if($_REQUEST['id_allegato']=="" || $_REQUEST['id_allegato']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo allegato non valido.",false);

            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }

            return false;
        }

        $object= new AA_Geser($_REQUEST['id'],$this->oUser);

        if(!$object->isValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo elemento non valido o permessi insufficienti. (".$_REQUEST['id'].")",false);

            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }     

            return false;
        }
        
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per poter modificare l'elemento (".$object->GetId().").",false);

            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }     
        
            return true;
        }

        $allegati=$object->GetAllegati();
        $allegato=$allegati[$_REQUEST['id_allegato']];
        if($allegato==null)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("identificativo allegato non valido (".$_REQUEST['id_allegato'].").",false);

            //Elimina il file temporaneo
            if($uploadedFile->isValid())
            {   
                $file=$uploadedFile->GetValue();
                if(file_exists($file['tmp_name']))
                {
                    if(!unlink($file['tmp_name']))
                    {
                        AA_Log::Log(__METHOD__." - Errore nella rimozione del file temporaneo. ".$file['tmp_name'],100);
                    }
                }
            }     
        
            return false;
        }

        //Se c'è un file uploadato l'url non viene salvata.
        if($uploadedFile->isValid()) 
        {
            $_REQUEST['url']="";

            $storage=AA_Storage::GetInstance($this->oUser);
            if($storage->IsValid())
            {
                //Se l'allegato era sullo storage lo elimina
                $oldFile=$allegato['filehash'];
                if($oldFile !="")
                {
                    if(!$storage->DelFile($oldFile))
                    {
                        AA_Log::Log(__METHOD__." - errore nella rimozione del file: ".$oldFile,100);
                    }
                }

                $file=$uploadedFile->GetValue();
                $storageFile=$storage->Addfile($file['tmp_name'],$file['name'],$file['type'],1);
                if($storageFile->IsValid())
                {
                    $allegato['filehash']=$storageFile->GetFileHash();
                }
                else
                {
                    AA_Log::Log(__METHOD__." - errore nell'aggiunta allo storage. file non salvato.",100);
                }
            }
            else AA_Log::Log(__METHOD__." - storage non inizializzato. file non salvato.",100);

            //Elimina il file temporaneo
            if(file_exists($file['tmp_name']))
            {
                if(!unlink($file['tmp_name']))
                {
                    AA_Log::Log(__METHOD__." - errore nella rimozione del file: ".$file['tmp_name'],100);
                }
            }
        }

        //Elimina il file precedentemente associato se viene impostato un url
        if($_REQUEST['url'] !="" && $allegato['filehash'] !="")
        {
            $allegato['url']=$_REQUEST['url'];
            $storage=AA_Storage::GetInstance($this->oUser);
            if($storage->IsValid())
            {
                //Se l'allegato era sullo storage lo elimina
                $oldFile=$allegato['filehash'];
                if($oldFile !="")
                {
                    if(!$storage->DelFile($oldFile))
                    {
                        AA_Log::Log(__METHOD__." - errore nella rimozione del file: ".$oldFile,100);
                    }
                    $allegato['filehash']="";
                }
            }
            else AA_Log::Log(__METHOD__." - storage non inizializzato. file non eliminato.",100);
        }

        if(isset($_REQUEST['descrizione']) && $_REQUEST['descrizione'] !="")
        {
            $allegato['descrizione']=$_REQUEST['descrizione'];
        }

        if(isset($_REQUEST['tipo']) && $_REQUEST['tipo'] > 0)
        {
            $allegato['tipo']=$_REQUEST['tipo'];
        }

        $allegati[$_REQUEST['id_allegato']]=$allegato;
        $object->SetAllegati($allegati);
        
        if(!$object->Update($this->oUser,true,"Aggiornamento allegato: ".$_REQUEST['id_allegato']))
        {        
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nell'aggiornamento dell'allegato. (".AA_Log::$lastErrorLog.")",false);
            
            return false;       
        }
        
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent("Allegato aggiornato con successo.",false);

        return true;
    }

    //Task elimina allegato
    public function Task_DeleteGeserAllegato($task)
    {
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);
            return false;
        }

        if($_REQUEST['id_allegato']=="" || $_REQUEST['id_allegato']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo allegato non valido.",false);
            return false;
        }

        $object= new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->isValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo elemento non valido o permessi insufficienti. (".$_REQUEST['id'].")",false);
            return false;
        }
        
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per poter modificare l'elemento (".$object->GetId().").",false);
            return true;
        }

        if(!$object->DeleteAllegato($_REQUEST['id_allegato'],$this->oUser))
        {        
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Errore nella rimozione dell'allegato/link. (".AA_Log::$lastErrorLog.")",false);
            
            return false;       
        }
        
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent("Allegato/link rimosso con successo.",false);

        return true;
    }

    
    //Task modifica allegato
    public function Task_GetGeserModifyAllegatoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if($_REQUEST['id_allegato']=="" || $_REQUEST['id_allegato']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo allegato non valido.",false);

            return false;
        }

        $object=new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->IsValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);

            return false;
        }

        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi di modifica dell'elemento",false);

            return false;
        }

        $allegati=$object->GetAllegati();
        if(!isset($allegati[$_REQUEST['id_allegato']]))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo allegato non valido.",false);

            return false;
        }

        $allegato=$allegati[$_REQUEST['id_allegato']];
        $allegato['id']=$_REQUEST['id_allegato'];

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserModifyAllegatoDlg($object,$allegato),true);

        return true;
    }

    //Task trash allegato
    public function Task_GetGeserTrashAllegatoDlg($task)
    {
        if($_REQUEST['id']=="" || $_REQUEST['id']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo oggetto non valido.",false);
            return false;
        }

        if($_REQUEST['id_allegato']=="" || $_REQUEST['id_allegato']<=0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo allegato non valido.",false);
            return false;
        }

        $object= new AA_Geser($_REQUEST['id'],$this->oUser);
        if(!$object->isValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo elemento non valido o permessi insufficienti. (".$_REQUEST['id'].")",false);
            return false;
        }
        
        if(($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente non ha i permessi per poter modificare l'elemento (".$object->GetId().").",false);
            return true;
        }

        $allegato=$object->GetAllegato($_REQUEST['id_allegato']);
        if($allegato==null)
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("identificativo allegato non valido (".$_REQUEST['id_allegato'].").",false);
        
            return false;
        }

        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetGeserTrashAllegatoDlg($object,$allegato),true);
        return true;
    }
    
    //Task filter dlg
    public function Task_GetGeserPubblicateFilterDlg($task)
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
    public function Task_GetGeserBozzeFilterDlg($task)
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
        if(!$this->oUser->HasFlag(AA_Geser_Const::AA_USER_FLAG_GESER))
        {
            $_REQUEST['section']=static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX;
        }
        
        return $this->Task_GetGenericNavbarContent($task,$_REQUEST);
    }
    
    //Template filtro di ricerca
    public function TemplatePubblicateFilterDlg($params=array())
    {
        //Valori runtime
        $formData=array("comune"=>$params['comune'],"id_assessorato"=>$params['id_assessorato'],"id_direzione"=>$params['id_direzione'],"struct_desc"=>$params['struct_desc'],"id_struct_tree_select"=>$params['id_struct_tree_select'],"nome"=>$params['nome'],"cestinate"=>$params['cestinate'],"tipo"=>$params['tipo'],"stato"=>$params['stato']);
        
        //Valori default
        if($params['struct_desc']=="") $formData['struct_desc']="Qualunque";
        if($params['id_assessorato']=="") $formData['id_assessorato']=0;
        if($params['id_direzione']=="") $formData['id_direzione']=0;
        if($params['id_servizio']=="") $formData['id_servizio']=0;
        if($params['cestinate']=="") $formData['cestinate']=0;
        if($params['nome']=="") $formData['nome']="";
        if($params['tipo']=="") $formData['tipo']=0;
        if($params['stato']=="") $formData['stato']=0;
        if($params['comune']=="") $formData['comune']="Qualunque";

        //Valori reset
        $resetData=array("comune"=>"Qualunque","id_assessorato"=>0,"id_direzione"=>0,"id_servizio"=>0, "struct_desc"=>"Qualunque","id_struct_tree_select"=>"","nome"=>"","cestinate"=>0,"tipo"=>0,"stato"=>0);
        
        //Azioni da eseguire dopo l'applicazione del filtro
        $applyActions="module.refreshCurSection()";
        
        $dlg = new AA_GenericFilterDlg(static::AA_UI_PREFIX."_Pubblicate_Filter".uniqid(), "Parametri di ricerca per le schede in bozza",$this->GetId(),$formData,$resetData,$applyActions);
        
        $dlg->SetHeight(580);
                
        //Cestinate
        $dlg->AddSwitchBoxField("cestinate","Cestino",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede cestinate."));
      
        //tipo
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Geser_Const::GetListaTipoImpianti() as $key=>$val)
        {
            $options[]=array("id"=>$key,"value"=>$val);
        }
        $dlg->AddSelectField("tipo","Tipo impianto",array("gravity"=>2,"bottomLabel"=>"*Filtra in base al tipo di impianto.","options"=>$options,"value"=>"0"));

        //stato
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Geser_Const::GetListaStatiImpianto() as $key=>$val)
        {
            $options[]=array("id"=>$key,"value"=>$val);
        }
        $dlg->AddSelectField("stato","Stato impianto",array("gravity"=>2,"bottomLabel"=>"*Filtra in base allo stato dell'impianto.","options"=>$options,"value"=>"0"));

         //comune
         $options=array(array("id"=>"Qualunque","value"=>"Qualunque"));
         foreach(AA_Geser_Const::GetListaComuni() as $key=>$val)
         {
             $options[]=array("id"=>$val,"value"=>$val);
         }
         $dlg->AddComboField("comune","Comune",array("gravity"=>2,"bottomLabel"=>"*Filtra in base al comune dove e' situato l'impianto.","options"=>$options,"value"=>"0"));
 
        //titolo
        $dlg->AddTextField("nome","Denominazione",array("bottomLabel"=>"*Filtra in base alla denominazione dell'impianto.", "placeholder"=>"..."));

        $dlg->SetApplyButtonName("Filtra");

        return $dlg->GetObject();
    }
    
    //Template filtro di ricerca
    public function TemplateBozzeFilterDlg($params=array())
    {
        //Valori runtime
        $formData=array("comune"=>$params['comune'],"id_assessorato"=>$params['id_assessorato'],"id_direzione"=>$params['id_direzione'],"struct_desc"=>$params['struct_desc'],"id_struct_tree_select"=>$params['id_struct_tree_select'],"nome"=>$params['nome'],"cestinate"=>$params['cestinate'],"tipo"=>$params['tipo'],"stato"=>$params['stato']);
        
        //Valori default
        if($params['struct_desc']=="") $formData['struct_desc']="Qualunque";
        if($params['id_assessorato']=="") $formData['id_assessorato']=0;
        if($params['id_direzione']=="") $formData['id_direzione']=0;
        if($params['id_servizio']=="") $formData['id_servizio']=0;
        if($params['cestinate']=="") $formData['cestinate']=0;
        if($params['nome']=="") $formData['nome']="";
        if($params['tipo']=="") $formData['tipo']=0;
        if($params['stato']=="") $formData['stato']=0;
        if($params['comune']=="") $formData['comune']="Qualunque";

        //Valori reset
        $resetData=array("comune"=>"Qualunque","id_assessorato"=>0,"id_direzione"=>0,"id_servizio"=>0, "struct_desc"=>"Qualunque","id_struct_tree_select"=>"","nome"=>"","cestinate"=>0,"tipo"=>0,"stato"=>0);
        
        //Azioni da eseguire dopo l'applicazione del filtro
        $applyActions="module.refreshCurSection()";
        
        $dlg = new AA_GenericFilterDlg(static::AA_UI_PREFIX."_Bozze_Filter".uniqid(), "Parametri di ricerca per le schede in bozza",$this->GetId(),$formData,$resetData,$applyActions);
        
        $dlg->SetHeight(580);
                
        //Cestinate
        $dlg->AddSwitchBoxField("cestinate","Cestino",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede cestinate."));
      
        //tipo
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Geser_Const::GetListaTipoImpianti() as $key=>$val)
        {
            $options[]=array("id"=>$key,"value"=>$val);
        }
        $dlg->AddSelectField("tipo","Tipo impianto",array("gravity"=>2,"bottomLabel"=>"*Filtra in base al tipo di impianto.","options"=>$options,"value"=>"0"));

        //stato
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Geser_Const::GetListaStatiImpianto() as $key=>$val)
        {
            $options[]=array("id"=>$key,"value"=>$val);
        }
        $dlg->AddSelectField("stato","Stato impianto",array("gravity"=>2,"bottomLabel"=>"*Filtra in base allo stato dell'impianto.","options"=>$options,"value"=>"0"));

        //comune
        $options=array(array("id"=>"Qualunque","value"=>"Qualunque"));
        foreach(AA_Geser_Const::GetListaComuni() as $key=>$val)
        {
            $options[]=array("id"=>$val,"value"=>$val);
        }
        $dlg->AddComboField("comune","Comune",array("gravity"=>2,"bottomLabel"=>"*Filtra in base al comune dove e' situato l'impianto.","options"=>$options,"value"=>"0"));

        //titolo
        $dlg->AddTextField("nome","Denominazione",array("bottomLabel"=>"*Filtra in base alla denominazione dell'impianto.", "placeholder"=>"..."));
        
        $dlg->SetApplyButtonName("Filtra");

        return $dlg->GetObject();
    }
    
    //Funzione di esportazione in pdf (da specializzare)
    public function Template_PdfExport($ids=array(),$toBrowser=true,$title="Pubblicazione ai sensi dell'art.26-27 del d.lgs. 33/2013",$rowsForPage=20,$index=false,$subTitle="")
    {
        return $this->Template_GenericPdfExport($ids,$toBrowser,$title,"Template_GeserPdfExport", $rowsForPage, $index,$subTitle);
    }

    //funzione di aiuto
    public function Task_AMAAI_Start($task)
    {
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        
        $task->SetContent($this->Template_GetGeserHelpDlg(),true);
        
        $help_url="";
        $action='AA_MainApp.utils.callHandler("pdfPreview", { url: this.taskManager + "?task=PdfExport&section=" + this.curSection.id }, this.id);';
        
        return true;

    }

    //Template pdf export single
    public function Template_GeserPdfExport($id="", $parent=null,$object=null,$user=null)
    {
        if(!($object instanceof AA_Geser))
        {
            return "";
        }
        
        if($id=="") $id="Template_GeserPdfExport_".$object->GetId();

        return new AA_GeserPublicReportTemplateView($id,$parent,$object);
    }

    //Template dettaglio allegati
    public function TemplateDettaglio_Allegati($object=null,$id="", $canModify=false)
    {
        #documenti----------------------------------
        $curId=$id."_Layout_Allegati";
        $provvedimenti=new AA_JSON_Template_Layout($curId,array("type"=>"clean","gravity"=>4,"css"=>array("border-left"=>"1px solid gray !important;","border-top"=>"1px solid gray !important;")));

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
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetGeserAddNewAllegatoDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
            ));

            $toolbar->AddElement($add_documento_btn);
        }
        else 
        {
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
        }

        $provvedimenti->AddRow($toolbar);

        $options_documenti=array();

      
        $options_documenti[]=array("id"=>"tipo","header"=>array("<div style='text-align: center'>Tipo</div>"),"width"=>100, "css"=>array("text-align"=>"left"),"sort"=>"text");
        $options_documenti[]=array("id"=>"descrizione","header"=>array("<div style='text-align: center'>Descrizione</div>"),"fillspace"=>true, "css"=>array("text-align"=>"left"),"sort"=>"text");
        $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
    
        $documenti=new AA_JSON_Template_Generic($curId."_Allegati_Table",array("view"=>"datatable", "select"=>true,"scrollX"=>false,"css"=>"AA_Header_DataTable","columns"=>$options_documenti));

        $documenti_data=array();
        $allegati=$object->GetAllegati();
        $listaTipo=AA_Geser_Const::GetListaTipoAllegati();
        foreach($allegati as $id_doc=>$curDoc)
        {
            if($curDoc['filehash'] != "")
            {
                $view='AA_MainApp.utils.callHandler("pdfPreview", {url: "storage.php?object='.$curDoc['filehash'].'"},"'.$this->id.'")';
                $view_icon="mdi-floppy";
            }
            else 
            {
                $view='AA_MainApp.utils.callHandler("wndOpen", {url: "'.$curDoc['url'].'"},"'.$this->id.'")';
                $view_icon="mdi-eye";
            }
            
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserTrashAllegatoDlg", params: [{id: "'.$object->GetId().'"},{id_allegato:"'.$id_doc.'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetGeserModifyAllegatoDlg", params: [{id: "'.$object->GetId().'"},{id_allegato:"'.$id_doc.'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='Vedi' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="<div class='AA_DataTable_Ops' style='justify-content: center'><a class='AA_DataTable_Ops_Button' title='Vedi' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a></div>";
            $documenti_data[]=array("id"=>$id_doc,"descrizione"=>$curDoc['descrizione'],"tipo"=>$listaTipo[$curDoc['tipo']],"ops"=>$ops);
        }
        $documenti->SetProp("data",$documenti_data);
        if(sizeof($documenti_data) > 0) $provvedimenti->AddRow($documenti);
        else $provvedimenti->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        #--------------------------------------
        
        return $provvedimenti;
    }

    //Task action menù
    public function Task_GetActionMenu($task)
    {
        $sTaskLog = "<status id='status'>0</status><content id='content' type='json' encode='base64'>";

        $content = "";

        switch ($_REQUEST['section']) {
            default:
                return parent::Task_GetActionMenu($task);
        }

        if ($content != "") $sTaskLog .= $content->toBase64();

        $sTaskLog .= "</content>";

        $task->SetLog($sTaskLog);

        return true;
    }
}

#Classe template per la gestione del report pdf dell'oggetto
Class AA_GeserPublicReportTemplateView extends AA_GenericObjectTemplateView
{
    public function __construct($id="AA_GeserPublicReportTemplateView",$parent=null,$object=null)
    {
        if(!($object instanceof AA_Geser))
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

        /*if($object->GetTipo(true) == AA_Geser_Const::AA_TIPO_PROVVEDIMENTO_SCELTA_CONTRAENTE)
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
