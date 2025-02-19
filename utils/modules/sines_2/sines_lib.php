<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "art22_lib.php";
include_once "pdf_lib.php";

#Classe per il modulo Sines
Class AA_SinesModule extends AA_GenericModule
{
    const AA_UI_PREFIX="AA_Sines";
    const AA_UI_SCADENZARIO_BOX="Scadenzario_Content_Box";
    const AA_UI_TEMPLATE_PARTECIPAZIONI="Partecipazioni";
    const AA_UI_WND_NOMINA_DETAIL="NominaDetailWnd";
    const AA_UI_LAYOUT_NOMINA_DETAIL="NominaDetailLayout";

    const AA_MODULE_OBJECTS_CLASS = "AA_Organismi";

    //Id modulo
    const AA_ID_MODULE="AA_MODULE_SINES";

    public function __construct($user=null)
    {
        parent::__construct($user,false);
        
        //{"id": "sines", "icon": "mdi mdi-office-building", "value": "Sistema Informativo Enti e Società", "tooltip": "SINES - Sistema Informativo Enti e Società", "module":"AA_MODULE_SINES"}
        //Sidebar config
        $this->SetSideBarId("sines");
        $this->SetSideBarIcon("mdi mdi-office-building");
        $this->SetSideBarTooltip("SINES - Sistema Informativo Enti e Società");
        $this->SetSideBarName("Sistema Informativo Enti e Società");
        
        //Registrazione dei task-------------------
        $taskManager=$this->GetTaskManager();
        
        //$taskManager->RegisterTask("GetSections");
        //$taskManager->RegisterTask("GetLayout");
        //$taskManager->RegisterTask("GetActionMenu");
        //$taskManager->RegisterTask("GetNavbarContent");
        //$taskManager->RegisterTask("GetSectionContent");
        //$taskManager->RegisterTask("GetObjectContent");
        $taskManager->RegisterTask("GetPubblicateFilterDlg");
        $taskManager->RegisterTask("GetBozzeFilterDlg");
        $taskManager->RegisterTask("GetScadenzarioFilterDlg");
        $taskManager->RegisterTask("GetLogDlg");
        
        //organismi
        $taskManager->RegisterTask("GetOrganismoModifyDlg");
        $taskManager->RegisterTask("GetOrganismoAddNewDlg");
        $taskManager->RegisterTask("GetOrganismoTrashDlg");
        $taskManager->RegisterTask("TrashOrganismi");
        $taskManager->RegisterTask("GetOrganismoDeleteDlg");
        $taskManager->RegisterTask("DeleteOrganismi");
        $taskManager->RegisterTask("GetOrganismoResumeDlg");
        $taskManager->RegisterTask("ResumeOrganismi");
        $taskManager->RegisterTask("GetOrganismoReassignDlg");
        $taskManager->RegisterTask("GetOrganismoPublishDlg");
        $taskManager->RegisterTask("ReassignOrganismi");
        $taskManager->RegisterTask("AddNewOrganismo");
        $taskManager->RegisterTask("UpdateOrganismo");
        $taskManager->RegisterTask("PublishOrganismo");
        $taskManager->RegisterTask("GetOrganismoAddNewProvvedimentoDlg");
        $taskManager->RegisterTask("AddNewOrganismoProvvedimento");
        $taskManager->RegisterTask("GetOrganismoModifyProvvedimentoDlg");
        $taskManager->RegisterTask("UpdateOrganismoProvvedimento");
        $taskManager->RegisterTask("GetOrganismoTrashProvvedimentoDlg");
        $taskManager->RegisterTask("TrashOrganismoProvvedimento");
        
        //partecipazioni
        $taskManager->RegisterTask("GetSinesAddNewPartecipazioneDlg");
        $taskManager->RegisterTask("AddNewSinesPartecipazione");
        $taskManager->RegisterTask("GetSinesModifyPartecipazioneDlg");
        $taskManager->RegisterTask("UpdateSinesPartecipazione");
        $taskManager->RegisterTask("GetSinesTrashPartecipazioneDlg");
        $taskManager->RegisterTask("TrashSinesPartecipazione");

        //Generico
        $taskManager->RegisterTask("GetTipoBilanci");
        
        //Dati contabili
        $taskManager->RegisterTask("GetOrganismoModifyDatoContabileDlg");
        $taskManager->RegisterTask("GetOrganismoAddNewDatoContabileDlg");
        $taskManager->RegisterTask("GetOrganismoTrashDatoContabileDlg");
        $taskManager->RegisterTask("AddNewOrganismoDatoContabile");
        $taskManager->RegisterTask("UpdateOrganismoDatoContabile");
        $taskManager->RegisterTask("TrashOrganismoDatoContabile");
        #------------------------------------------
        
        //bilanci
        $taskManager->RegisterTask("GetOrganismoAddNewBilancioDlg");
        $taskManager->RegisterTask("AddNewOrganismoBilancio");
        $taskManager->RegisterTask("GetOrganismoModifyBilancioDlg");
        $taskManager->RegisterTask("UpdateOrganismoBilancio");
        $taskManager->RegisterTask("GetOrganismoTrashBilancioDlg");
        $taskManager->RegisterTask("TrashOrganismoBilancio");
        //--------------------------------------------
        
        //nomine
        $taskManager->RegisterTask("GetOrganismoNomineFilterDlg");
        $taskManager->RegisterTask("GetOrganismoModifyIncaricoDlg");
        $taskManager->RegisterTask("UpdateOrganismoIncarico");
        $taskManager->RegisterTask("GetOrganismoAddNewIncaricoDlg");
        $taskManager->RegisterTask("AddNewOrganismoIncarico");
        $taskManager->RegisterTask("GetOrganismoAddNewNominaDlg");
        $taskManager->RegisterTask("AddNewOrganismoNomina");
        $taskManager->RegisterTask("GetOrganismoRenameNominaDlg");
        $taskManager->RegisterTask("RenameOrganismoNomina");
        $taskManager->RegisterTask("GetOrganismoTrashIncaricoDlg");
        $taskManager->RegisterTask("TrashOrganismoIncarico");
        $taskManager->RegisterTask("GetOrganismoTrashNominaDlg");
        $taskManager->RegisterTask("TrashOrganismoNomina");
        $taskManager->RegisterTask("GetOrganismoAddNewIncaricoDocDlg");
        $taskManager->RegisterTask("AddNewOrganismoIncaricoDoc");
        $taskManager->RegisterTask("GetOrganismoTrashIncaricoDocDlg");
        $taskManager->RegisterTask("TrashOrganismoIncaricoDoc");
        $taskManager->RegisterTask("GetOrganismoAddNewIncaricoCompensoDlg");
        $taskManager->RegisterTask("AddNewOrganismoIncaricoCompenso");
        $taskManager->RegisterTask("GetOrganismoTrashIncaricoCompensoDlg");
        $taskManager->RegisterTask("TrashOrganismoIncaricoCompenso");
        $taskManager->RegisterTask("GetOrganismoModifyIncaricoCompensoDlg");
        $taskManager->RegisterTask("UpdateOrganismoIncaricoCompenso");
        $taskManager->RegisterTask("GetOrganismoNominaDetailViewDlg");
        
        //Organigrammi
        $taskManager->RegisterTask("GetOrganismoAddNewOrganigrammaDlg");
        $taskManager->RegisterTask("AddNewOrganismoOrganigramma");
        $taskManager->RegisterTask("GetOrganismoModifyOrganigrammaDlg");
        $taskManager->RegisterTask("UpdateOrganismoOrganigramma");
        $taskManager->RegisterTask("GetOrganismoDeleteOrganigrammaDlg");
        $taskManager->RegisterTask("DeleteOrganismoOrganigramma");

        $taskManager->RegisterTask("GetOrganismoAddNewOrganigrammaIncaricoDlg");
        $taskManager->RegisterTask("AddNewOrganismoOrganigrammaIncarico");
        $taskManager->RegisterTask("GetOrganismoModifyOrganigrammaIncaricoDlg");
        $taskManager->RegisterTask("UpdateOrganismoOrganigrammaIncarico");
        $taskManager->RegisterTask("GetOrganismoDeleteOrganigrammaIncaricoDlg");
        $taskManager->RegisterTask("DeleteOrganismoOrganigrammaIncarico");

        //Pdf export
        $taskManager->RegisterTask("PdfExport");
        
        //Sezioni----------------------------------------
        
        //Schede pubblicate
        $navbarTemplate=array($this->TemplateNavbar_Bozze(1,false)->toArray(),$this->TemplateNavbar_Scadenzario(2,true)->toArray());
        $section=new AA_GenericModuleSection("Pubblicate","Schede pubblicate",true, static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX,$this->GetId(),true,true,false,true);
        $section->SetNavbarTemplate($navbarTemplate);
        $this->AddSection($section);
        
        //Bozze
        $navbarTemplate= $this->TemplateNavbar_Pubblicate(1,true)->toArray();
        $section=new AA_GenericModuleSection("Bozze","Schede in bozza",true,static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX,$this->GetId(),false,true,false,true);
        $section->SetNavbarTemplate($navbarTemplate);
        $this->AddSection($section);
        
        //dettaglio
        $navbarTemplate=$this->TemplateNavbar_Back(1,true)->toArray();
        $section=new AA_GenericModuleSection("Dettaglio","Dettaglio",false,static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX,$this->GetId(),false,true,true,true);
        $section->SetNavbarTemplate($navbarTemplate);
        $this->AddSection($section);
        
        //Scadenzario
        $navbarTemplate=$this->TemplateNavbar_Pubblicate(1,true)->toArray();
        $section=new AA_GenericModuleSection("Scadenzario","Agenda nomine",true,static::AA_UI_PREFIX."_".static::AA_UI_SCADENZARIO_BOX,$this->GetId(),false,true,false,true);
        $section->SetNavbarTemplate($navbarTemplate);
        $this->AddSection($section);
        
        #-------------------------------------------

        $this->AddObjectTemplate(static::AA_UI_PREFIX."_".static::AA_UI_WND_NOMINA_DETAIL."_".static::AA_UI_LAYOUT_NOMINA_DETAIL,"Template_GetOrganismoNominaDetailViewLayout");

    }
    
    //istanza
    protected static $oInstance=null;
    
    //Restituisce l'istanza corrente
    public static function GetInstance($user=null)
    {
        if(self::$oInstance==null)
        {
            self::$oInstance=new AA_SinesModule($user);
        }
        
        return self::$oInstance;
    }
    
    //Layout del modulo
    function TemplateLayout()
    {
        $template=new AA_JSON_Template_Multiview(static::AA_UI_PREFIX."_module_layout",array("type"=>"clean","fitBiggest"=>"true"));
        foreach ($this->GetSections() as $curSection)
        {
            $template->addCell(new AA_JSON_Template_Template($curSection->GetViewId(),array("name"=>$curSection->GetName(),"type"=>"clean","template"=>"","initialized"=>false,"refreshed"=>false)));
        }
        
        //AA_Log::Log("TemplateLayout - ".$template,100);
        return $template;
    }
    
     //Template bozze content
    public function TemplateSection_Placeholder()
    {
        
        $content = new AA_JSON_Template_Template(static::AA_UI_PREFIX."_Placeholder_Content",
                array(
                "type"=>"clean",
                "template"=>"placeholder"
            ));
         
        return $content;
    }
    
    //Template bozze content
    public function TemplateSection_Bozze($params=null)
    {
       $is_enabled = false;
       
        if($this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22))
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
                
        $content=new AA_GenericPagedSectionTemplate(static::AA_UI_PREFIX."_Bozze",$this->GetId());
        $content->EnablePager();
        $content->SetPagerItemForPage(10);
        $content->EnableFiltering();
        $content->EnableAddNew();
        $content->SetAddNewDlgTask("GetOrganismoAddNewDlg");
        $content->SetFilterDlgTask("GetBozzeFilterDlg");
        $content->ViewExportFunctions();
        
        $content->SetSectionName("Schede in bozza");
        
        //Imposta una dimensione fissa per il contenuto
        //$content->SetContentItemHeight(110);
        
        $content->ViewDetail();
        
        if($_REQUEST['cestinate']==0)
        {
            $content->ViewTrash();
            $content->SetTrashHandlerParams(array("task"=>"GetOrganismoTrashDlg"));
            $content->ViewPublish();
            $content->SetPublishHandlerParams(array("task"=>"GetOrganismoPublishDlg"));
            $content->ViewReassign();
            $content->SetReassignHandlerParams(array("task"=>"GetOrganismoReassignDlg"));
        }
        else 
        {
            $content->SetSectionName("Schede in bozza cestinate");
            $content->ViewResume();
            $content->SetResumeHandlerParams(array("task"=>"GetOrganismoResumeDlg"));
            $content->ViewDelete();
            $content->SetDeleteHandlerParams(array("task"=>"GetOrganismoDeleteDlg"));
            $content->HideReassign();
            $content->EnableAddNew(false);
        }            
                
        $_REQUEST['count']=10;
        
        $contentData=$this->GetDataSectionBozze_List($_REQUEST);
        $content->SetContentBoxData($contentData[1]);
        
        $content->SetPagerItemCount($contentData[0]);
        $content->EnableMultiSelect();
        $content->EnableSelect();
        
        return $content->toObject();
    }
    
    //Template pubblicate
    public function TemplateSection_Pubblicate($params=null)
    {
        $is_admin=false;

        if($this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN) || $this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22))
        {
            $is_admin=true;
        }
        
        //$content_box=$this->TemplateSectionPubblicate_List($_REQUEST);
                
        $content=new AA_GenericPagedSectionTemplate(static::AA_UI_PREFIX."_Pubblicate",$this->GetId());
        $content->EnablePager();
        $content->EnablePaging();
        $content->SetPagerItemForPage(10);
        $content->EnableFiltering();
        $content->SetFilterDlgTask("GetPubblicateFilterDlg");
        $content->ViewExportFunctions();
        
        $content->SetSectionName("Schede pubblicate");
        
        //Imposta una dimensione fissa per il contenuto
        //$content->SetContentItemHeight(110);
        
        $content->ViewDetail();
        
        if($is_admin)
        {
            $content->ViewReassign();
            $content->SetReassignHandlerParams(array("task"=>"GetOrganismoReassignDlg"));
            
            if($_REQUEST['cestinate']==0)
            {
                $content->ViewTrash();
                $content->SetTrashHandlerParams(array("task"=>"GetOrganismoTrashDlg"));
            }
            else 
            {
                $content->SetSectionName("Schede pubblicate cestinate");
                $content->HideReassign();
                $content->ViewResume();
                $content->SetResumeHandlerParams(array("task"=>"GetOrganismoResumeDlg"));
                $content->ViewDelete();
                $content->SetDeleteHandlerParams(array("task"=>"GetOrganismoDeleteDlg"));
            }            
        }
                
        $_REQUEST['count']=10;
        
        $contentData=$this->GetDataSectionPubblicate_List($_REQUEST);
        $content->SetContentBoxData($contentData[1]);
        
        $content->SetPagerItemCount($contentData[0]);
        $content->EnableMultiSelect();
        $content->EnableSelect();
        
        return $content->toObject();
    }
    
    //Template scadenzario
    public function TemplateSection_Scadenzario()
    {
        $is_admin=false;

        if($this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN) || $this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22))
        {
            $is_admin=true;
        }
        
        //$content_box=$this->TemplateSectionPubblicate_List($_REQUEST);
                
        $content=new AA_GenericPagedSectionTemplate(static::AA_UI_PREFIX."_Scadenzario",$this->GetId());
        $content->EnablePager();
        $content->EnablePaging();
        $content->SetPagerItemForPage(10);
        $content->EnableFiltering();
        $content->SetFilterDlgTask("GetScadenzarioFilterDlg");
        $content->ViewExportFunctions();
        
        if($_REQUEST['data_scadenzario'] =="") $_REQUEST['data_scadenzario']=Date("Y-m-d");
        $data=new DateTime($_REQUEST['data_scadenzario']);
        
        $contentBoxTemplate="<div class='AA_DataView_ScadenzarioItem'><div style='min-width: 550px' class='AA_DataView_ItemContent'>"
            ."<div><span class='AA_Label AA_Label_Orange'>#pretitolo#</span></div>"
            . "<div><span class='AA_DataView_ItemTitle'>#denominazione#</span></div>"
            . "<div>#tags#</div>"
            . "<div><span class='AA_DataView_ItemSubTitle'>#sottotitolo#</span></div>"
            . "<div><span class='AA_Label AA_Label_LightBlue' title='Stato elemento'>#stato#</span>&nbsp;<span class='AA_DataView_ItemDetails'>#dettagli#</span></div>"
            . "</div><div style='width:100%' class='AA_DataView_ScadenzarioItemContent'>#nomine#</div></div>";
        $content->SetContentBoxTemplate($contentBoxTemplate);
        
        $content->SetSectionName("Agenda nomine al ".$data->format("Y-m-d"));
        
        $content->ViewDetail();
        
        $_REQUEST['count']=10;        
        
        $contentData=$this->GetDataSectionScadenzario_List($_REQUEST);
        $content->SetContentBoxData($contentData[1]);
        
        $content->SetPagerItemCount($contentData[0]);
        $content->EnableMultiSelect();
        $content->EnableSelect();
        
        return $content->toObject();
    }
    
    public function GetDataSectionPubblicate_List($params=array())
    {
        $templateData=array();
        
        $parametri=array("status"=>AA_Const::AA_STATUS_PUBBLICATA);
        if($params['cestinate'] == 1) $parametri['status']=AA_Const::AA_STATUS_PUBBLICATA+AA_Const::AA_STATUS_CESTINATA;
        if($params['page']) $parametri['from']=($params['page']-1)*$params['count'];
        if($params['denominazione']) $parametri['denominazione']=$params['denominazione'];
        if($params['tipo']) $parametri['tipo']=$params['tipo'];
        if($params['dal']) $parametri['dal']=$params['dal'];
        if($params['al']) $parametri['al']=$params['al'];
        if($params['id_assessorato']) $parametri['id_assessorato']=$params['id_assessorato'];
        if($params['id_direzione']) $parametri['id_direzione']=$params['id_direzione'];
        if($params['incaricato']) $parametri['incaricato']=$params['incaricato'];
        if($params['tipo_nomina']) $parametri['tipo_nomina']=$params['tipo_nomina'];
        if($params['stato_organismo']) $parametri['stato_organismo']=$params['stato_organismo'];
        if($params['over65']) $parametri['over65']=$params['over65'];
        if($params['partecipazione']) $parametri['partecipazione']=$params['partecipazione'];
        
        $organismi=AA_Organismi::Search($parametri,false,$this->oUser);
        $now=date("Y-m-d");
        foreach($organismi[1] as $id=>$object)
        {
            $userCaps=$object->GetUserCaps($this->oUser);
            $struct=$object->GetStruct();
            $struttura_gest=$struct->GetAssessorato();
            if($struct->GetDirezione() !="") $struttura_gest.=" -> ".$struct->GetDirezione();
            
            #Stato società-----------
            $soc_tags="";
            $stato_org="";
            if($object->GetTipologia(true)==AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA)
            {
                //forma giuridica
                $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$object->GetFormaSocietaria()."</span>";
                
                if($object->IsInHouse() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>in house</span>";
                if($object->IsInTUSP() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>TUSP</span>";
                if($object->IsInMercatiReg() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>Mercati reg.</span>";
                $partecipazione=$object->GetPartecipazione(true);
                if($partecipazione['percentuale'] != 0) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green' title='Società direttamente partecipata dalla RAS'>diretta</span>";
                if($partecipazione['percentuale'] == 0 || (isset($partecipazione['partecipazioni']) && sizeof($partecipazione['partecipazioni'])>0)) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green' title='Società non direttamente partecipata dalla RAS'>indiretta</span>";
                
                //stato società
                $stato=$object->GetStatoOrganismo(true);
                if($stato > AA_Organismi_Const::AA_ORGANISMI_STATO_SOCIETA_ATTIVO && $stato !=4) $stato_org.="&nbsp;<span style='font-weight: 100;font-size: .8em' class='AA_DataView_Tag AA_Label AA_Label_LightBlue'>".$object->GetStatoOrganismo()."</span>";
                if($stato == 4) $stato_org.="&nbsp;<span style='font-weight: 100; font-size: .8em' class='AA_DataView_Tag AA_Label AA_Label_LightRed'>".$object->GetStatoOrganismo()."</span>";
            }
            else
            {
                $data_fine=trim($object->GetDataFineImpegno());
                //Ente cessato
                if(strcmp($data_fine,$now) <= 0 && strcmp($data_fine,"0000-00-00") != 0) $stato_org.="&nbsp;<span &nbsp;<span style='font-weight: 100;font-size: .8em' class='AA_DataView_Tag AA_Label AA_Label_LightRed'>Cessata</span>";
            }
            #------------------------------------------
                           
            #Stato scheda
            if($object->GetStatus() & AA_Const::AA_STATUS_BOZZA) $status="bozza";
            if($object->GetStatus() & AA_Const::AA_STATUS_PUBBLICATA) $status="pubblicata";
            if($object->GetStatus() & AA_Const::AA_STATUS_REVISIONATA) $status.=" revisionata";
            if($object->GetStatus() & AA_Const::AA_STATUS_CESTINATA) $status.=" cestinata";
        
            #Dettagli
            if(($userCaps&AA_Const::AA_PERMS_PUBLISH) > 0 && $object->GetAggiornamento() != "")
            {
                //Aggiornamento
                $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$object->GetAggiornamento(true)."</span>&nbsp;";
                
                //utente e log
                $lastLog=$object->GetLog()->GetLastLog();
                if($lastLog['user']=="")
                {
                    $lastLog['user']=$object->GetUser()->GetUsername();
                }

                $details.="<span class='AA_Label AA_Label_LightBlue' title=\"Nome dell'utente che ha compiuto l'ultima azione - Fai click per visualizzare il log delle azioni\"><span class='mdi mdi-account' onClick=\"AA_MainApp.utils.callHandler('dlg',{task: 'GetLogDlg', 'params': {id: ".$object->GetId()."}},'".$this->GetId()."');\">".$lastLog['user']."</span>&nbsp;";
                
                //id
                $details.="</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$object->GetId()."</span>";

                //organigramma
                if($object->HasOrganigrammi())
                {
                    $details.="&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Per questo organismo è stato impostato almeno un&apos;organigramma'><span class='mdi mdi-file-tree'></span>";
                }
            } 
            else
            {
                if($object->GetAggiornamento() != "") $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$object->GetAggiornamento(true)."</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$object->GetId()."</span>";
            }
            
            if(($userCaps & AA_Const::AA_PERMS_WRITE) ==0) $details.="&nbsp;<span class='AA_Label AA_Label_LightBlue' title=\" L'utente corrente non può apportare modifiche all'organismo\"><span class='mdi mdi-pencil-off'></span>&nbsp; sola lettura</span>";
            
            $templateData[]=array(
                "id"=>$object->GetId(),
                "tags"=>$soc_tags,
                "aggiornamento"=>$object->GetAggiornamento(),
                "denominazione"=>$object->GetDenominazione().$stato_org,
                "pretitolo"=>"<span class='AA_Label AA_Label_Blue_Simo'>".$object->GetTipologia()."</span>",
                "sottotitolo"=>$struttura_gest,
                "stato"=>$status,
                "dettagli"=>$details,
                "module_id"=>$this->GetId()
            );
        }

        return array($organismi[0],$templateData);
    }
    
    //Scadenzario data
    public function GetDataSectionScadenzario_List($params=array())
    {
        $templateData=array();

        $parametri=array("status"=>AA_Const::AA_STATUS_PUBBLICATA);
        if($params['page']) $parametri['from']=($params['page']-1)*$params['count'];
        if($params['denominazione']) $parametri['denominazione']=$params['denominazione'];
        if($params['tipo']) $parametri['tipo']=$params['tipo'];
        if($params['incaricato']) $parametri['incaricato']=$params['incaricato'];
        if($params['dal']) $parametri['dal']=$params['dal'];
        if($params['al']) $parametri['al']=$params['al'];
        if($params['id_assessorato']) $parametri['id_assessorato']=$params['id_assessorato'];
        if($params['id_direzione']) $parametri['id_direzione']=$params['id_direzione'];
        if($params['tipo_nomina']) $parametri['tipo_nomina']=$params['tipo_nomina'];
        if($params['stato_organismo']) $parametri['stato_organismo']=$params['stato_organismo'];

        $parametri['in_scadenza']=$params['in_scadenza'];
        $parametri['in_corso']=$params['in_corso'];
        $parametri['scadute']=$params['scadute'];
        $parametri['recenti']=$params['recenti'];
        $parametri['data_scadenzario']=$params['data_scadenzario'];
        $parametri['finestra_temporale']=$params['finestra_temporale'];
        $parametri['raggruppamento']=$params['raggruppamento'];
        $parametri['archivio']=$params['archivio'];
        $parametri['cessati']=$params['cessati'];
        
        if($parametri['scadute'] == "") $parametri['scadute']="0";
        if($parametri['in_corso'] == "") $parametri['in_corso']="0";
        if($parametri['in_scadenza'] == "") $parametri['in_scadenza']="1";
        if($parametri['recenti'] == "") $parametri['recenti']="1";
        if($parametri['data_scadenzario'] == "") $parametri['data_scadenzario']=Date("Y-m-d");
        if($parametri['finestra_temporale'] == "") $parametri['finestra_temporale']="1";
        if($parametri['raggruppamento'] == "") $parametri['raggruppamento']="0";
        if($parametri['archivio'] == "") $parametri['archivio']="0";
        if($parametri['cessati'] == "") $parametri['cessati']="0";
        
        $meseProx=new DateTime($parametri['data_scadenzario']);
        $meseProx->modify("+".$parametri['finestra_temporale']." month");
        $mesePrec=new DateTime($parametri['data_scadenzario']);
        $mesePrec->modify("-".$parametri['finestra_temporale']." month");
        $data_scadenzario=new DateTime($parametri['data_scadenzario']);
        
        //Memorizza i parametri dello scadenzario
        $_SESSION['AA_Organismi_Scadenzario_Filter_Params']=serialize($parametri);

        $organismi=AA_Organismi::Search($parametri,false,$this->oUser);
        
        $now=date("Y-m-d");
        foreach($organismi[1] as $id=>$object)
        {
            $userCaps=$object->GetUserCaps($this->oUser);
            $struct=$object->GetStruct();
            $struttura_gest=$struct->GetAssessorato();
            if($struct->GetDirezione() !="") $struttura_gest=$struct->GetDirezione();
            
            #Stato-----------
            $soc_tags="";
            if($object->GetTipologia(true)==AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA)
            {
                //forma giuridica
                $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$object->GetFormaSocietaria()."</span>";
                
                if($object->IsInHouse() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>in house</span>";
                if($object->IsInTUSP() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>TUSP</span>";
                $partecipazione=$object->GetPartecipazione(true);
                if($partecipazione['percentuale'] != 0) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green' title='Società direttamente partecipata dalla RAS'>diretta</span>";
                if($partecipazione['percentuale'] == 0 || (isset($partecipazione['partecipazioni']) && sizeof($partecipazione['partecipazioni'])>0)) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green' title='Società non direttamente partecipata dalla RAS'>indiretta</span>";
               
                //stato società
                $stato=$object->GetStatoOrganismo(true);
                if($stato > AA_Organismi_Const::AA_ORGANISMI_STATO_SOCIETA_ATTIVO && $stato !=4) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_LightOrange'>".$object->GetStatoOrganismo()."</span>";
                if($stato == 4) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_LightRed'>".$object->GetStatoOrganismo()."</span>";
            }
            else
            {
                $data_fine=trim($object->GetDataFineImpegno());
                //Ente cessato
                if(strcmp($data_fine,$now) <= 0 && strcmp($data_fine,"0000-00-00") != 0) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_LightRed'>Cessata</span>";
            }
            #------------------------------------------
                           
            #Stato
            if($object->GetStatus() & AA_Const::AA_STATUS_BOZZA) $status="bozza";
            if($object->GetStatus() & AA_Const::AA_STATUS_PUBBLICATA) $status="pubblicata";
            if($object->GetStatus() & AA_Const::AA_STATUS_REVISIONATA) $status.=" revisionata";
            if($object->GetStatus() & AA_Const::AA_STATUS_CESTINATA) $status.=" cestinata";
        
           #Dettagli
           if(($userCaps&AA_Const::AA_PERMS_PUBLISH) > 0 && $object->GetAggiornamento() != "")
           {
               //Aggiornamento
               $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$object->GetAggiornamento(true)."</span>&nbsp;";
               
               //utente e log
               $lastLog=$object->GetLog()->GetLastLog();
               if($lastLog['user']=="") $lastLog['user']=$object->GetUser()->GetUsername();        
               $details.="<span class='AA_Label AA_Label_LightBlue' title=\"Nome dell'utente che ha compiuto l'ultima azione - Fai click per visualizzare il log delle azioni\"><span class='mdi mdi-account' onClick=\"AA_MainApp.utils.callHandler('dlg',{task: 'GetLogDlg', 'params': {id: ".$object->GetId()."}},'".$this->GetId()."');\">".$lastLog['user']."</span>&nbsp;";
               
               //id
               $details.="</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$object->GetId()."</span>";
           } 
           else
           {
               if($object->GetAggiornamento() != "") $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$object->GetAggiornamento(true)."</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$object->GetId()."</span>";
           }
            
            if(($userCaps & AA_Const::AA_PERMS_WRITE) == 0) $details.="&nbsp;<span class='AA_Label AA_Label_LightBlue' title=\" L'utente corrente non può apportare modifiche all'organismo\"><span class='mdi mdi-pencil-off'></span>&nbsp; sola lettura</span>";
            
            //Nomine
            $params_nomine=Array('nomina_altri'=>"0");
            
            //incaricato
            $params_nomine['incaricato']=$parametri['incaricato'];

            //Raggruppa per incarico
            $params_nomine['raggruppamento']=$parametri['raggruppamento'];

            //tipo incarico
            $params_nomine['tipo_nomina']=$parametri['tipo_nomina'];

            //incarichi archiviati
            $params_nomine['archivio']=$parametri['archivio'];

            //incaricato
            $params_nomine['incaricato']=$parametri['incaricato'];

            //Imposta i limiti temporali
            if($parametri['in_scadenza'] != "1" || $parametri['in_corso'] != "1" || $parametri['scadute'] != "1" || $parametri['recenti'] != "1")
            {
                //limite superiore
                if($parametri['scadute'] == "1") $params_nomine['scadenzario_al']=$mesePrec->format("Y-m-d");
                if($parametri['recenti'] == "1") $params_nomine['scadenzario_al']=$parametri['data_scadenzario'];
                if($parametri['in_scadenza'] == "1") $params_nomine['scadenzario_al']=$meseProx->format("Y-m-d");
                if($parametri['in_corso'] == "1") $params_nomine['scadenzario_al']="";

                //limite inferiore
                if($parametri['in_corso'] == "1") $params_nomine['scadenzario_dal']=$meseProx->format("Y-m-d");
                if($parametri['in_scadenza'] == "1") $params_nomine['scadenzario_dal']=$parametri['data_scadenzario'];
                if($parametri['recenti'] == "1") $params_nomine['scadenzario_dal']=$mesePrec->format("Y-m-d");
                if($parametri['scadute'] == "1") $params_nomine['scadenzario_dal']="";
            }
            
            $nomine=$object->GetNomineScadenzario($params_nomine);
            $nomine_list=array();
            
            foreach($nomine as $nomina)
            {
                foreach($nomina as $curNomina)
                {
                    $datafine=new DateTime($curNomina->GetDataFine());
                    $datainizio=new DateTime($curNomina->GetDataInizio());

                    $view=false;
                    if($parametri['in_corso']=="1" && $datafine > $meseProx)
                    {
                        $view=true;
                        $label_class="AA_Label_LightGreen";
                        $label_scadenza="Cessa il: ";
                    }
                        
                    if($parametri['in_scadenza']=="1" && $datafine >= $data_scadenzario && $datafine <= $meseProx)
                    {
                        $view=true;
                        $label_class="AA_Label_LightYellow";
                        $label_scadenza="Cessa il: ";
                    }
                    
                    if($parametri['recenti']=="1" && $datafine >= $mesePrec && $datafine <= $data_scadenzario)
                    {
                        $view=true;
                        $label_class="AA_Label_LightOrange";
                        $label_scadenza="Cessata il: ";
                    }
                    
                    if($parametri['scadute']=="1" && $datafine < $mesePrec)
                    {
                        $view=true;
                        $label_class="AA_Label_LightRed";
                        $label_scadenza="Cessata il: ";
                    }

                    if($parametri['in_corso']=="1" && strpos($curNomina->GetDataFine(),"9999") !== false)
                    {
                        $view=true;
                        $label_class="AA_Label_LightGreen";
                        $label_scadenza="a tempo indeterminato";
                    }

                    //AA_Log::Log(__METHOD__." - data_fine: ".print_r($datafine,true)." - data_scadenzario: ".print_r($data_scadenzario,true)." - mese prox: ".print_r($meseProx,true)." - mese prec: ".print_r($mesePrec,true),100);
                    
                    //Calcolo età anagrafica
                    $eta_alert="";
                    if($view && $curNomina->IsOver65())
                    {
                            //$eta_alert='<span class="mdi mdi-alert">';
                    }

                    if($view)
                    {
                        $nomina_label=$eta_alert.$curNomina->GetNome()." ".$curNomina->GetCognome();
                        //if($curNomina->GetCodiceFiscale() !="") $nomina_label.=" <span style='font-size: smaller'>(".trim($curNomina->GetCodiceFiscale()).")</span>";
                        $nominaRas="";
                        if($curNomina->IsNominaRas()) $nominaRas="<div><span style='font-size: smaller'>nomina Ras</span></div>";
                        if(!$curNomina->IsFacenteFunzione()) $nomine_list[$curNomina->GetTipologia()][]="<div class='AA_Label ".$label_class."' style='margin-right: 1em; height: 90%; min-width:170px;display:flex; justify-content:space-between; align-items:center;flex-direction:column'><div style='font-weight: 900'>".$curNomina->GetTipologia()."</div><div>".$nomina_label."</div>".$nominaRas."<div style='text-align: center'><span style='font-size:smaller;'>".$label_scadenza."</span><br/><span style='font-size: smaller'>".$curNomina->GetDataFine()." (".$datafine->diff($data_scadenzario)->format("%a")." gg)</span></div></div>";
                        else $nomine_list[$curNomina->GetTipologia()][]="<div class='AA_Label AA_Label_LightYellow' style='margin-right: 1em;height: 90%;min-width:170px; display:flex; justify-content:space-between; align-items:center;flex-direction:column'><div style='font-weight: 900'>".$curNomina->GetTipologia()."</div><div>".$nomina_label."</div>".$nominaRas."<div> facente funzione dal:<br/><span style='font-size: smaller'>".$curNomina->GetDataInizio()." (".$data_scadenzario->diff($datainizio)->format("%a")." gg)</span></div></div>";
                    }
                }
                //$curNomina=current($nomina);
            }
            
            $result="";
            foreach($nomine_list as $x)
            {
                foreach($x as $y)
                {
                    $result.=$y;
                }
            }
            
            $templateData[]=array(
                "id"=>$object->GetId(),
                "tags"=>$soc_tags,
                "aggiornamento"=>$object->GetAggiornamento(),
                "denominazione"=>$object->GetDenominazione(),
                "pretitolo"=>$object->GetTipologia(),
                "sottotitolo"=>$struttura_gest,
                "stato"=>$status,
                "dettagli"=>$details,
                "module_id"=>$this->GetId(),
                "nomine"=>$result
            );
        }

        return array($organismi[0],$templateData);
    }
    
    //Restituisce i dati delle bozze
    public function GetDataSectionBozze_List($params=array())
    {
        $templateData=array();
        
        $parametri=array("status"=>AA_Const::AA_STATUS_BOZZA);
        if($params['cestinate'] == 1) $parametri['status']=AA_Const::AA_STATUS_BOZZA+AA_Const::AA_STATUS_CESTINATA;
        if($params['page']) $parametri['from']=($params['page']-1)*$params['count'];
        if($params['denominazione']) $parametri['denominazione']=$params['denominazione'];
        if($params['tipo']) $parametri['tipo']=$params['tipo'];
        if($params['dal']) $parametri['dal']=$params['dal'];
        if($params['al']) $parametri['al']=$params['al'];
        if($params['id_assessorato']) $parametri['id_assessorato']=$params['id_assessorato'];
        if($params['id_direzione']) $parametri['id_direzione']=$params['id_direzione'];
        if($params['incaricato']) $parametri['incaricato']=$params['incaricato'];
        if($params['tipo_nomina']) $parametri['tipo_nomina']=$params['tipo_nomina'];
        if($params['stato_organismo']) $parametri['stato_organismo']=$params['stato_organismo'];
        if($params['over65']) $parametri['over65']=$params['over65'];
        if($params['partecipazione']) $parametri['partecipazione']=$params['partecipazione'];

        $organismi=AA_Organismi::Search($parametri,false,$this->oUser);
        $now=date("Y-m-d");
        foreach($organismi[1] as $id=>$object)
        {
            $userCaps=$object->GetUserCaps($this->oUser);
            $struct=$object->GetStruct();
            $struttura_gest=$struct->GetAssessorato();
            if($struct->GetDirezione() !="") $struttura_gest.=" -> ".$struct->GetDirezione();
            
            #Stato società-----------
            $soc_tags="";
            $stato_org="";
            if($object->GetTipologia(true)==AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA)
            {
                //forma giuridica
                $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>".$object->GetFormaSocietaria()."</span>";
                
                if($object->IsInHouse() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>in house</span>";
                if($object->IsInTUSP() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>TUSP</span>";
                if($object->IsInMercatiReg() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>Mercati reg.</span>";
                $partecipazione=$object->GetPartecipazione(true);
                if($partecipazione['percentuale'] != 0) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green' title='Società direttamente partecipata dalla RAS'>diretta</span>";
                if($partecipazione['percentuale'] == 0 || (isset($partecipazione['partecipazioni']) && sizeof($partecipazione['partecipazioni'])>0)) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green' title='Società non direttamente partecipata dalla RAS'>indiretta</span>";
               
                //stato società
                $stato=$object->GetStatoOrganismo(true);
                if($stato > AA_Organismi_Const::AA_ORGANISMI_STATO_SOCIETA_ATTIVO && $stato !=4) $stato_org.="&nbsp;<span style='font-weight: 100;font-size: .8em' class='AA_DataView_Tag AA_Label AA_Label_LightBlue'>".$object->GetStatoOrganismo()."</span>";
                if($stato == 4) $stato_org.="&nbsp;<span style='font-weight: 100; font-size: .8em' class='AA_DataView_Tag AA_Label AA_Label_LightRed'>".$object->GetStatoOrganismo()."</span>";
            }
            else
            {
                $data_fine=trim($object->GetDataFineImpegno());
                //Ente cessato
                if(strcmp($data_fine,$now) <= 0 && strcmp($data_fine,"0000-00-00") != 0) $stato_org.="&nbsp;<span &nbsp;<span style='font-weight: 100;font-size: .8em' class='AA_DataView_Tag AA_Label AA_Label_LightRed'>Cessata</span>";
            }
            #------------------------------------------
          
            #Stato
            if($object->GetStatus() & AA_Const::AA_STATUS_BOZZA) $status="bozza";
            if($object->GetStatus() & AA_Const::AA_STATUS_PUBBLICATA) $status="pubblicata";
            if($object->GetStatus() & AA_Const::AA_STATUS_REVISIONATA) $status.=" revisionata";
            if($object->GetStatus() & AA_Const::AA_STATUS_CESTINATA) $status.=" cestinata";
    
            #Dettagli
            if(($userCaps&AA_Const::AA_PERMS_PUBLISH) > 0 && $object->GetAggiornamento() != "")
            {
                //Aggiornamento
                $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$object->GetAggiornamento(true)."</span>&nbsp;";
                
                //utente e log
                $lastLog=$object->GetLog()->GetLastLog();
                if($lastLog['user']=="") $lastLog['user']=$object->GetUser()->GetUsername();
                $details.="<span class='AA_Label AA_Label_LightBlue' title=\"Nome dell'utente che ha compiuto l'ultima azione - Fai click per visualizzare il log delle azioni\"><span class='mdi mdi-account' onClick=\"AA_MainApp.utils.callHandler('dlg',{task: 'GetLogDlg', 'params': {id: ".$object->GetId()."}},'".$this->GetId()."');\">".$lastLog['user']."</span>&nbsp;";
                
                //id
                $details.="</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$object->GetId()."</span>";

                //organigramma
                if($object->HasOrganigrammi())
                {
                    $details.="&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Per questo organismo è stato impostato almeno un&apos;organigramma'><span class='mdi mdi-file-tree'></span>";
                }
            } 
            else
            {
                if($object->GetAggiornamento() != "") $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$object->GetAggiornamento(true)."</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$object->GetId()."</span>";
            }

            if(($userCaps & AA_Const::AA_PERMS_WRITE) ==0) $details.="&nbsp;<span class='AA_Label AA_Label_LightBlue' title=\" L'utente corrente non può apportare modifiche all'organismo\"><span class='mdi mdi-pencil-off'></span>&nbsp; sola lettura</span>";
            
            $templateData[]=array(
                "id"=>$object->GetId(),
                "tags"=>$soc_tags,
                "aggiornamento"=>$object->GetAggiornamento(),
                "denominazione"=>$object->GetDenominazione().$stato_org,
                "pretitolo"=>"<span class='AA_Label AA_Label_Blue_Simo'>".$object->GetTipologia()."</span>",
                "sottotitolo"=>$struttura_gest,
                "stato"=>$status,
                "dettagli"=>$details,
                "module_id"=>$this->GetId()
            );
        }

        return array($organismi[0],$templateData);
    }
    
    //Template Revisionate
    public function TemplateSection_Revisionate()
    {
        
        $content = new AA_JSON_Template_Template(static::AA_UI_PREFIX."_Revisionate_Content",
                array(
                "type"=>"clean",
                "template"=>"revisionate"
            ));
         
        return $content;
    }
    
    //Template organismo trash dlg
    public function Template_GetOrganismoTrashDlg($params)
    {
        //lista organismi da cestinare
        if($params['ids'])
        {
            $ids= json_decode($params['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_DELETE)>0)
                {
                    $ids_final[$curId]=$organismo->GetDenominazione();
                    unset($organismo);
                }
            }

            $id=$this->id."_TrashDlg";

            //Esiste almeno un organismo che può essere cestinato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $forms_data['ids']=json_encode(array_keys($ids_final));
                $wnd=new AA_GenericFormDlg($id, "Cestina", $this->id, $forms_data,$forms_data);
               
                //Disattiva il pulsante di reset
                $wnd->EnableResetButton(false);

                //Imposta il nome del pulsante di conferma
                $wnd->SetApplyButtonName("Procedi");

                $tabledata=array();
                foreach($ids_final as $id_org=>$desc)
                {
                    $tabledata[]=array("Denominazione"=>$desc);
                }

                if(sizeof($ids_final) > 1) $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"I seguenti ".sizeof($ids_final)." organismi verranno cestinati, vuoi procedere?")));
                else $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente organismo verrà cestinato, vuoi procedere?")));

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
                $wnd->SetSaveTask('TrashOrganismi');
            }
            else
            {
                $wnd=new AA_GenericWindowTemplate($id, "Avviso",$this->id);
                $wnd->AddView(new AA_JSON_Template_Template("",array("css"=>array("text-align"=>"center"),"template"=>"<p>L'utente corrente non ha i permessi per cestinare gli organismi selezionati.</p>")));
                $wnd->SetWidth(380);
                $wnd->SetHeight(115);
            }
            
            return $wnd;
        }
    }
    
    //Template organismo publish dlg
    public function Template_GetOrganismoPublishDlg($params)
    {
        //lista organismi da ripristinare
        if($params['ids'])
        {
            $ids= json_decode($params['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_PUBLISH)>0)
                {
                    $ids_final[$curId]=$organismo->GetDenominazione();
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

                if(sizeof($ids_final) > 1) $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"I seguenti ".sizeof($ids_final)." organismi verranno pubblicato, vuoi procedere?")));
                else $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente organismo verrà pubblicato, vuoi procedere?")));

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
                $wnd->SetSaveTask('PublishOrganismo');
            }
            else
            {
                $wnd=new AA_GenericWindowTemplate($id, "Avviso",$this->id);
                $wnd->AddView(new AA_JSON_Template_Template("",array("css"=>array("text-align"=>"center"),"template"=>"<p>L'utente corrente non ha i permessi per pubblicare gli organismi selezionati.</p>")));
                $wnd->SetWidth(380);
                $wnd->SetHeight(115);
            }
            
            return $wnd;
        }
    }
    
    //Template organismo resume dlg
    public function Template_GetOrganismoResumeDlg($params)
    {
        //lista organismi da ripristinare
        if($params['ids'])
        {
            $ids= json_decode($params['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_WRITE)>0)
                {
                    $ids_final[$curId]=$organismo->GetDenominazione();
                    unset($organismo);
                }
            }

            $id=$this->id."_ResumeDlg";

            //Esiste almeno un organismo che può essere ripristinato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $forms_data['ids']=json_encode(array_keys($ids_final));
                
                $wnd=new AA_GenericFormDlg($id, "Ripristina", $this->id, $forms_data,$forms_data);
               
                //Disattiva il pulsante di reset
                $wnd->EnableResetButton(false);

                //Imposta il nome del pulsante di conferma
                $wnd->SetApplyButtonName("Procedi");

                $tabledata=array();
                foreach($ids_final as $id_org=>$desc)
                {
                    $tabledata[]=array("Denominazione"=>$desc);
                }

                if(sizeof($ids_final) > 1) $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"I seguenti ".sizeof($ids_final)." organismi verranno ripristinati, vuoi procedere?")));
                else $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente organismo verrà ripristinato, vuoi procedere?")));

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
                $wnd->SetSaveTask('ResumeOrganismi');
            }
            else
            {
                $wnd=new AA_GenericWindowTemplate($id, "Avviso",$this->id);
                $wnd->AddView(new AA_JSON_Template_Template("",array("css"=>array("text-align"=>"center"),"template"=>"<p>L'utente corrente non ha i permessi per ripristinare gli organismi selezionati.</p>")));
                $wnd->SetWidth(380);
                $wnd->SetHeight(115);
            }
            
            return $wnd;
        }
    }
    
    //Template organismo reassign dlg
    public function Template_GetOrganismoReassignDlg($params)
    {
        //lista organismi da ripristinare
        if($params['ids'])
        {
            $ids= json_decode($params['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_WRITE)>0)
                {
                    $ids_final[$curId]=$organismo->GetDenominazione();
                    unset($organismo);
                }
            }

            $id=$this->id."_ReassignDlg";

            //Esiste almeno un organismo che può essere ripristinato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $forms_data['ids']=json_encode(array_keys($ids_final));
                $struct=$this->oUser->GetStruct();
                $forms_data['id_assessorato']=$struct->GetAssessorato(true);
                $forms_data['id_direzione']=$struct->GetDirezione(true);
                $forms_data['id_servizio']=0;
                if($forms_data['id_direzione'] > 0) $forms_data['struct_desc']=$struct->GetDirezione();
                else $forms_data['struct_desc']=$struct->GetAssessorato();
                
                $wnd=new AA_GenericFormDlg($id, "Riassegna", $this->id, $forms_data,$forms_data);
                
                //Aggiunge il campo per la struttura di riassegnazione
                $wnd->AddStructField(array("hideServices"=>1,"targetForm"=>$wnd->GetFormId()),array("select"=>true, "bottomLabel"=>"*Seleziona la struttura di riassegnazione."));
            
                //Disattiva il pulsante di reset
                $wnd->EnableResetButton(false);

                //Imposta il nome del pulsante di conferma
                $wnd->SetApplyButtonName("Procedi");

                $tabledata=array();
                foreach($ids_final as $id_org=>$desc)
                {
                    $tabledata[]=array("Denominazione"=>$desc);
                }
                
                if(sizeof($ids_final) > 1) $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"I seguenti ".sizeof($ids_final)." organismi verranno riassegnati, vuoi procedere?")));
                else $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente organismo verrà riassegnato, vuoi procedere?")));

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
                $wnd->SetSaveTask('ReassignOrganismi');
            }
            else
            {
                $wnd=new AA_GenericWindowTemplate($id, "Avviso",$this->id);
                $wnd->AddView(new AA_JSON_Template_Template("",array("css"=>array("text-align"=>"center"),"template"=>"<p>L'utente corrente non ha i permessi per ripristinare gli organismi selezionati.</p>")));
                $wnd->SetWidth(380);
                $wnd->SetHeight(115);
            }
            
            return $wnd;
        }
    }
    
    //Template organismo delete dlg
    public function Template_GetOrganismoDeleteDlg($params)
    {
        //lista organismi da eliminare
        if($params['ids'])
        {
            $ids= json_decode($params['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_DELETE)>0)
                {
                    $ids_final[$curId]=$organismo->GetDenominazione();
                    unset($organismo);
                }
            }

            $id=$this->id."_DeleteDlg";

            //Esiste almeno un organismo che può essere eliminato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $forms_data['ids']=json_encode(array_keys($ids_final));
                $wnd=new AA_GenericFormDlg($id, "Elimina...", $this->id, $forms_data,$forms_data);

                //Disattiva il pulsante di reset
                $wnd->EnableResetButton(false);

                //Imposta il nome del pulsante di conferma
                $wnd->SetApplyButtonName("Procedi");

                $tabledata=array();
                foreach($ids_final as $id_org=>$desc)
                {
                    $tabledata[]=array("Denominazione"=>$desc);
                }

                if(sizeof($ids_final) > 1) $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"I seguenti ".sizeof($ids_final)." organismi verranno <span style='text-decoration:underline'>eliminati definitivamente</span>, vuoi procedere?")));
                else $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente organismo verrà <span style='text-decoration:underline'>eliminato definitivamente</span>, vuoi procedere?")));

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
                $wnd->SetSaveTask('DeleteOrganismi');
            }
            else
            {
                $wnd=new AA_GenericWindowTemplate($id, "Avviso",$this->id);
                $wnd->AddView(new AA_JSON_Template_Template("",array("css"=>array("text-align"=>"center"),"template"=>"<p>L'utente corrente non ha i permessi per eliminare gli organismi selezionati.</p>")));
                $wnd->SetWidth(380);
                $wnd->SetHeight(115);
            }
            
            return $wnd;
        }
    }
    
    //Template dlg trash bilancio
    public function Template_GetOrganismoTrashBilancioDlg($object=null,$dato_contabile=null,$bilancio=null)
    {
        $id=$this->id."_TrashBilancio_Dlg";
        
        $form_data['id_bilancio']=$bilancio->GetId();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina bilancio", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(480);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $tabledata[]=array("Tipo"=>$bilancio->GetTipo(),"Risultati"=>$bilancio->GetRisultati(),"Note"=>$bilancio->GetNote());
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente bilancio verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "autoConfig"=>true,
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("TrashOrganismoBilancio");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_dato_contabile"=>$dato_contabile->GetId()));
        
        return $wnd;
    }
    
    //Template dlg trash incarico
    public function Template_GetOrganismoTrashProvvedimentoDlg($object=null,$provvedimento=null)
    {
        $id=$this->id."_TrashProvvedimento_Dlg";
        
        $form_data['id_provvedimento']=$provvedimento->GetId();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina provvedimento", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $url=$provvedimento->GetUrl();
        if($url =="") $url="file locale";
        $tabledata[]=array("Tipo"=>$provvedimento->GetTipologia(),"url"=>$url,"anno"=>$provvedimento->GetAnno());
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente provvedimento verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "columns"=>array(
              array("id"=>"Tipo", "header"=>"Anno", "width"=>15),
              array("id"=>"Tipo", "header"=>"Tipo", "fillspace"=>true),
              array("id"=>"url", "header"=>"Url", "fillspace"=>true)
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("TrashOrganismoProvvedimento");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_provvedimento"=>$provvedimento->GetId()));
        
        return $wnd;
    }
    
    //Template dlg trash bilancio
    public function Template_GetOrganismoTrashIncaricoDlg($object=null,$incarico=null)
    {
        $id=$this->id."_TrashIncarico_Dlg";
        
        $form_data['id_incarico']=$incarico->GetId();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina incarico di ".$incarico->GetNome()." ".$incarico->GetCognome()." (".$incarico->GetCodiceFiscale().")", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $tabledata[]=array("Tipo"=>$incarico->GetTipologia(),"Data inizio"=>$incarico->GetDataInizio(),"Data Fine"=>$incarico->GetDataFine(),"Note"=>$incarico->GetNote());
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente incarico verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "autoConfig"=>true,
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->enableRefreshSectionOnSuccessfulSave();

        $wnd->SetSaveTask("TrashOrganismoIncarico");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_incarico"=>$incarico->GetId()));
        
        return $wnd;
    }

    //Template dlg trash organigramma
    public function Template_GetOrganismoDeleteOrganigrammaDlg($object=null,$organigramma=null)
    {
        $id=$this->id."_TrashOrganigramma_Dlg";
        
        $form_data['id_organigramma']=$organigramma->GetId();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina organigramma", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $tabledata[]=array("Id"=>$organigramma->GetId(), "Tipo"=>$organigramma->GetTipologia(),"Note"=>$organigramma->GetProp("note"));
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente organigramma verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "columns"=>array(
                array("id"=>"Id", "header"=>"id", "width"=>15),
                array("id"=>"Tipo", "header"=>"Tipo", "fillspace"=>true),
                array("id"=>"Note", "header"=>"Note", "fillspace"=>true)
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("DeleteOrganismoOrganigramma");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_organigramma"=>$organigramma->GetId()));
        
        return $wnd;
    }

    //Template dlg trash organigramma
    public function Template_GetOrganismoDeleteOrganigrammaIncaricoDlg($object=null,$organigramma=null,$incarico=null)
    {
        $id=$this->id."_DeleteOrganigrammaIncarico_Dlg";
        
        $form_data=array();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina incarico", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $ras="No";
        if($incarico->IsNominaRas()) $ras="Si";
        $opzionale="No";
        if($incarico->IsOpzionale()) $opzionale="Si";
        $tabledata[]=array("Id"=>$incarico->GetId(), "Tipo"=>$incarico->GetTipologia(),"Note"=>$incarico->GetProp("note"),"opzionale"=>$opzionale,"ras"=>$ras);
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente incarico verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "columns"=>array(
                array("id"=>"Id", "header"=>"id", "width"=>15),
                array("id"=>"Tipo", "header"=>"Tipo", "fillspace"=>true),
                array("id"=>"ras", "header"=>"Ras", "width"=>90),
                array("id"=>"opzionale", "header"=>"Opzionale", "width"=>90),
                array("id"=>"Note", "header"=>"Note", "fillspace"=>true)
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("DeleteOrganismoOrganigrammaIncarico");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_organigramma"=>$organigramma->GetId(),"id_incarico"=>$incarico->GetId()));
        
        return $wnd;
    }
    
    //Template dlg trash documento incarico
    public function Template_GetOrganismoTrashIncaricoDocDlg($object=null,$incarico=null,$doc=null)
    {
        $id=$this->id."_TrashIncaricoDoc_Dlg";
        
        $form_data['anno']=$doc->GetAnno();
        $form_data['tipo']=$doc->GetTipologia(true);
        $form_data['serial']=$doc->GetSerial();
                
        $wnd=new AA_GenericFormDlg($id, "Elimina documento di ".$incarico->GetNome()." ".$incarico->GetCognome()." (".$incarico->GetCodiceFiscale().")", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $tabledata[]=array("Anno"=>$doc->GetAnno(), "Tipo"=>$doc->GetTipologia(), "incarico"=>$incarico->GetTipologia());
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente documento verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            //"autoConfig"=>true,
            "columns"=>array(
              array("id"=>"incarico", "header"=>"Incarico", "fillspace"=>true),
              array("id"=>"Anno", "header"=>"Anno"),  
              array("id"=>"Tipo", "header"=>"Tipo", "fillspace"=>true)
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->SetSaveTask("TrashOrganismoIncaricoDoc");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_incarico"=>$incarico->GetId()));
        
        return $wnd;
    }
    
    //Template dlg trash documento incarico
    public function Template_GetOrganismoTrashIncaricoCompensoDlg($object=null,$incarico=null,$compenso=null)
    {
        $id=$this->id."_TrashIncaricoDoc_Dlg";
        
        $form_data['anno']=$compenso->GetAnno();
         
        $wnd=new AA_GenericFormDlg($id, "Elimina il compenso di ".$incarico->GetNome()." ".$incarico->GetCognome()." (".$incarico->GetCodiceFiscale().")", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $tabledata[]=array("anno"=>$compenso->GetAnno(), "parte_fissa"=>$compenso->GetParteFissa(), "parte_variabile"=>$compenso->GetParteVariabile(),"rimborsi"=>$compenso->GetRimborsi(), "note"=>$compenso->GetNote());
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente compenso, per l'incarico di ".$incarico->GetTipologia()." , verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            //"autoConfig"=>true,
            "columns"=>array(
              array("id"=>"anno", "header"=>"Anno"),
              array("id"=>"parte_fissa", "header"=>"Parte fissa", "fillspace"=>true),
              array("id"=>"parte_variabile", "header"=>"Parte variabile", "fillspace"=>true),
              array("id"=>"rimborsi", "header"=>"Rimborsi", "fillspace"=>true),
              array("id"=>"note", "header"=>"Note", "fillspace"=>true),
            ),
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->SetSaveTask("TrashOrganismoIncaricoCompenso");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_incarico"=>$incarico->GetId(),"id_compenso"=>$compenso->GetId()));
        
        return $wnd;
    }
    
    //Template dlg aggiungi nuovo incarico all'organigramma
    public function Template_GetOrganismoAddNewOrganigrammaIncaricoDlg($object=null,$organigramma=null)
    {
        $id=$this->id."_AddNewOrganigrammaIncarico_Dlg";

        $form_data=array("tipo"=>0,"compenso_spettante"=>0,"ordine"=>0);
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi incarico per l'organigramma ".$organigramma->GetTipologia(), $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(580);
        
        //tipo
        $options=array();

        foreach(AA_Organismi_Const::GetTipoNomine() as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key, "value"=>$val);
        }
        $wnd->AddSelectField("tipo","Tipologia",array("required"=>true,"validateFunction"=>"IsSelected","bottomLabel"=>"*Indicare la tipologia di incarico.", "placeholder"=>"Scegli il tipo di incarico...","options"=>$options));
        
        //nomina ras
        $wnd->AddSwitchBoxField("ras","RAS",array("onLabel"=>"si","offLabel"=>"no","bottomLabel"=>"*Indica se l'incarico è di nomina/designazione/indicazione da parte della RAS."));
        
        //opzionale
        $wnd->AddSwitchBoxField("opzionale","Opzionale",array("onLabel"=>"si","offLabel"=>"no","bottomLabel"=>"*Indica se l'incarico è opzionale."));

        //forza scadenzario
        $wnd->AddSwitchBoxField("forza_scadenzario","Scadenzario",array("onLabel"=>"si","offLabel"=>"no","bottomLabel"=>"*Indica se l'incarico deve essere considerato ai fini dell'elaborazione dello scadenzario anche se non si tratta di nomina/designazione/indicazione da parte della RAS."));

        //compenso spettante
        $wnd->AddTextField("compenso_spettante","Compenso spettante",array("required"=>"true","validateFunction"=>"IsPositive","placeholder"=>"inserisci qui il compenso spettante.","bottomLabel"=>"*Indicare il compenso spettante oppure il valore '0'(zero) se il dato non è disponibile."));

        //note
        $wnd->AddTextareaField("note","Note",array("placeholder"=>"inserisci qui la note."));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_organigramma"=>$organigramma->GetId()));
        $wnd->SetSaveTask("AddNewOrganismoOrganigrammaIncarico");
        $wnd->EnableApplyHotkey(false);
        
        return $wnd;
    }

    //Template dlg modifica l'incarico all'organigramma
    public function Template_GetOrganismoModifyOrganigrammaIncaricoDlg($object=null,$organigramma=null,$incarico=null)
    {
        $id=$this->id."_ModifyOrganigrammaIncarico_Dlg";

        $form_data=array("compenso_spettante"=>$incarico->GetProp("compenso_spettante"),"forza_scadenzario"=>$incarico->GetProp("forza_scadenzario"),"tipo"=>$incarico->GetProp("tipo"),"ras"=>$incarico->GetProp("ras"),"opzionale"=>$incarico->GetProp("opzionale"),"note"=>$incarico->GetProp("note"));

        $wnd=new AA_GenericFormDlg($id, "Modifica incarico ", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(580);
        
        //tipo
        $options=array();

        foreach(AA_Organismi_Const::GetTipoNomine() as $key=>$val)
        {
            if($key > 0) $options[]=array("id"=>$key, "value"=>$val);
        }
        $wnd->AddSelectField("tipo","Tipologia",array("required"=>true,"validateFunction"=>"IsSelected","bottomLabel"=>"*Indicare la tipologia di incarico.", "placeholder"=>"Scegli il tipo di incarico...","options"=>$options));
        
        //nomina ras
        $wnd->AddSwitchBoxField("ras","RAS",array("onLabel"=>"si","offLabel"=>"no","bottomLabel"=>"*Indica se l'incarico è di nomina/designazione/indicazione da parte della RAS."));
        
        //opzionale
        $wnd->AddSwitchBoxField("opzionale","Opzionale",array("onLabel"=>"si","offLabel"=>"no","bottomLabel"=>"*Indica se l'incarico è opzionale."));

        //forza scadenzario
        $wnd->AddSwitchBoxField("forza_scadenzario","Scadenzario",array("onLabel"=>"si","offLabel"=>"no","bottomLabel"=>"*Indica se l'incarico deve essere considerato ai fini dell'elaborazione dello scadenzario anche se non si tratta di nomina/designazione/indicazione da parte della RAS."));

        //compenso spettante
        $wnd->AddTextField("compenso_spettante","Compenso spettante",array("required"=>"true","validateFunction"=>"IsPositive","placeholder"=>"inserisci qui il compenso spettante.","bottomLabel"=>"*Indicare il compenso spettante oppure il valore '0'(zero) se il dato non è disponibile."));

        //note
        $wnd->AddTextareaField("note","Note",array("placeholder"=>"inserisci qui la note."));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_organigramma"=>$organigramma->GetId(),"id_incarico"=>$incarico->GetProp("id")));
        $wnd->SetSaveTask("UpdateOrganismoOrganigrammaIncarico");
        $wnd->EnableApplyHotkey(false);
        
        return $wnd;
    }

    //Template dlg aggiungi nuovo compenso incarico
    public function Template_GetOrganismoAddNewIncaricoCompensoDlg($object=null,$incarico=null)
    {
        $id=$this->id."_AddNewIncaricoCompenso_Dlg";

        $form_data['anno']=Date("Y");
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi compenso per l'incarico di ".$incarico->GetTipologia(), $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(520);
        
        //anno
        $options=array();
        $anno_fine=Date('Y');
        $anno_start=($anno_fine-5);
        
        for($i=$anno_fine; $i>=$anno_start; $i--)
        {
            $options[]=array("id"=>$i, "value"=>$i);
        }
        $wnd->AddSelectField("anno","Anno",array("required"=>true,"validateFunction"=>"IsSelected","bottomLabel"=>"*Indicare l'anno di riferimento.", "placeholder"=>"Scegli l'anno di riferimento.","options"=>$options,"value"=>Date('Y')));        
        
        //parte fissa
        $wnd->AddTextField("parte_fissa","Parte fissa",array("validateFunction"=>"IsNumber", "bottomLabel"=>"*Indicare l'importo lordo della parte fissa del trattamento economico.", "placeholder"=>"inserisci qui la parte fissa del compenso."));
        
        //parte variabile
        $wnd->AddTextField("parte_variabile","Parte variabile",array("validateFunction"=>"IsNumber","bottomLabel"=>"*Indicare l'importo lordo dell'indennità di risultato e/o il dato cumulativo dei gettoni di presenza.", "placeholder"=>"inserisci qui la parte variabile del compenso."));

        //rimborsi
        $wnd->AddTextField("rimborsi","Rimborsi",array("validateFunction"=>"IsNumber","bottomLabel"=>"*Indicare l'importo lordo dei rimborsi.", "placeholder"=>"inserisci qui i rimborsi."));
        
        //note
        $wnd->AddTextareaField("note","Note",array("placeholder"=>"inserisci qui la note."));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_incarico"=>$incarico->GetId()));
        $wnd->SetSaveTask("AddNewOrganismoIncaricoCompenso");
        
        return $wnd;
    }
    
    //Template dlg modifica compenso incarico
    public function Template_GetOrganismoModifyIncaricoCompensoDlg($object=null,$incarico=null,$compenso=null)
    {
        $id=$this->id."_CompensoIncaricoCompenso_Dlg";

        $form_data['anno']=$compenso->GetAnno();
        $form_data['parte_fissa']=$compenso->GetParteFissa();
        $form_data['parte_variabile']=$compenso->GetParteVariabile();
        $form_data['rimborsi']=$compenso->GetRimborsi();
        $form_data['note']=$compenso->GetNote();
        
        $wnd=new AA_GenericFormDlg($id, "Modifica compenso per l'incarico di ".$incarico->GetTipologia(), $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(100);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(520);
        
        //anno
        $options=array();
        $anno_fine=Date('Y');
        $anno_start=($anno_fine-5);
        
        for($i=$anno_fine; $i>=$anno_start; $i--)
        {
            $options[]=array("id"=>$i, "value"=>$i);
        }
        $wnd->AddSelectField("anno","Anno",array("disabled"=>true,"required"=>true,"validateFunction"=>"IsPositive","bottomLabel"=>"*Dato non modificabile.", "placeholder"=>"Scegli l'anno di riferimento.","options"=>$options,"value"=>Date('Y')));
        
        //parte fissa
        $wnd->AddTextField("parte_fissa","Parte fissa",array("validateFunction"=>"IsNumber", "bottomLabel"=>"*Indicare l'importo lordo della parte fissa del trattamento economico.", "placeholder"=>"inserisci qui la parte fissa del compenso."));
        
        //parte variabile
        $wnd->AddTextField("parte_variabile","Parte variabile",array("validateFunction"=>"IsNumber","bottomLabel"=>"*Indicare l'importo lordo dell'indennità di risultato e/o il dato cumulativo dei gettoni di presenza.", "placeholder"=>"inserisci qui l'indennità di risultato e/o il dato cumulativo dei gettoni di presenza."));

        //rimborsi
        $wnd->AddTextField("rimborsi","Rimborsi",array("validateFunction"=>"IsNumber","bottomLabel"=>"*Indicare l'importo lordo dei rimborsi.", "placeholder"=>"inserisci qui i rimborsi."));
        
        //note
        $wnd->AddTextareaField("note","Note",array("placeholder"=>"inserisci qui la note."));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_incarico"=>$incarico->GetId(),"id_compenso"=>$compenso->GetId()));
        $wnd->SetSaveTask("UpdateOrganismoIncaricoCompenso");
        
        return $wnd;
    }
    
    //Template dlg trash bilancio
    public function Template_GetOrganismoTrashNominaDlg($object=null,$incarichi=array())
    {
        $id=$this->id."_TrashNomina_Dlg";
        $tabledata=array();
        $form_data['ids']=array();
        foreach( $incarichi as $incarico)
        {
            $form_data['ids'][]=$incarico->GetId();
            $tabledata[]=array("Tipo"=>$incarico->GetTipologia(),"Data inizio"=>$incarico->GetDataInizio(),"Data Fine"=>$incarico->GetDataFine(),"Note"=>$incarico->GetNote());
        }
        
        $params['nome']=$incarico->GetNome();
        $params['cognome']=$incarico->GetCognome();
        $params['cf']=$incarico->GetCodiceFiscale();
        
        $form_data['ids']="[".implode(",",$form_data['ids'])."]";
        
        $wnd=new AA_GenericFormDlg($id, "Elimina nomina ".$params['nome']." ".$params['cognome']." (".$params['cf'].")", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"I seguenti incarichi verranno eliminati, vuoi procedere?")));

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
        $wnd->SetSaveTask("TrashOrganismoNomina");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        
        return $wnd;
    }

    //Template dlg trash bilancio
    public function Template_GetSinesTrashPartecipazioneDlg($object=null,$idOrgPart=null)
    {
        $id=$this->id."_TrashPartecipazione_Dlg".uniqid();
        $tabledata=array();
        $form_data['id_org']=$idOrgPart;
        $partecipazione=$object->GetPartecipazione(true);
        $tabledata[]=array("Denominazione"=>$partecipazione['partecipazioni'][$idOrgPart]['denominazione']);

        $wnd=new AA_GenericFormDlg($id, "Rimuovi partecipazione", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(580);
        $wnd->SetHeight(320);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
      
        $wnd->AddGenericObject(new AA_JSON_Template_Template("",array("autoheight"=>true,"template"=>"<p>Il seguente organismo partecipante verra' rimosso dalle partecipazioni,<br><b>vuoi procedere?</b></p>")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "autoConfig"=>true,
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("TrashSinesPartecipazione");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        
        return $wnd;
    }
    
    //Template dlg trash dato contabile
    public function Template_GetOrganismoTrashDatoContabileDlg($object=null,$dato_contabile=null)
    {
        $id=$this->id."_TrashDatoContabile_Dlg";
        
        $form_data['id_dato_contabile']=$dato_contabile->GetId();
        
        $wnd=new AA_GenericFormDlg($id, "Elimina dato contabile", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        
        $wnd->SetWidth(480);
        $wnd->SetHeight(280);
        
        //Disattiva il pulsante di reset
        $wnd->EnableResetButton(false);

        //Imposta il nome del pulsante di conferma
        $wnd->SetApplyButtonName("Procedi");
                
        $tabledata=array();
        $tabledata[]=array("Descrizione"=>"Dati contabili e dotazione organica per l'anno ".$dato_contabile->GetAnno());
      
        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("view"=>"label","label"=>"Il seguente dato contabile verrà eliminato, vuoi procedere?")));

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "autoheight"=>true,
            "scrollX"=>false,
            "autoConfig"=>true,
            "select"=>false,
            "data"=>$tabledata
        ));

        $wnd->AddGenericObject($table);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("TrashOrganismoDatoContabile");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_dato_contabile"=>$dato_contabile->GetId()));
        
        return $wnd;
    }
        
    //Template dlg addnew organismo
    public function Template_GetOrganismoAddNewDlg()
    {
        $id=$this->id."_AddNew_Dlg";
        
        $form_data=array();
        
        //Struttura
        $struct=$this->oUser->GetStruct();
        $form_data['id_assessorato']=$struct->GetAssessorato(true);
        $form_data['id_direzione']=$struct->GetDirezione(true);
        $form_data['id_servizio']=0;
        if($form_data['id_direzione'] > 0) $form_data['struct_desc']=$struct->GetDirezione();
        else $form_data['struct_desc']=$struct->GetAssessorato();
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi un nuovo organismo", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        
        $wnd->SetWidth(600);
        $wnd->SetHeight(420);
        $wnd->EnableValidation();
                
        //Descrizione
        $wnd->AddTextField("sDescrizione","Denominazione",array("required"=>true, "bottomLabel"=>"*Inserisci la denominazione dell'organismo", "placeholder"=>"inserisci qui la denominazione dell'organismo"));
        
        //Tipologia
        $options=array();
        foreach(AA_Organismi_Const::GetTipoOrganismi() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("nTipologia","Tipologia",array("required"=>true,"options"=>$options,"bottomLabel"=>"*seleziona il tipo di organismo."));
        
        //Funzioni
        $label="Funzioni attrib.";
        $wnd->AddTextareaField("sFunzioni",$label,array("bottomLabel"=>"*Funzioni attribuite all'organismo.", "required"=>true,"placeHolder"=>"Inserisci qui le funzioni attribuite"));
        
        //Struttura
        $wnd->AddStructField(array("hideServices"=>1,"targetForm"=>$wnd->GetFormId()), array("select"=>true),array("bottomLabel"=>"*Seleziona la struttura controllante."));

        $wnd->EnableCloseWndOnSuccessfulSave();
        //$wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("AddNewOrganismo");
        
        return $wnd;
    }
    
    //Template dlg modify organismo
    public function Template_GetOrganismoModifyDlg($object=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoModifyDlg";
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Modifica i dati generali", $this->id);

        $form_data['id']=$object->GetID();
        foreach($object->GetBindings() as $id_obj=>$field)
        {
            $form_data[$id_obj]=$object->GetProp($id_obj);
        }

        $partecipazione=$object->GetPartecipazione(true);
        
        $form_data["Partecipazione_percentuale"]=AA_Utils::number_format($partecipazione['percentuale'],2,",",".");
        $form_data["Partecipazione_euro"]=AA_Utils::number_format($partecipazione['euro'],2,",",".");
        
        $wnd=new AA_GenericFormDlg($id, "Modifica i dati generali", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(1080);
        $wnd->SetHeight(800);
        
        //Denominazione
        $wnd->AddTextField("sDescrizione","Denominazione",array("required"=>true, "bottomLabel"=>"*Denominazione dell'organismo", "placeholder"=>"inserisci qui la denominazione dell'organismo"));
        
        if(($object->GetTipologia(true) & AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) >0)
        {
             //in Tusp
             $wnd->AddCheckBoxField("bMercatiReg","Mercati reg.",array("bottomLabel"=>"*Abilitare se la società e' quotata nei mercati regolamentati."), false);
        }

        //Tipologia
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoOrganismi() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        //$wnd->AddSelectField("nTipologia","Tipologia",array("required"=>true, "validateFunction"=>"IsPositive", "customInvalidMessage"=>"*Occorre selezionare la tipologia","options"=>$options,"value"=>"0", "hidden"=>true), false);
        
        if(($object->GetTipologia(true) & AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) >0)
        {
            //forma giuridica
            $options=array();
            foreach(AA_Organismi_Const::GetListaFormaGiuridica() as $id=>$label)
            {
                if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
            }
            $wnd->AddSelectField("nFormaSocietaria","Forma giuridica",array("required"=>true, "validateFunction"=>"IsPositive", "customInvalidMessage"=>"*Occorre selezionare la forma giuridica","bottomLabel"=>"*Selezionare la forma giuridica dalla lista.","options"=>$options,"value"=>"0"));
            
            //in house
            $wnd->AddCheckBoxField("bInHouse","In house",array("bottomLabel"=>"*Abilitare se la società è in house."), false);
            
            //Stato società
            $options=array();
            foreach(AA_Organismi_Const::GetListaStatoOrganismi() as $id=>$label)
            {
                if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
            }
            $wnd->AddSelectField("nStatoOrganismo","Stato",array("bottomLabel"=>"*Selezionare lo stato della società dalla lista.", "validateFunction"=>"IsPositive", "customInvalidMessage"=>"*Occorre selezionare lo stato della società.", "required"=>true,"options"=>$options,"value"=>"0"));
            
            //in Tusp
            $wnd->AddCheckBoxField("bInTUSP","TUSP",array("bottomLabel"=>"*Abilitare se la società rientra nell'allegato A del TUSP."), false);
        }
        
        //partita iva
        $wnd->AddTextField("sPivaCf","Codice fiscale",array("bottomLabel"=>"*Riportare il codice fiscale dell'organismo.", "placeholder"=>"inserisci qui il codice fiscale dell'organismo"));
        
        //data inizio
        $label="Data costituzione";
        if(($object->GetTipologia(true) & AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) >0) $label="Data inizio impegno";
        $wnd->AddDateField("sDataInizioImpegno",$label,array("bottomLabel"=>"*".$label." dell'organismo.", "stringResult"=>true, "format"=>"%Y-%m-%d", "editable"=>true), false);
        
        //sede
        $wnd->AddTextField("sSedeLegale","Sede legale",array("bottomLabel"=>"*Sede legale dell'organismo.", "placeholder"=>"inserisci qui l'indirizzo della sede legale dell'organismo"));
        
        //data fine
        $label="Data cessazione";
        if(($object->GetTipologia(true) & AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) >0) $label="Data fine impegno";
        $wnd->AddDateField("sDataFineImpegno",$label,array("bottomLabel"=>"*".$label." dell'organismo.", "stringResult"=>true, "format"=>"%Y-%m-%d", "editable"=>true), false);
        
        //pec
        $label="PEC";
        $wnd->AddTextField("sPec",$label,array("bottomLabel"=>"*".$label." dell'organismo.","placeholder"=>"Inserisci qui l'indirizzo pec"));
        
        //sito web
        $label="Sito web";
        $wnd->AddTextField("sSitoWeb",$label,array("bottomLabel"=>"*URL ".$label." dell'organismo.", "placeholder"=>"Inserisci qui l'url del sito web"), false);
        
        //Partecipazione
        if(($object->GetTipologia(true) & AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) >0)
        {
            $section=new AA_FieldSet("","Partecipazione diretta RAS");
            
            //partecipazione
            $field_notes="*Quota di partecipazione diretta RAS in percentuale.<br>Indicare 0 se la RAS non detiene direttamente delle quote di partecipazione.";
            $label="Quota %";
            $section->AddTextField("Partecipazione_percentuale",$label,array("bottomLabel"=>$field_notes, "required"=>true,"validateFunction"=>"IsNumber", "bottomPadding"=>48, "placeholder"=>"es. 10,05"));
            $label="Quota &euro;";
            $field_notes="*Quota di partecipazione diretta RAS in euro.<br>Indicare 0 se la RAS non detiene direttamente delle quote di partecipazione.";
            $section->AddTextField("Partecipazione_euro",$label,array("bottomLabel"=>$field_notes, "required"=>true,"validateFunction"=>"IsNumber", "bottomPadding"=>48, "placeholder"=>"es. 123456,78"),false);
            
            $wnd->AddGenericObject($section);
        }
        
        //Funzioni
        $label="Funzioni attribuite";
        $wnd->AddTextareaField("sFunzioni",$label,array("bottomLabel"=>"*".$label." all'organismo.", "required"=>true,"placeHolder"=>"Inserisci qui le funzioni attribuite"));
        
        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label,array("placeholder"=>"Riporta qui le eventuali note"));

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();

        $wnd->SetSaveTask("UpdateOrganismo");
        
        return $wnd;
    }
    
    //Template dlg modify organismo
    public function Template_GetOrganismoModifyDatoContabileDlg($object=null,$dato=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoModifyDatoContabileDlg";
        
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Modifica i dati contabili e la dotazione organica", $this->id);
        if(!($dato instanceof AA_OrganismiDatiContabili)) return new AA_GenericWindowTemplate($id, "Modifica i dati contabili e la dotazione organica", $this->id);

        foreach($dato->GetBindings() as $id_obj=>$field)
        {
            $form_data[$id_obj]=$dato->GetProp($id_obj);
        }
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $wnd=new AA_GenericFormDlg($id, "Modifica i dati contabili e la dotazione organica", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(1080);
        $wnd->SetHeight(700);
        
        //anno
        $wnd->AddTextField("nAnno","Anno",array("tooltip"=>"Anno di riferimento", "validateFunction"=>"IsNumber" ,"required"=>true,"bottomLabel"=>"*Inserire il valore numerico dell'anno a quattro cifre, es. 2021", "bottomPadding"=>30,"placeholder"=>"inserisci qui l'anno di riferimento"));

        //gap
        $wnd->AddCheckBoxField("Gap","GAP",array("tooltip"=>"Impostare se l'organismo fa parte del GAP per l'anno di riferimento", "bottomLabel"=>"*Impostare se l'organismo fa parte del GAP per l'anno di riferimento", "bottomPadding"=>30),false);

        //oneri totali
        $wnd->AddTextField("sOneriTotali","Oneri totali",array("validateFunction"=>"IsNumber", "tooltip"=>"Inserire solo valori numerici,<br>lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui gli oneri totali"));

        //gbc
        $wnd->AddCheckBoxField("Gbc","GBC",array("tooltip"=>"Impostare se l'organismo fa parte del GBC per l'anno di riferimento", "bottomLabel"=>"*Impostare se l'organismo fa parte del GBC per l'anno di riferimento", "bottomPadding"=>30),false);
        
        //Spesa incarichi
        $wnd->AddTextField("sSpesaIncarichi","Spesa per incarichi",array("validateFunction"=>"IsNumber", "tooltip"=>"Inserire solo valori numerici,<br>lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire la spesa (pagamenti) per incarichi di studio e consulenza, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui la spesa per incarichi"));

        //Spesa lavoro flessibile
        $wnd->AddTextField("sSpesaLavoroFlessibile","Spesa per lavoro flessibile",array("validateFunction"=>"IsNumber", "invalidMessage"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti","tooltip"=>"Inserire solo valori numerici,<br>lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire la spesa (pagamenti) per il lavoro flessibile, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui la spesa per lavoro flessibile"),false);

        //spesa dotazione organica
        $wnd->AddTextField("sSpesaDotazioneOrganica","Spesa dot. organica",array("validateFunction"=>"IsNumber", "invalidMessage"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare la spesa complessiva per la dotazione organica,<br>inserire solo valori numerici, lasciare vuoto in caso di dati assenti.", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui la spesa per la dotazione organica"));

        //Fatturato
        if($object->GetTipologia(true)==AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) $wnd->AddTextField("sFatturato","Fatturato",array("validateFunction"=>"IsNumber", "invalidMessage"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti","tooltip"=>"riportare il fatturato in euro per l'anno di riferimento,<br>inserire solamente valori numerici, lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci il fatturato"),false);
        else $wnd->AddSpacer(false);

        //field personale a tempo determinato
        $dotazione = new AA_FieldSet("AA_SINES_ORGANISMI_DOTAZIONE_ORGANICA","Personale assunto a tempo determinato");

        //personale a tempo determinato dirigenti
        $dotazione->AddTextField("nDipendentiDetDir","Dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti","bottomLabel"=>"*Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"));

        //personale a tempo determinato
        $dotazione->AddTextField("nDipendentiDet","Non dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti","bottomLabel"=>"*Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"),false);

        //field dipendenti
        $dip = new AA_FieldSet("AA_SINES_ORGANISMI_DIPENDENTI","Personale assunto a tempo indeterminato");

        //dipendenti dirigenti
        $dip->AddTextField("nDipendentiDir","Dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di dipendenti (personale dirigente e non assunto a tempo indeterminato),<br>riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"));

        //dipendenti non dirigenti
        $dip->AddTextField("nDipendenti","Non dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di dipendenti (personale dirigente e non assunto a tempo indeterminato),<br>riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"),false);
        
        $wnd->AddGenericObject($dip);
        $wnd->AddGenericObject($dotazione);

        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_dato_contabile"=>$dato->GetId()));
        $wnd->SetSaveTask("UpdateOrganismoDatoContabile");
        
        return $wnd;
    }
    
    //Template dlg modify organismo incarico
    public function Template_GetOrganismoModifyIncaricoDlg($object=null,$incarico=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoModifyIncaricoDlg";
        
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Modifica incarico", $this->id);
        if(!($incarico instanceof AA_OrganismiNomine)) return new AA_GenericWindowTemplate($id, "Modifica incarico", $this->id);

        $form_data=array();
        foreach($incarico->GetBindings() as $id_obj=>$field)
        {
            $form_data[$id_obj]=$incarico->GetProp($id_obj);
        }
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $wnd=new AA_GenericFormDlg($id, "Modifica incarico di ".$incarico->GetNome()." ".$incarico->GetCognome()." (".$incarico->GetCodiceFiscale().")", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(800);
        
        //nomina Ras
        $wnd->AddSwitchBoxField("bNominaRas","Tipo nomina",array("onLabel"=>"RAS","offLabel"=>"non RAS","bottomLabel"=>"*Indica se la nomina/designazione/indicazione è effettuata dalla RAS."));        
        
        //facente funzione
        $wnd->AddSwitchBoxField("nFacenteFunzione","Facente funzione",array("onLabel"=>"si","offLabel"=>"no","section_id"=>$id."_dataFine","tooltip"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.","bottomLabel"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.", "eventHandlers"=>array("onChange"=>array("handler"=>"onFFChange")),"value"=>"0"));

        //Tipologia
        foreach(AA_Organismi_Const::GetTipoNomine() as $value=>$label)
        {
            if($value > 0) $options[]=array("id"=>$value,"value"=>$label);
        }
        $wnd->AddSelectField("nTipologia","Incarico",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di incarico.","tooltip"=>"Seleziona il tipo di incarico.","options"=>$options));
        
        //Data inizio
        $wnd->AddDateField("sDataInizio","Data inizio",array("required"=>true,"editable"=>true,"gravity"=>2,"bottomLabel"=>"*Inserire la data di inizio dell'incarico", "placeholder"=>"inserisci qui la data di inizio."));
        $wnd->AddSpacer(false);

        $hidden=false;
        if($incarico->IsFacenteFunzione()) 
        {
            AA_Log::Log(__METHOD__." - facente funzione: ".print_r($incarico->IsFacenteFunzione(),true),100);
            $hidden=true;
        }
        
        $section=new AA_FieldSet($id."_dataFine","Conclusione",'',1,array("type"=>"clean","hidden"=>$hidden));

        //Data fine
        $section->AddDateField("sDataFine","Data conclusione",array("required"=>true,"editable"=>true,"gravity"=>2,"bottomLabel"=>"*Inserire la data di conclusione dell'incarico", "placeholder"=>"inserisci qui la data di conclusione."));
        
        //Data fine presunta
        $section->AddCheckBoxField("bDataFinePresunta","Presunta",array("gravity"=>1,"labelWidth"=>90,"bottomLabel"=>"*Abilitare se presunta."),false);
        
        $wnd->AddGenericObject($section);

        //Storico
        $wnd->AddSwitchBoxField("nStorico","Storico",array("onLabel"=>"si","offLabel"=>"no","bottomLabel"=>"*Abilita per archiviare l'incarico come storico."));

        //Estremi del provvedimento
        $wnd->AddTextField("sEstremiProvvedimento","Estremi provvedimento",array("required"=>true,"bottomLabel"=>"*Riportare gli estremi del provvedimento di nomina.", "placeholder"=>"inserisci qui gli estremi del provvedimento di nomina."));
        
        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label);

        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->enableRefreshSectionOnSuccessfulSave();

        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_incarico"=>$incarico->GetId()));
        $wnd->SetSaveTask("UpdateOrganismoIncarico");
        
        return $wnd;
    }
    
    //Template dlg aggiungi organismo incarico
    public function Template_GetOrganismoAddNewIncaricoDlg($object=null,$params=array())
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoAddNewIncaricoDlg";
        
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Aggiungi incarico", $this->id);

        $form_data['sNome']=$params['nome'];
        $form_data['sCognome']=$params['cognome'];
        $form_data['sCodiceFiscale']=$params['cf'];
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi incarico a ".$params['nome']." ".$params['cognome']." (".$params['cf'].")", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(130);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(720);
        
        $bNewNomina=false;

        if(empty($params['nome']) || empty($params['cognome']))
        {
            $wnd->AddTextField("sNome","Nome",array("required"=>true,"bottomLabel"=>"*Riportare il nome del soggetto.", "placeholder"=>"Giulio Cesare"));
            $wnd->AddTextField("sCognome","Cognome",array("required"=>true,"bottomLabel"=>"*Riportare il cognome del soggetto.", "placeholder"=>"Caio"),false);
            $wnd->AddTextField("sCodiceFiscale","Codice fiscale",array("required"=>true,"bottomLabel"=>"*Riportare il codice fiscale del soggetto.", "placeholder"=>"..."));
            $wnd->SetHeight(820);
            $bNewNomina=true;
        }

        //nomina Ras
        $wnd->AddSwitchBoxField("bNominaRas","Tipo nomina",array("onLabel"=>"RAS","offLabel"=>"non RAS","bottomLabel"=>"*Indica se la nomina/designazione/indicazione è effettuata dalla RAS."));        
        
        //Tipologia
        foreach(AA_Organismi_Const::GetTipoNomine() as $key=>$label)
        {
            if($key > 0) $options[]=array("id"=>$key,"value"=>$label);
        }
        $wnd->AddSelectField("nTipologia","Incarico",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di incarico.","tooltip"=>"Seleziona il tipo di incarico.","options"=>$options,"value"=>"0"));
        
        //facente funzione
         //facente funzione
        $wnd->AddSwitchBoxField("nFacenteFunzione","Facente funzione",array("onLabel"=>"si","offLabel"=>"no","section_id"=>$id."_dataFine","tooltip"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.","bottomLabel"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.", "eventHandlers"=>array("onChange"=>array("handler"=>"onFFChange")),"value"=>"0"));

        //$wnd->AddCheckBoxField("nFacenteFunzione","Facente funzione",array("tooltip"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.","bottomLabel"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.", "value"=>"0"));

        //Data inizio
        $wnd->AddDateField("sDataInizio","Data inizio",array("required"=>true,"editable"=>true,"gravity"=>2,"bottomLabel"=>"*Inserire la data di inizio dell'incarico", "placeholder"=>"inserisci qui la data di inizio."));
        $wnd->AddSpacer(false);

        $section=new AA_FieldSet($id."_dataFine","Conclusione",'',1,array("type"=>"clean"));

        //Data fine
        $section->AddDateField("sDataFine","Data conclusione",array("required"=>true,"editable"=>true,"gravity"=>2,"bottomLabel"=>"*Inserire la data di conclusione dell'incarico", "placeholder"=>"inserisci qui la data di conclusione."));
        
        //Data fine presunta
        $section->AddCheckBoxField("bDataFinePresunta","Presunta",array("gravity"=>1,"labelWidth"=>90,"bottomLabel"=>"*Abilitare se presunta."),false);
        
        $wnd->AddGenericObject($section);

        //Data fine
        //$wnd->AddDateField("sDataFine","Data conclusione",array("required"=>true,"editable"=>true,"gravity"=>2,"bottomLabel"=>"*Inserire la data di conclusione dell'incarico", "placeholder"=>"inserisci qui la data di conclusione."));
        
        //Data fine presunta
        //$wnd->AddCheckBoxField("bDataFinePresunta","Presunta",array("gravity"=>1,"labelWidth"=>90,"bottomLabel"=>"*Abilitare se presunta."),false);

        //Estremi del provvedimento
        $wnd->AddTextField("sEstremiProvvedimento","Estremi provvedimento",array("required"=>true,"bottomLabel"=>"*Riportare gli estremi del provvedimento di nomina.", "placeholder"=>"inserisci qui gli estremi del provvedimento di nomina."));
        
        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label);

        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->enableRefreshSectionOnSuccessfulSave();

        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"detail"=>1,"refresh_section"=>1));
        $wnd->SetSaveTask("AddNewOrganismoIncarico");
        
        if($bNewNomina)
        {
            $wnd->SetSaveTask("AddNewOrganismoNomina");
        }
        
        return $wnd;
    }

    //Template dlg aggiungi partecipazione
    public function Template_GetSinesAddNewPartecipazioneDlg($object=null)
    {
        $id=static::AA_UI_PREFIX."_GetSinesAddNewPartecipazioneDlg_".uniqid();
        
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Aggiungi partecipazione", $this->id);

        $form_data=array();
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi una nuova partecipazione", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(640);
        
        //Lista organismi partecipabili
        $organismi=$object->GetListaOrganismiPartecipabili();

        //organismo
        $options=array();
        foreach($organismi as $key=>$val)
        {
            $options[]=array("id"=>$key,"value"=>$val);
        }
        $wnd->AddComboField("organismo","Organismo",array("required"=>true,"validateFunction"=>"IsSelected","tooltip"=>"Seleziona l'organismo.","options"=>$options));

        $section=new AA_FieldSet("","Quote di partecipazione");
            
        //partecipazione
        $field_notes="*Quota di partecipazione espressa in percentuale.";
        $label="Quota %";
        $section->AddTextField("Partecipazione_percentuale",$label,array("bottomLabel"=>$field_notes, "required"=>true,"validateFunction"=>"IsNumber", "bottomPadding"=>48, "placeholder"=>"es. 10,05"));
        $label="Quota &euro;";
        $field_notes="*Quota di partecipazione espressa in euro.";
        $section->AddTextField("Partecipazione_euro",$label,array("bottomLabel"=>$field_notes, "required"=>true,"validateFunction"=>"IsNumber", "bottomPadding"=>48, "placeholder"=>"es. 123456,78"),false);
        
        $wnd->AddGenericObject($section);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("AddNewSinesPartecipazione");
        
        return $wnd;
    }

    //Template dlg modifica partecipazione
    public function Template_GetSinesModifyPartecipazioneDlg($object=null,$idOrgPart=0)
    {
        $id=static::AA_UI_PREFIX."_GetSinesModifyPartecipazioneDlg_".uniqid();
        
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Modifica partecipazione", $this->id);

        $form_data=array();
        $form_data['organismo']=$idOrgPart;

        $partecipazione=$object->GetPartecipazione(true);
        $form_data['Partecipazione_percentuale']=AA_Utils::number_format($partecipazione['partecipazioni'][$idOrgPart]['percentuale'],2,",",".");
        $form_data['Partecipazione_euro']=AA_Utils::number_format($partecipazione['partecipazioni'][$idOrgPart]['euro'],2,",",".");
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $wnd=new AA_GenericFormDlg($id, "Modifica una partecipazione esistente", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(320);
        
        //Lista organismi partecipabili
        $organismoPartecipante=new AA_Organismi($idOrgPart,$this->oUser);

        $wnd->AddGenericObject(new AA_JSON_Template_Template("",array("type"=>"clean","template"=>"<div>Modifica le quote di partecipazione per l'organismo partecipante: <p><b>".$organismoPartecipante->GetDenominazione()."</b></p></div>")));
        
        //organismo
        //$options=array("id"=>);
        //foreach($organismi as $key=>$val)
        //{
        //    if($id > 0) $options[]=array("id"=>$key,"value"=>$val);
        //}
        //$wnd->AddSelectField("organismo","Organismo",array("required"=>true,"validateFunction"=>"IsSelected","tooltip"=>"Seleziona l'organismo.","options"=>$options));

        $section=new AA_FieldSet("","Quote di partecipazione");
            
        //partecipazione
        $field_notes="*Quota di partecipazione espressa in percentuale.";
        $label="Quota %";
        $section->AddTextField("Partecipazione_percentuale",$label,array("bottomLabel"=>$field_notes, "required"=>true,"validateFunction"=>"IsNumber", "bottomPadding"=>48, "placeholder"=>"es. 10,05"));
        $label="Quota &euro;";
        $field_notes="*Quota di partecipazione espressa in euro.";
        $section->AddTextField("Partecipazione_euro",$label,array("bottomLabel"=>$field_notes, "required"=>true,"validateFunction"=>"IsNumber", "bottomPadding"=>48, "placeholder"=>"es. 123456,78"),false);
        
        $wnd->AddGenericObject($section);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("UpdateSinesPartecipazione");
        
        return $wnd;
    }
        
    //Template dlg aggiungi organismo incarico doc
    public function Template_GetOrganismoAddNewIncaricoDocDlg($object=null,$incarico=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoAddNewIncaricoDocDlg";
        
        if(!($object instanceof AA_Organismi) || !($incarico instanceof AA_OrganismiNomine)) return new AA_GenericWindowTemplate($id, "Aggiungi documento", $this->id);
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data['anno']=Date("Y");
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi documento per ".$incarico->GetNome()." ".$incarico->GetCognome()." (".$incarico->GetCodiceFiscale().")", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(720);
        $wnd->SetHeight(360);
        
        //anno
        $options=array();
        $anno_fine=Date('Y');
        $anno_start=($anno_fine-5);
        
        for($i=$anno_fine; $i>=$anno_start; $i--)
        {
            $options[]=array("id"=>$i, "value"=>$i);
        }
        $wnd->AddSelectField("anno","Anno",array("required"=>true,"validateFunction"=>"IsInteger","bottomLabel"=>"*Indicare l'anno di riferimento.", "placeholder"=>"Scegli l'anno di riferimento.","options"=>$options,"value"=>Date('Y')));
        //$wnd->AddTextField("anno","Anno",array("required"=>true,"validateFunction"=>"IsInteger","bottomLabel"=>"*Riportare l'anno a quattro cifre.", "placeholder"=>"inserisci qui l'anno di riferimento."));
        
        //Tipologia
        $options=array();
        foreach(AA_Organismi_Const::GetTipoDocs() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("tipo","Tipo di documento",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di documento.","bottomLabel"=>"*Seleziona il tipo di documento.","options"=>$options,"value"=>"0"));
        
        //file
        $wnd->AddFileUploadField("NewIncaricoDoc","", array("required"=>true, "validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti pdf con firma digitale in formato PADES (dimensione max: 2Mb).","accept"=>"application/pdf"));
        
        $wnd->EnableCloseWndOnSuccessfulSave();
        if(isset($_REQUEST['refresh']) && $_REQUEST['refresh'] !="") $wnd->enableRefreshOnSuccessfulSave();
        if(isset($_REQUEST['refresh_obj_id']) && $_REQUEST['refresh_obj_id'] !="") $wnd->SetRefreshObjId($_REQUEST['refresh_obj_id']);
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_incarico"=>$incarico->GetId()));
        $wnd->SetSaveTask("AddNewOrganismoIncaricoDoc");
        
        return $wnd;
    }
    
    //Template dlg aggiungi provvedimento organismo
    public function Template_GetOrganismoAddNewProvvedimentoDlg($object=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoAddNewProvvedimentoDlg";
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array();
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi provvedimento", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(60);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(580);

        //Anno
        $anno_fine=Date('Y');
        $anno_start=($anno_fine-115);
        for($i=$anno_fine; $i>=$anno_start; $i--)
        {
            $options[]=array("id"=>$i, "value"=>$i);
        }
        $wnd->AddSelectField("anno","Anno",array("required"=>true,"validateFunction"=>"IsInteger","bottomLabel"=>"*Indicare l'anno di adozione del provvedimento.", "placeholder"=>"Scegli l'anno di adozione del provvedimento.","options"=>$options,"value"=>Date('Y')));
        
        //Tipologia
        $options=array();
        foreach(AA_Organismi_Const::GetTipoProvvedimenti() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("tipo","Tipo",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di documento.","bottomLabel"=>"*Seleziona il tipo di provvedimento.","options"=>$options,"value"=>"0"));

        //estremi
        $wnd->AddTextField("estremi", "Estremi", array("bottomLabel" => "*Indicare gli estremi del documento o dell'atto", "placeholder" => "DGR ..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>30)));
        
        //url
        $wnd->AddTextField("url", "Url", array("validateFunction"=>"IsUrl","bottomLabel"=>"*Indicare un'URL sicura, es. https://www.regione.sardegna.it", "placeholder"=>"https://..."));
        
        $wnd->AddGenericObject(new AA_JSON_Template_Template($id."_Section",array("type"=>"section","template"=>"oppure","align"=>"center")));
        
        //file
        $wnd->AddFileUploadField("NewProvvedimentoDoc","", array("validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti pdf (dimensione max: 2Mb).","accept"=>"application/pdf"));
                
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("AddNewOrganismoProvvedimento");
        
        return $wnd;
    }

    //Template dlg aggiungi organigramma
    public function Template_GetOrganismoAddNewOrganigrammaDlg($object=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoAddNewOrganigrammaDlg";
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array("ordine"=>0);
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi organigramma", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(150);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(480);
        
        //Tipo
        $options=array();
        foreach(AA_Organismi_Const::GetListaTipoOrganigramma() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("tipo","Tipo organo",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di organo.","bottomLabel"=>"*Seleziona il tipo di organismo.","options"=>$options,"value"=>"0"));

        //abilita scadenzario
        $wnd->AddSwitchBoxField("enable_scadenzario","Scadenzario",array("onLabel"=>"includi","offLabel"=>"escludi","bottomLabel"=>"*Includi o escludi l'organigramma nel calcolo dello scadenzario."));

        //ordine
        $wnd->AddTextField("ordine","Ordine",array("bottomLabel"=>"*Ordine di visualizzazione, valori più piccoli vengono prima."));

        //note
        $wnd->AddTextareaField("note", "Note", array("bottomLabel" => "", "placeholder" => "..."));
                        
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("AddNewOrganismoOrganigramma");
        $wnd->EnableApplyHotkey(false);
        
        return $wnd;
    }
    //Template dlg aggiungi organigramma
    public function Template_GetOrganismoModifyOrganigrammaDlg($object=null,$organigramma=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoUpdateOrganigrammaDlg";
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array("ordine"=>$organigramma->GetProp("ordine"),"tipo"=>$organigramma->GetProp("tipo"),"enable_scadenzario"=>$organigramma->GetProp('enable_scadenzario'),"note"=>$organigramma->GetProp("note"));
        
        $wnd=new AA_GenericFormDlg($id, "Modifica organigramma", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(150);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(480);
        
        //Tipo
        $options=array();
        foreach(AA_Organismi_Const::GetListaTipoOrganigramma() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("tipo","Tipo organo",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di organo.","bottomLabel"=>"*Seleziona il tipo di organismo.","options"=>$options,"value"=>"0"));

        //abilita scadenzario
        $wnd->AddSwitchBoxField("enable_scadenzario","Scadenzario",array("onLabel"=>"includi","offLabel"=>"escludi","bottomLabel"=>"*Includi o escludi l'organigramma nel calcolo dello scadenzario."));

        //ordine
        $wnd->AddTextField("ordine","Ordine",array("bottomLabel"=>"*Ordine di visualizzazione, valori più piccoli vengono prima."));

        //note
        $wnd->AddTextareaField("note", "Note", array("bottomLabel" => "", "placeholder" => "..."));
                        
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_organigramma"=>$organigramma->GetId()));
        $wnd->SetSaveTask("UpdateOrganismoOrganigramma");
        $wnd->EnableApplyHotkey(false);
        
        return $wnd;
    }
    
    //Template dlg modifica provvedimento organismo
    public function Template_GetOrganismoModifyProvvedimentoDlg($object=null,$provvedimento=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoModifyProvvedimentoDlg";
        
        //AA_Log:Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $form_data=array("tipo"=>$provvedimento->GetTipologia(true),"url"=>$provvedimento->GetUrl(), "anno"=>$provvedimento->GetAnno(),"estremi"=>$provvedimento->GetEstremi());
        
        $wnd=new AA_GenericFormDlg($id, "Modifica provvedimento", $this->id,$form_data,$form_data);
        
        //$wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(60);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(640);
        $wnd->SetHeight(580);
        
        //Anno
        $anno_fine=Date('Y');
        $anno_start=($anno_fine-115);
        for($i=$anno_fine; $i>=$anno_start; $i--)
        {
            $options[]=array("id"=>$i, "value"=>$i);
        }
        $wnd->AddSelectField("anno","Anno",array("required"=>true,"validateFunction"=>"IsInteger","bottomLabel"=>"*Indicare l'anno di adozione del provvedimento.", "placeholder"=>"Scegli l'anno di adozione del provvedimento.","options"=>$options,"value"=>Date('Y')));
        
        //Tipologia
        $options=array();
        foreach(AA_Organismi_Const::GetTipoProvvedimenti() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("tipo","Tipo",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di documento.","bottomLabel"=>"*Seleziona il tipo di provvedimento.","options"=>$options,"value"=>"0"));

        //estremi
        $wnd->AddTextField("estremi", "Estremi", array("bottomLabel" => "*Indicare gli estremi del documento o dell'atto", "placeholder" => "DGR ..."));

        $wnd->AddGenericObject(new AA_JSON_Template_Generic("",array("type"=>"spacer","height"=>30)));
        
        //url
        $wnd->AddTextField("url", "Url", array("validateFunction"=>"IsUrl","bottomLabel"=>"*Indicare un'URL sicura, es. https://www.regione.sardegna.it", "placeholder"=>"https://..."));
        
        $wnd->AddGenericObject(new AA_JSON_Template_Template($id."_Section",array("type"=>"section","template"=>"oppure","align"=>"center")));
        
        //file
        $wnd->AddFileUploadField("NewProvvedimentoDoc","", array("validateFunction"=>"IsFile","bottomLabel"=>"*Caricare solo documenti pdf (dimensione max: 2Mb).","accept"=>"application/pdf"));
                
        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_provvedimento"=>$provvedimento->GetId()));
        $wnd->SetSaveTask("UpdateOrganismoProvvedimento");
        
        return $wnd;
    }
        
    //Template dlg modifica nominato incarico
    public function Template_GetOrganismoRenameNominaDlg($object=null,$params)
    {
        $id=$this->id."_GetOrganismoRenameNominaDlg";
        
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Rinomina nomine", $this->id);

        
        $form_data['sNome']=$params['nome'];
        $form_data['sCognome']=$params['cognome'];
        $form_data['sCodiceFiscale']=$params['cf'];
        $form_data['ids']=$params['ids'];
        
        AA_Log::Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $wnd=new AA_GenericFormDlg($id, "Rinomina nomine", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(800);
        $wnd->SetHeight(400);

        //Nome
        $wnd->AddTextField("sNome","nome",array("required"=>true,"bottomLabel"=>"*Indicare il nuovo nome.", "placeholder"=>"inserisci qui il nome."));

        //cognome
        $wnd->AddTextField("sCognome","cognome",array("required"=>true,"bottomLabel"=>"*Indicare il nuovo cognome.", "placeholder"=>"inserisci qui il cognome."));
        
        //Codice fiscale
        $wnd->AddTextField("sCodiceFiscale","Codice fiscale",array("required"=>true,"bottomLabel"=>"*Indicare il nuovo codice fiscale.", "placeholder"=>"inserisci qui il codice fiscale."));

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("RenameOrganismoNomina");
        
        return $wnd;
    }
        
    //Template dlg aggiungi organismo incarico
    public function Template_GetOrganismoAddNewNominaDlg($object=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoAddNewNominaDlg";
        
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Aggiungi nomina", $this->id);

        $form_data['sNome']="";
        $form_data['sCognome']="";
        $form_data['sCodiceFiscale']="";
        $form_data['bDataFinePresunta']=0;
        
        AA_Log::Log(__METHOD__." form data: ".print_r($form_data,true),100);
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi nuova nomina", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(120);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(860);
        $wnd->SetHeight(580);

        //Nome
        $wnd->AddTextField("sNome","nome",array("required"=>true,"bottomLabel"=>"*Indicare il nome del nominato.", "placeholder"=>"inserisci qui il nome."));

        //cognome
        $wnd->AddTextField("sCognome","cognome",array("required"=>true,"bottomLabel"=>"*Indicare il cognome del nominato.", "placeholder"=>"inserisci qui il cognome."),false);

        //Tipologia
        $options=array();
        foreach(AA_Organismi_Const::GetTipoNomine() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("nTipologia","Incarico",array("required"=>true,"validateFunction"=>"IsPositive","customInvalidMessage"=>"*Occorre selezionare il tipo di incarico.","bottomLabel"=>"*Seleziona il tipo di incarico.","options"=>$options,"value"=>"0"));
        
        //Data inizio
        $wnd->AddDateField("sDataInizio","Data inizio",array("required"=>true,"editable"=>true,"bottomLabel"=>"*Inserire la data di inizio dell'incarico", "placeholder"=>"inserisci qui la data di inizio."),false);
        
        //Codice fiscale
        $wnd->AddTextField("sCodiceFiscale","Codice fiscale",array("required"=>true,"bottomLabel"=>"*Indicare il codice fiscale del nominato.", "placeholder"=>"inserisci qui il codice fiscale."));
        
        //Data fine
        $wnd->AddDateField("sDataFine","Data fine",array("required"=>true,"editable"=>true,"bottomLabel"=>"*Inserire la data di conclusione dell'incarico", "placeholder"=>"inserisci qui la data di conclusione."),false);

        //nomina Ras
        $wnd->AddSwitchBoxField("bNominaRas","Tipo nomina",array("onLabel"=>"RAS","offLabel"=>"non RAS","bottomLabel"=>"*Indica se la nomina è effettuata dalla RAS."));                
        
        //Data fine presunta
        $wnd->AddCheckBoxField("bDataFinePresunta"," ",array("gravity"=>1,"labelWidth"=>90,"labelRight"=>"<b>Data fine presunta</b>","bottomLabel"=>"*Abilitare se la data di fine e' presunta."),false);

        //facente funzione
        $wnd->AddSwitchBoxField("nFacenteFunzione","Facente funzione",array("onLabel"=>"si","offLabel"=>"no","tooltip"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.","bottomLabel"=>"Abilita se l'incarico è una sostituzione temporanea, ad esempio ex art.30.", "value"=>"0"));

        //Estremi del provvedimento
        $wnd->AddTextField("sEstremiProvvedimento","Estremi provvedimento",array("bottomLabel"=>"*Riportare gli estremi del provvedimento.", "placeholder"=>"inserisci qui gli estremi del provvedimento."),false);
        
        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        $wnd->SetSaveTask("AddNewOrganismoNomina");
        
        return $wnd;
    }
    
    //Template dlg addnew dato contabile organismo
    public function Template_GetOrganismoAddNewDatoContabileDlg($object=null)
    {
        $id=static::AA_UI_PREFIX."_GetOrganismoAddNewDatoContabileDlg";
        
        $form_data['nIdParent']=$object->GetID();
        $form_data['nAnno']=Date("Y");
        $form_data['Gap']=0;
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi un nuovo dato contabile e dotazione organica", $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(160);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(1080);
        $wnd->SetHeight(700);
        
        //anno
        $wnd->AddTextField("nAnno","Anno",array("tooltip"=>"Anno di riferimento", "validateFunction"=>"isNumber", "invalidMessage"=>"L'anno deve essere un numero intero a quatttro cifre","required"=>true,"bottomLabel"=>"*Inserire il valore numerico dell'anno a quattro cifre, es. 2021", "bottomPadding"=>30, "placeholder"=>"inserisci qui l'anno di riferimento"));

        //gap
        $wnd->AddCheckBoxField("Gap","GAP",array("tooltip"=>"Impostare se l'organismo fa parte del GAP per l'anno di riferimento", "bottomLabel"=>"*Impostare se l'organismo fa parte del GAP per l'anno di riferimento", "bottomPadding"=>30),false);

        //oneri totali
        $wnd->AddTextField("sOneriTotali","Oneri totali",array("validateFunction"=>"IsNumber", "tooltip"=>"Inserire solo valori numerici,<br>lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui gli oneri totali"));
        
        //gbc
        $wnd->AddCheckBoxField("Gbc","GBC",array("tooltip"=>"Impostare se l'organismo fa parte del GBC per l'anno di riferimento", "bottomLabel"=>"*Impostare se l'organismo fa parte del GBC per l'anno di riferimento", "bottomPadding"=>30),false);

        //Spesa incarichi
        $wnd->AddTextField("sSpesaIncarichi","Spesa per incarichi",array("validateFunction"=>"IsNumber", "tooltip"=>"Inserire solo valori numerici,<br>lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire la spesa (pagamenti) per incarichi di studio e consulenza, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui la spesa per incarichi"));

        //Spesa lavoro flessibile
        $wnd->AddTextField("sSpesaLavoroFlessibile","Spesa per lavoro flessibile",array("validateFunction"=>"IsNumber", "invalidMessage"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti","tooltip"=>"Inserire solo valori numerici,<br>lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire la spesa (pagamenti) per il lavoro flessibile, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui la spesa per lavoro flessibile"),false);

        //spesa dotazione organica
        $wnd->AddTextField("sSpesaDotazioneOrganica","Spesa dot. organica",array("validateFunction"=>"IsNumber", "invalidMessage"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare la spesa complessiva per la dotazione organica,<br>inserire solo valori numerici, lasciare vuoto in caso di dati assenti.", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui la spesa per la dotazione organica"));

        //Fatturato
        if($object->GetTipologia(true)==AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) $wnd->AddTextField("sFatturato","Fatturato",array("validateFunction"=>"IsNumber", "invalidMessage"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti","tooltip"=>"riportare il fatturato in euro per l'anno di riferimento,<br>inserire solamente valori numerici, lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci il fatturato"),false);
        else $wnd->AddSpacer(false);

        //field personale a tempo determinato
        $dotazione = new AA_FieldSet("AA_SINES_ORGANISMI_DOTAZIONE_ORGANICA","Personale assunto a tempo determinato");

        //personale a tempo determinato dirigenti
        $dotazione->AddTextField("nDipendentiDetDir","Dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti","bottomLabel"=>"*Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"));

        //personale a tempo determinato
        $dotazione->AddTextField("nDipendentiDet","Non dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti","bottomLabel"=>"*Indicare il numero di unità di personale sia esterno che interno,<br> riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"),false);

        //field dipendenti
        $dip = new AA_FieldSet("AA_SINES_ORGANISMI_DIPENDENTI","Personale assunto a tempo indeterminato");

        //dipendenti dirigenti
        $dip->AddTextField("nDipendentiDir","Dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di dipendenti (personale dirigente e non assunto a tempo indeterminato),<br>riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"));

        //dipendenti non dirigenti
        $dip->AddTextField("nDipendenti","Non dirigenti",array("validateFunction"=>"IsInteger", "invalidMessage"=>"*Inserire solo numeri interi, lasciare vuoto in caso di dati assenti","tooltip"=>"Indicare il numero di dipendenti (personale dirigente e non assunto a tempo indeterminato),<br>riportare solo valori numerici interi, lasciare vuoto in caso di dati assenti", "bottomLabel"=>"*Inserire solo valori numerici, lasciare vuoto in caso di dati assenti", "bottomPadding"=>30,"placeholder"=>"inserisci qui il numero di dipendenti"),false);
        
        $wnd->AddGenericObject($dip);
        $wnd->AddGenericObject($dotazione);

        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label);

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("AddNewOrganismoDatoContabile");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId()));
        
        return $wnd;
    }
    
    //Template dlg addnew bilancio
    public function Template_GetOrganismoAddNewBilancioDlg($object=null,$dato_contabile=null)
    {
        $id=$this->id."_AddNewBilancio_Dlg";
        
        $wnd=new AA_GenericFormDlg($id, "Aggiungi un nuovo bilancio riferito all'anno ".$dato_contabile->GetAnno(), $this->id);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(480);
        $wnd->SetHeight(380);
        
        //Tipologia
        $options=array();
        foreach(AA_Organismi_Const::GetTipoBilanci() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("nTipologia","Tipologia",array("required"=>true,"options"=>$options,"bottomLabel"=>"*Seleziona il tipo di bilancio."));

        //Risultati
        $wnd->AddTextField("sRisultati","Risultati",array("required"=>true, "validateFunction"=>"IsNumber", "bottomLabel"=>"*Inserire solo valori numerici o lasciare vuoto.", "placeholder"=>"inserisci qui i risultati di bilancio"));
                
        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label, array("bottomPadding"=>0));

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("AddNewOrganismoBilancio");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_dato_contabile"=>$dato_contabile->GetId()));
        
        return $wnd;
    }
    
    //Template dlg modify bilancio
    public function Template_GetOrganismoModifyBilancioDlg($object=null,$dato_contabile=null,$bilancio=null)
    {
        $id=$this->id."_ModifyBilancio_Dlg";
        
        $form_data['nTipologia']=$bilancio->GetTipo(true);
        $form_data['sRisultati']=$bilancio->GetRisultati();
        $form_data['sNote']=$bilancio->GetNote();
        
        $wnd=new AA_GenericFormDlg($id, "Modifica bilancio riferito all'anno ".$dato_contabile->GetAnno(), $this->id,$form_data,$form_data);
        
        $wnd->SetLabelAlign("right");
        $wnd->SetLabelWidth(80);
        $wnd->SetBottomPadding(30);
        $wnd->EnableValidation();
        
        $wnd->SetWidth(480);
        $wnd->SetHeight(380);
        
        //Tipologia
        $options=array();
        foreach(AA_Organismi_Const::GetTipoBilanci() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $wnd->AddSelectField("nTipologia","Tipologia",array("required"=>true,"options"=>$options,"bottomLabel"=>"*Seleziona il tipo di bilancio."));

        //Risultati
        $wnd->AddTextField("sRisultati","Risultati",array("required"=>true, "validateFunction"=>"IsNumber", "bottomLabel"=>"*Inserire solo valori numerici o lasciare vuoto.", "placeholder"=>"inserisci qui i risultati di bilancio"));
                
        //note
        $label="Note";
        $wnd->AddTextareaField("sNote",$label, array("bottomPadding"=>0));

        $wnd->EnableCloseWndOnSuccessfulSave();
        $wnd->enableRefreshOnSuccessfulSave();
        $wnd->SetSaveTask("UpdateOrganismoBilancio");
        $wnd->SetSaveTaskParams(array("id"=>$object->GetId(),"id_dato_contabile"=>$dato_contabile->GetId(),"id_bilancio"=>$bilancio->GetId()));
        
        return $wnd;
    }
    
    //Template dlg nomna detail
    public function Template_GetOrganismoNominaDetailViewDlg($object=null,$nomina=null)
    {
        $id=static::AA_UI_PREFIX."_".static::AA_UI_WND_NOMINA_DETAIL;
        if(!($object instanceof AA_Organismi)) return new AA_GenericWindowTemplate($id, "Dettagli incarico", $this->id);
        if(!($nomina instanceof AA_OrganismiNomine)) return new AA_GenericWindowTemplate($id, "Dettagli incarico", $this->id);


        $wnd = new AA_GenericWindowTemplate($id, "Dettaglio incarico di ".$nomina->GetCognome()." ".$nomina->GetNome(), $this->id);

        $layout=$this->Template_GetOrganismoNominaDetailViewLayout($object,$nomina,$id);
        $wnd->AddView($layout);
        return $wnd;
    }

    //Template layout nomina
    public function Template_GetOrganismoNominaDetailViewLayout($object=null,$incarico=null,$id="")
    {
        if(!$object) $object=new AA_Organismi($_REQUEST['id']);
        if(!$object->isValid())
        {
            $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean", "filtered"=>true,"filter_id"=>$id));
            $layout->AddRow(new AA_JSON_Template_Template($id."_vuoto",array("type"=>"clean","template"=>"<div style='display: flex; align-items: center; justify-content: center; width:100%;height:100%'><span>Errore nel recupero dei dati.</span></div>")));
            return $layout;
        }

        if(!$incarico) $incarico = new AA_OrganismiNomine($_REQUEST["id_incarico"],$object,$this->oUser);
        if(!($incarico->isValid()))
        {
            $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean", "filtered"=>true,"filter_id"=>$id));
            $layout->AddRow(new AA_JSON_Template_Template($id."_vuoto",array("type"=>"clean","template"=>"<div style='display: flex; align-items: center; justify-content: center; width:100%;height:100%'><span>Errore nel recupero dei dati dell'incarico.</span></div>")));
            return $layout;
        }

        $canModify=false;
        if(($incarico->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_WRITE)>0) $canModify=true;
        if($id=="") $id=static::AA_UI_PREFIX."_".static::AA_UI_WND_NOMINA_DETAIL."_".static::AA_UI_LAYOUT_NOMINA_DETAIL;
        else $id.="_".static::AA_UI_LAYOUT_NOMINA_DETAIL;
        $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean", "filtered"=>true,"filter_id"=>$id,"css"=>"AA_Detail_Content"));
        
        $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar",array("height"=>38,"css"=>array("border-bottom"=>"1px solid #dadee0 !important","background-color"=>"#dadee0 !important")));
        $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));

        $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"label","align"=>"center", "label"=>"<span style='color:#003380'>".$incarico->GetTipologia()."</span>")));

        //modifica
        if($canModify)
        {
            $modify_btn=new AA_JSON_Template_Generic($id."_ModifyIncarico_btn",array(
                "view"=>"button",
                 "type"=>"icon",
                 "icon"=>"mdi mdi-pencil",
                 "label"=>"Modifica",
                 "css"=>"webix_primary",
                 "align"=>"right",
                 "width"=>120,
                 "tooltip"=>"Modifica",
                 "click"=>"AA_MainApp.utils.callHandler('dlg', {task: 'GetOrganismoModifyIncaricoDlg', postParams: {id: ".$object->GetId().", id_incarico:".$incarico->GetId().", refresh: 1, refresh_obj_id:'".$id."'}, module: '" . $this->id . "'},'".$this->id."')"
            ));

            $delete_btn=new AA_JSON_Template_Generic($id."_DeleteIncarico_btn",array(
                "view"=>"button",
                 "type"=>"icon",
                 "icon"=>"mdi mdi-trash-can",
                 "label"=>"Elimina",
                 "css"=>"webix_danger",
                 "align"=>"right",
                 "width"=>120,
                 "tooltip"=>"Elimina",
                 "click"=>"AA_MainApp.utils.callHandler('dlg', {task: 'GetOrganismoTrashIncaricoDlg', postParams: {id: ".$object->GetId().", id_incarico:".$incarico->GetId().", refresh: 1}, module: '" . $this->id . "'},'".$this->id."')"
            ));
            $toolbar->AddElement($modify_btn);   

            $toolbar->AddElement($delete_btn);

        }
        else
        {
            $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
        }
        $layout->addRow($toolbar);

        //--------------------- Dati incarico -------------------------------
        $toolbar=new AA_JSON_Template_Toolbar("",array("height"=>42, "css"=>"AA_Header_Tabbar_Title"));
        $now=date("Y-m-d");

        //stato incarico
        $incarico_label="<span class='AA_Label AA_Label_LightBlue'>in corso</span>&nbsp;";
        if($incarico->GetDataFine() < $now && !$incarico->IsStorico() && !$incarico->IsFacenteFunzione()) $incarico_label="<span class='AA_Label AA_Label_LightRed'>cessato</span>&nbsp;";
        if($incarico->IsStorico() && !$incarico->IsFacenteFunzione()) $incarico_label="<span class='AA_Label AA_Label_LightGray'>storico</span>&nbsp;";
        if($incarico->IsFacenteFunzione()) $incarico_label="<span class='AA_Label AA_Label_LightYellow'>facente funzione</span>&nbsp;";
        if($incarico->GetNominaRas()) $incarico_label.="<span class='AA_Label AA_Label_LightGreen'>nomina RAS</span>&nbsp;";
        if($incarico->IsOver65()) $incarico_label.="<span class='AA_Label AA_Label_LightOrange'>+65</span>";
        $toolbar->AddElement(new AA_JSON_Template_Template($id."_Nomina_Ras",array("type"=>"clean", "width"=>210,"template"=>"<div style='margin-top: 2px; padding-left: .7em; border-right: 1px solid #dedede;'><span style='font-weight: 700;'>Stato incarico: </span><br>$incarico_label</div>")));

        //data inizio
        $toolbar->AddElement(new AA_JSON_Template_Template("",array("type"=>"clean", "width"=>150,"template"=>"<div style='padding-left: .7em;margin-top: 2px;'><span style='font-weight: 700;'>Data inizio incarico: </span><br>".$incarico->GetDataInizio()."</div>")));
            
        //data fine
        $val=$incarico->GetDataFine();
        if(strpos($val,"9999") !== false || $incarico->IsFacenteFunzione())
        {
            $val="a tempo indeterminato";
        }

        if($incarico->IsDataFinePresunta())
        {
            $val.="&nbsp;<span class='AA_Label AA_Label_LightYellow'>presunta</span>";
        }
        $toolbar->AddElement(new AA_JSON_Template_Template("",array("type"=>"clean","width"=>220, "template"=>"<div style='padding-left: .7em;margin-top: 2px; border-left: 1px solid #dedede'><span style='font-weight: 700;'>Data fine incarico: </span><br>".$val."</div>")));

        //estremi provvedimento
        $value=$incarico->GetEstremiProvvedimento();
        if($value=="") $value="n.d.";
        $toolbar->AddElement(new AA_JSON_Template_Template("",array("type"=>"clean", "template"=>"<div style='padding-left: .7em;margin-top: 2px; border-left: 1px solid #dedede'><span style='font-weight: 700;'>Estremi del provvedimento: </span><br>".$value."</div>")));
        
        //Trattamento economico complessivo
        $value=$incarico->GetCompensoSpettante();
        if($value=="") $value="n.d.";
        $toolbar->AddElement(new AA_JSON_Template_Template("",array("type"=>"clean","width"=>300, "template"=>"<div style='padding-left: .7em;margin-top: 2px; border-left: 1px solid #dedede;'><span style='font-weight: 700;'>Trattamento economico complessivo in €: </span><br>".$value."</div>")));
            
        $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>50)));
        $layout->AddRow($toolbar);
        
        //note
        $value=$incarico->GetNote();
        $val1=new AA_JSON_Template_Template("",array("autoheight"=>true,"css"=>"AA_Header_Tabbar_Title",
            "template"=>"<span style='font-weight:700'>#title#</span><div style='min-height:60px; overflow: auto'>#value#</div>",
            "data"=>array("title"=>"Note:","value"=>$value)
        ));
        $layout->AddRow($val1);                
        
        //Riga compensi e documenti
        $curId=$id."_".uniqid();
        $multiview=new AA_JSON_Template_Multiview($id."_MultiviewNominaDetail",array(
            "type"=>"clean",
            "css"=>"AA_Detail_Content"
        ));

        $tabbar=new AA_JSON_Template_Toolbar("",array("height"=>42, "css"=>"AA_Header_Tabbar_Title"));
        $detail_options=array(
            array("id"=>$id."_NominaDetailCompensi", "value"=>"Compensi"),
            array("id"=>$id."_NominaDetailDocumenti", "value"=>"Documenti"),
        );

        $tabbar->addCol(new AA_JSON_Template_Generic($id."_TabBarNominaDetail",array(
            "view"=>"tabbar",
            "borderless"=>true,
            "value"=>$id."_NominaDetailCompensi",
            "css"=>"AA_Header_TabBar",
            "multiview"=>true,
            "view_id"=>$id."_MultiviewNominaDetail",
            "options"=>$detail_options
        )));
        $layout->AddRow($tabbar);

        #compensi----------------------------------
        $curId=$id."_NominaDetailCompensi";
        $incarico_compensi=new AA_JSON_Template_Layout($id."_NominaDetailCompensi",array("type"=>"clean","css"=>array("border-right"=>"1px solid #dedede !important;")));
        
        $toolbar=new AA_JSON_Template_Toolbar($curId."_Toolbar_Compensi",array("height"=>38, "css"=>array("background"=>"#dadee0 !important;")));
        $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));

        $toolbar->AddElement(new AA_JSON_Template_Generic($curId."_Toolbar_Compensi_Title",array("view"=>"label","label"=>"<span style='color:#003380'>Trattamento economico</span>", "align"=>"center")));

        if($canModify)
        {
            //Pulsante di aggiunta compenso
            $add_compenso_btn=new AA_JSON_Template_Generic($curId."_AddCompenso_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-pencil-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "width"=>120,
                "tooltip"=>"Aggiungi trattamento economico per l'incarico",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:'GetOrganismoAddNewIncaricoCompensoDlg', postParams: {id: ".$object->GetId().", id_incarico:".$incarico->GetId().", refresh: 1, refresh_obj_id:'".$id."'}},'".$this->id."')"
            ));

            $toolbar->AddElement($add_compenso_btn);
        }
        else 
        {
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
        }

        $incarico_compensi->AddRow($toolbar);

        $options_compensi=array();

        if($canModify)
        {
            $options_compensi[]=array("id"=>"anno", "header"=>"Anno", "width"=>60, "css"=>array("text-align"=>"left"));
            $options_compensi[]=array("id"=>"parte_fissa", "header"=>"Parte fissa in €", "width"=>150,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"parte_variabile", "header"=>"Parte variabile in €", "width"=>150,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"rimborsi", "header"=>"Rimborsi in €", "width"=>150,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"totale", "header"=>"Totale (fissa+variabile) in €", "fillspace"=>true,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"note", "header"=>"Note", "fillspace"=>true,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }
        else
        {
            $options_compensi[]=array("id"=>"anno", "header"=>"Anno", "width"=>60, "css"=>array("text-align"=>"left"));
            $options_compensi[]=array("id"=>"parte_fissa", "header"=>"Parte fissa in €", "width"=>150,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"parte_variabile", "header"=>"Parte variabile in €", "width"=>150,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"rimborsi", "header"=>"Rimborsi in €", "width"=>150,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"totale", "header"=>"Totale (fissa+variabile) in €", "fillspace"=>true,"css"=>array("text-align"=>"center"));
            $options_compensi[]=array("id"=>"note", "header"=>"Note", "fillspace"=>true,"css"=>array("text-align"=>"center"));
        }

        $compensi=new AA_JSON_Template_Generic($curId."_Compensi_Table",array("view"=>"datatable", "headerRowHeight"=>28, "select"=>true, "scrollX"=>false,"css"=>"AA_Header_DataTable","columns"=>$options_compensi));

        $compensi_data=array();
        foreach($incarico->GetCompensi($this->oUser) as $id_comp=>$curComp)
        {
            $tot=0;
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoModifyIncaricoCompensoDlg", params: [{id: "'.$object->GetId().'"},{id_incarico:"'.$incarico->GetId().'"},{id_compenso:"'.$curComp->GetId().'"}, {refresh: 1}, {refresh_obj_id:"'.$id.'"}]},"'.$this->id.'")';
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoTrashIncaricoCompensoDlg", params: [{id: "'.$object->GetId().'"},{id_incarico:"'.$incarico->GetId().'"},{id_compenso:"'.$curComp->GetId().'"}, {refresh: 1}, {refresh_obj_id:"'.$id.'"}]},"'.$this->id.'")';
            $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            $tot= number_format(doubleval(str_replace(array(".",","),array("","."),$curComp->GetParteFissa()))+doubleval(str_replace(array(".",","),array("","."),$curComp->GetParteVariabile())),2,",",".");
            $compensi_data[]=array("id"=>$id_comp,"anno"=>$curComp->GetAnno(),"parte_fissa"=>number_format(doubleval(str_replace(array(".",","),array("","."),$curComp->GetParteFissa())),2,",","."),"parte_variabile"=>number_format(doubleval(str_replace(array(".",","),array("","."),$curComp->GetParteVariabile())),2,",","."),"rimborsi"=>number_format(doubleval(str_replace(array(".",","),array("","."),$curComp->GetRimborsi())),2,",","."),"note"=>$curComp->GetNote(), "totale"=>$tot,"ops"=>$ops);
        }
        $compensi->SetProp("data",$compensi_data);
        if(sizeof($compensi_data) > 0) $incarico_compensi->AddRow($compensi);
        else $incarico_compensi->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        #--------------------------------------
        
        #documenti----------------------------------
        $curId=$id."_NominaDetailDocumenti";
        $incarico_documenti=new AA_JSON_Template_Layout($curId,array("type"=>"clean","css"=>array("border-left"=>"1px solid #dedede !important;")));
        
        $toolbar=new AA_JSON_Template_Toolbar($curId."_Toolbar_Documenti",array("height"=>38, "css"=>array("background"=>"#dadee0 !important;")));
        $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));

        $toolbar->AddElement(new AA_JSON_Template_Generic($curId."_Toolbar_Documenti_Title",array("view"=>"label","label"=>"<span style='color:#003380'>Documenti</span>", "align"=>"center")));

        if($canModify)
        {
            //Pulsante di aggiunta documento
            $add_documento_btn=new AA_JSON_Template_Generic($curId."_AddDocumento_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-file-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "width"=>120,
                "tooltip"=>"Aggiungi documento per l'incarico",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task: 'GetOrganismoAddNewIncaricoDocDlg', postParams: {id: ".$object->GetId().", id_incarico:".$incarico->GetId().", refresh: 1, refresh_obj_id:'".$id."'}},'$this->id')"
            ));

            $toolbar->AddElement($add_documento_btn);
        }
        else 
        {
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
        }

        $incarico_documenti->AddRow($toolbar);

        $options_documenti=array();

        if($canModify)
        {
            $options_documenti[]=array("id"=>"anno", "header"=>"Anno", "width"=>60, "css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"tipo", "header"=>"Tipo", "fillspace"=>true,"css"=>array("text-align"=>"center"));
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }
        else
        {
            $options_documenti[]=array("id"=>"anno", "header"=>"Anno", "width"=>60, "css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"tipo", "header"=>"Tipo", "fillspace"=>true,"css"=>array("text-align"=>"center"));
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }

        $documenti=new AA_JSON_Template_Generic($curId."_Documenti_Table",array("view"=>"datatable", "headerRowHeight"=>28, "select"=>true,"scrollX"=>false,"css"=>"AA_Header_DataTable","columns"=>$options_documenti));

        $documenti_data=array();
        foreach($incarico->GetDocs() as $id_doc=>$curDoc)
        {
            $modify='AA_MainApp.utils.callHandler("pdfPreview", {url: "'.$curDoc->GetPublicDocumentPath().'&embed=1"},"'.$this->id.'")';
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoTrashIncaricoDocDlg", params: [{id: "'.$object->GetId().'"},{id_incarico:"'.$incarico->GetId().'"}, {refresh: 1}, {refresh_obj_id:"'.$id.'"},{anno:"'.$curDoc->GetAnno().'"},{tipo:"'.$curDoc->GetTipologia(true).'"},{serial:"'.$curDoc->GetSerial().'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='Download' onClick='".$modify."'><span class='mdi mdi-floppy'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="<div class='AA_DataTable_Ops' style='justify-content: center'><a class='AA_DataTable_Ops_Button' title='Download' onClick='".$modify."'><span class='mdi mdi-floppy'></span></a></div>";
            $documenti_data[]=array("id"=>$id_doc,"anno"=>$curDoc->GetAnno(),"id_tipo"=>$curDoc->GetTipologia(true) ,"tipo"=>$curDoc->GetTipologia(),"ops"=>$ops);
        }
        $documenti->SetProp("data",$documenti_data);
        if(sizeof($documenti_data) > 0) $incarico_documenti->AddRow($documenti);
        else $incarico_documenti->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        #--------------------------------------
        
        //Aggiunge i compensi
        $multiview->addCell($incarico_compensi);
        
        //Aggiunge i documenti
        $multiview->AddCell($incarico_documenti);
        
        //Aggiunge compensi e documenti al body dell'elemento
        $layout->AddRow($multiview);

        return $layout;
    }

    //Template Detail
    public function TemplateSection_Detail($params)
    {
        $id=static::AA_UI_PREFIX."_Detail_";
        $organismo= new AA_Organismi($params['id'],$this->oUser);
        if(!$organismo->isValid())
        {
            return new AA_JSON_Template_Template(
                        static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX,
                        array("update_time"=>Date("Y-m-d H:i:s"),
                        "name"=>"Dettaglio scheda organismo",
                        "type"=>"clean","template"=>AA_Log::$lastErrorLog));            
        }
        
        $perms=$organismo->GetUserCaps($this->oUser);

        #Stato
        if($organismo->GetStatus() & AA_Const::AA_STATUS_BOZZA) $status="bozza";
        if($organismo->GetStatus() & AA_Const::AA_STATUS_PUBBLICATA) $status="pubblicata";
        if($organismo->GetStatus() & AA_Const::AA_STATUS_REVISIONATA) $status.=" revisionata";
        if($organismo->GetStatus() & AA_Const::AA_STATUS_CESTINATA) $status.=" cestinata";
        $status="<span class='AA_Label AA_Label_LightBlue' title='Stato scheda organismo'>".$status."</span>";
        
        #Dettagli
        if(($perms&AA_Const::AA_PERMS_PUBLISH) > 0 && $organismo->GetAggiornamento() != "")
        {
            //Aggiornamento
            $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$organismo->GetAggiornamento(true)."</span>&nbsp;";
            
            //utente e log
            $lastLog=$organismo->GetLog()->GetLastLog();
            if($lastLog['user']=="")
            {
                $lastLog['user']=$organismo->GetUser()->GetUsername();
            }

            $details.="<span class='AA_Label AA_Label_LightBlue' title=\"Nome dell'utente che ha compiuto l'ultima azione - Fai click per visualizzare il log delle azioni\"><span class='mdi mdi-account' onClick=\"AA_MainApp.utils.callHandler('dlg',{task: 'GetLogDlg', 'params': {id: ".$organismo->GetId()."}},'".$this->GetId()."');\">".$lastLog['user']."</span>&nbsp;";
            
            //id
            $details.="</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$organismo->GetId()."</span>";
        } 
        else
        {
            if($organismo->GetAggiornamento() != "") $details="<span class='AA_Label AA_Label_LightBlue' title='Data ultimo aggiornamento'><span class='mdi mdi-update'></span>&nbsp;".$organismo->GetAggiornamento(true)."</span>&nbsp;<span class='AA_Label AA_Label_LightBlue' title='Identificativo'><span class='mdi mdi-identifier'></span>&nbsp;".$organismo->GetId()."</span>";
        }

        $id_org=$organismo->GetID();
        
        if(($perms & AA_Const::AA_PERMS_WRITE) ==0) $details.="&nbsp;<span class='AA_Label AA_Label_LightBlue' title=\" L'utente corrente non può apportare modifiche all'organismo\"><span class='mdi mdi-pencil-off'></span>&nbsp; sola lettura</span>";
        
        $header=new AA_JSON_Template_Layout($id."Header"."_$id_org",array("type"=>"clean", "height"=>38,"css"=>"AA_SectionContentHeader"));
        
        $detail_options=array(array("id"=>$id."Generale_Tab"."_$id_org", "value"=>"Generale"),
        array("id"=>$id."DatiContabili_Tab"."_$id_org","value"=>"Dati contabili", "tooltip"=>"Dati contabili e dotazione organica"),
        array("id"=>$id."Nomine_Tab"."_$id_org","value"=>"Nomine"));

        //if($this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $detail_options[]=array("id"=>$id."Organigramma_Tab"."_$id_org","value"=>"Organigrammi");
        }

        if(($organismo->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $detail_options[]=array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_TEMPLATE_PARTECIPAZIONI."_".$organismo->GetId(),"value"=>"Partecipazioni");

        $header->addCol(new AA_JSON_Template_Generic($id."TabBar"."_$id_org",array(
            "view"=>"tabbar",
            "borderless"=>true,
            "value"=>$id."Generale_Tab"."_$id_org",
            "css"=>"AA_Header_TabBar",
            "width"=>600,
            "multiview"=>true,
            "view_id"=>$id."Multiview"."_$id_org",
            "options"=>$detail_options
        )));
        $header->addCol(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $header->addCol(new AA_JSON_Template_Generic($id."Detail"."_$id_org",array(
            "view"=>"template",
            "borderless"=>true,
            "css"=>"AA_SectionContentHeader",
            "minWidth"=>500,
            "template"=>"<div style='display: flex; width:100%; height: 100%; justify-content: center; align-items: center;'>#status#<span>&nbsp;&nbsp;</span><span>#detail#</span></div>",
            "data"=>array("detail"=>$details,"status"=>$status)
        )));
        
        $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar"."_$id_org",array(
            "type"=>"clean",
            "css"=>array("background"=>"#ebf0fa","border-color"=>"transparent"),
            "width"=>600
        ));
        
        //Inserisce il pulsante di pubblicazione
        if(($perms & AA_Const::AA_PERMS_PUBLISH) > 0 && ($organismo->GetStatus()&AA_Const::AA_STATUS_BOZZA) > 0 && ($organismo->GetStatus()&AA_Const::AA_STATUS_CESTINATA) == 0)
        {
            $menu_data[]= array(
                            "id"=>$this->id."_Publish"."_$id_org",
                            "value"=>"Pubblica",
                            "tooltip"=>"Pubblica l'elemento",
                            "icon"=>"mdi mdi-certificate",
                            "module_id"=>$this->id,
                            "handler"=>"sectionActionMenu.publish",
                            "handler_params"=>array("task"=>"GetOrganismoPublishDlg","object_id"=>$organismo->GetID())
                        );
        }
        
        //Inserisce il pulsante di riassegnazione ripristino
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0)
        {
            if(($organismo->GetStatus()&AA_Const::AA_STATUS_CESTINATA) == 0)
            {
                //if($menu_spacer) $menu_data[]=array("\$template"=>"Separator");
                //$menu_spacer=true;
                $menu_data[]= array(
                        "id"=>$this->id."_Reassign"."_$id_org",
                        "value"=>"Riassegna",
                        "tooltip"=>"Riassegna l'elemento",
                        "icon"=>"mdi mdi-share-all",
                        "module_id"=>$this->id,
                        "handler"=>"sectionActionMenu.reassign",
                        "handler_params"=>array("task"=>"GetOrganismoReassignDlg","object_id"=>$organismo->GetID())
                    );                
            }
            if(($organismo->GetStatus() & AA_Const::AA_STATUS_CESTINATA) > 0)
            {
                $menu_data[]= array(
                        "id"=>$id."_Resume"."_$id_org",
                        "value"=>"Ripristina",
                        "tooltip"=>"Ripristina gli elementi selezionati (tutta la lista se non ci sono elementi selezionati)",
                        "icon"=>"mdi mdi-recycle",
                        "module_id"=>$this->id,
                        "handler"=>"sectionActionMenu.resume",
                        "handler_params"=>array("task"=>"GetOrganismoResumeDlg","object_id"=>$organismo->GetID())
                    );
            }
        }
        
        //Inserisce le voci di esportazione
        //if($menu_spacer) $menu_data[]=array("\$template"=>"Separator");
        //$menu_spacer=true;
        $menu_data[]= array(
                    "id"=>$id."_SaveAsPdf"."_$id_org",
                    "value"=>"Esporta in pdf",
                    "tooltip"=>"Esporta gli elementi selezionati (tutta la lista se non ci sono elementi selezionati) come file pdf",
                    "icon"=>"mdi mdi-file-pdf",
                    "module_id"=>$this->id,
                    "handler"=>"sectionActionMenu.saveAsPdf",
                    "handler_params"=>array("task"=>"GetOrganismoSaveAsPdfDlg","object_id"=>$organismo->GetID())
                );  
        $menu_data[]= array(
                    "id"=>$id."_SaveAsCsv"."_$id_org",
                    "value"=>"Esporta in csv",
                    "tooltip"=>"Esporta gli elementi selezionati (tutta la lista se non ci sono elementi selezionati) come file csv",
                    "icon"=>"mdi mdi-file-table",
                    "module_id"=>$this->id,
                    "handler"=>"sectionActionMenu.saveAsCsv",
                    "handler_params"=>array("task"=>"GetOrganismoSaveAsCsvDlg","object_id"=>$organismo->GetID())
                );
        #-------------------------------------
        
        //Inserisce la voce di eliminazione
        if(($perms & AA_Const::AA_PERMS_DELETE) > 0)
        {
            if(($organismo->GetStatus() & AA_Const::AA_STATUS_CESTINATA) == 0)
            {
                //if($menu_spacer) $menu_data[]=array("\$template"=>"Separator");
                //$menu_spacer=true;
                
                $menu_data[]= array(
                            "id"=>$id."_Trash"."_$id_org",
                            "value"=>"Cestina",
                            "css"=>"AA_Menu_Red",
                            "tooltip"=>"Cestina l'elemento",
                            "icon"=>"mdi mdi-trash-can",
                            "module_id"=>$this->id,
                            "handler"=>"sectionActionMenu.trash",
                            "handler_params"=>array("task"=>"GetOrganismoTrashDlg","object_id"=>$organismo->GetID())
                        );
            }
            else
            {
                
                $menu_data[]= array(
                            "id"=>$id."_Delete"."_$id_org",
                            "value"=>"Elimina",
                            "css"=>"AA_Menu_Red",
                            "tooltip"=>"Elimina definitivamente l'elemento",
                            "icon"=>"mdi mdi-trash-can",
                            "module_id"=>$this->id,
                            "handler"=>"sectionActionMenu.delete",
                            "handler_params"=>array("task"=>"GetOrganismoDeleteDlg","object_id"=>$organismo->GetID())
                        );
            }
        }
        
        //Azioni
        $scriptAzioni="try{"
                . "let azioni_btn=$$('".$id."_Azioni_btn_$id_org');"
                . "if(azioni_btn){"
                . "let azioni_menu=webix.ui(azioni_btn.config.menu_data);"
                . "if(azioni_menu){"
                . "azioni_menu.setContext(azioni_btn);"
                . "azioni_menu.show(azioni_btn.\$view);"
                . "}"
                . "}"
                . "}catch(msg){console.error('".$id."_Azioni_btn_$id_org',this,msg);AA_MainApp.ui.alert(msg);}";
        $azioni_btn=new AA_JSON_Template_Generic($id."_Azioni_btn"."_$id_org",array(
            "view"=>"button",
            "type"=>"icon",
            "icon"=>"mdi mdi-dots-vertical",
            "label"=>"Azioni",
            "align"=>"right",
            "autowidth"=>true,
            "menu_data"=>new AA_JSON_Template_Generic($id."_ActionMenu"."_$id_org",array("view"=>"contextmenu","data"=>$menu_data, "module_id"=>$this->GetId(),"on"=>array("onItemClick"=>"AA_MainApp.utils.getEventHandler('onDetailMenuItemClick','".$this->GetId()."')"))),
            "tooltip"=>"Visualizza le azioni disponibili",
            "click"=>$scriptAzioni
        ));
        
        $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $toolbar->addElement($azioni_btn);
        $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>15)));
        
        $header->addCol(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $header->addCol($toolbar);
        
        //Content box
        $content = new AA_JSON_Template_Layout($id."Content_Box",
                array(
                "type"=>"clean",
                "name"=>$organismo->GetDenominazione(),
                "filtered"=>true
            ));
        $content->AddRow($header);
        
        $multiview=new AA_JSON_Template_Multiview($id."Multiview"."_$id_org",array(
            "type"=>"clean",
            "css"=>"AA_Detail_Content"
         ));
        $multiview->addCell($this->TemplateDettaglio_Generale_Tab($organismo));
        $multiview->addCell($this->TemplateDettaglio_DatiContabili_Tab($organismo));
        $multiview->addCell($this->TemplateDettaglio_Nomine_Tab($organismo));
        //if($this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $multiview->addCell($this->TemplateDettaglio_Organigramma_Tab($organismo));
        }

        $canModify=false;
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0) $canModify=true;
        if(($organismo->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $multiview->addCell($this->TemplateDettaglio_Partecipazioni_Tab($organismo,$canModify));
        
        $content->AddRow($multiview);
        
        return $content;
    }
    
    //Template section detail, tab generale
    public function TemplateDettaglio_Generale_Tab($object=null)
    {
        $id=static::AA_UI_PREFIX."_Detail_Generale_Tab_".$object->GetId();
        $rows_fixed_height=50;
        if(!($object instanceof AA_Organismi)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));
        
        $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean"));
        
        $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar",array("height"=>38));
        
        $soc_tags="";
        $soc_tags="<span class='AA_Label AA_Label_Green' title='Forma giuridica'>".$object->GetFormaSocietaria()."</span>&nbsp;";
        if($object->IsInHouse() == true) $soc_tags.="<span class='AA_Label AA_Label_Green'>in house</span>&nbsp;";
        if($object->IsInTUSP() == true) $soc_tags.="<span class='AA_Label AA_Label_Green'>TUSP</span>&nbsp;";
        if($object->IsInMercatiReg() == true) $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green'>Mercati reg.</span>";
        if($object->GetPartecipazione() == "" || $object->GetPartecipazione() == "0") $soc_tags.="<span class='AA_DataView_Tag AA_Label AA_Label_Green' title='Società non direttamente partecipata dalla RAS'>indiretta</span>";
        
        $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
        $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        
        if(($object->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $toolbar->addElement(new AA_JSON_Template_Generic($id."_SocTags",array("view"=>"label","label"=>$soc_tags, "align"=>"center")));
        
        $toolbar->addElement(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        
        //Pulsante di modifica
        $canModify=false;
        if(($object->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_WRITE) > 0) $canModify=true;
        if($canModify)
        {            
            $modify_btn=new AA_JSON_Template_Generic($id."_Modify_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-pencil",
                "label"=>"Modifica",
                "align"=>"right",
                "css"=>"webix_primary",
                "width"=>120,
                "tooltip"=>"Modifica le informazioni generali",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoModifyDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
            ));
            $toolbar->AddElement($modify_btn);
        }
        
        $layout->addRow($toolbar);

        //Piva
        $value=$object->GetPivaCf();
        if($value=="")$value="n.d.";
        $piva=new AA_JSON_Template_Template($id."_Piva",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Codice fiscale:","value"=>$value)
        ));
        
        //Sede legale
        $value=$object->GetSedeLegale();
        if($value=="")$value="n.d.";
        $sede_legale=new AA_JSON_Template_Template($id."_SedeLegale",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Sede legale:","value"=>$value)
        ));

        //Pec
        $value=$object->GetPec();
        if($value=="") $value="n.d.";
        $pec=new AA_JSON_Template_Template($id."_Pec",array(
            "gravity"=>2,
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"PEC:","value"=>$value)
        ));
        
        //Sito web
        $value="<a href='".$object->GetSitoWeb()."' target='_blank'>".$object->GetSitoWeb()."</a>";
        if($object->GetSitoWeb()=="")$value="n.d.";
        $sito=new AA_JSON_Template_Template($id."_SitoWeb",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Sito web:","value"=>$value)
        ));
        
        //Funzioni attribuite
        $value=$object->GetFunzioni();
        if($value=="")$value="n.d.";
        $funzioni=new AA_JSON_Template_Template($id."_Funzioni",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "autoheight"=>true,
            "data"=>array("title"=>"Funzioni attribuite:","value"=>nl2br($value))
        ));
        
        //data inizio
        $value=$object->GetDataInizioImpegno();
        if($value=="0000-00-00") $value="n.d.";
        $data_inizio=new AA_JSON_Template_Template($id."_DataInizio",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Data inizio impegno:","value"=>$value)
        ));
        
        //data costituzione
        $value=$object->GetDataInizioImpegno();
        if($value=="0000-00-00") $value="n.d.";
        $data_costituzione=new AA_JSON_Template_Template($id."_DataInizio",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Data costituzione:","value"=>$value)
        ));    

        //data fine
        $value=$object->GetDataFineImpegno();
        if($value=="0000-00-00") $value="n.d.";
        if($value=="9999-12-31") $value="a tempo indeterminato";
        $data_fine=new AA_JSON_Template_Template($id."_DataFine",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Data fine impegno:","value"=>$value)
        ));
        
        //data cessazione
        $value=$object->GetDataFineImpegno();
        if($value=="0000-00-00") $value="n.d.";
        if($value=="9999-12-31") $value="a tempo indeterminato";
        $data_cessazione=new AA_JSON_Template_Template($id."_DataFine",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Data cessazione:","value"=>$value)
        ));
        
        //partecipazione
        $value=$object->GetPartecipazione(true);
        if($value['percentuale']==0) $value="nessuna";
        else
        {
            $value="€ ".AA_Utils::number_format($value['euro'],2,",",".")." pari al ".AA_Utils::number_format($value['percentuale'],2,",",".")."% delle quote totali";
        }
        $partecipazione=new AA_JSON_Template_Template($id."_Partecipazione",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Partecipazione diretta RAS:","value"=>$value)
        ));

        //partecipazione indiretta
        $value=$object->GetPartecipazioneIndiretta($this->oUser);
        if($value['percentuale']==0) $value="nessuna";
        else
        {
            $value=AA_Utils::number_format($value['percentuale'],2,",",".")."% per un totale di € ".AA_Utils::number_format($value['euro'],2,",",".");
        }
        $partecipazione_indiretta=new AA_JSON_Template_Template("",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Partecipazione indiretta RAS:","value"=>$value)
        ));
        
        //Stato
        $value=$object->GetStatoOrganismo();
        if($value=="")$value="n.d.";
        $stato_società=new AA_JSON_Template_Template($id."_Stato",array(
            "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
            "data"=>array("title"=>"Stato società:","value"=>$value)
        ));        
        
        //note
        $value=$object->GetNote();
        if($value=="")$value="n.d.";
        $note=new AA_JSON_Template_Template($id."_Note",array(
            "template"=>"<span style='font-weight:700'>#title#</span><div>#value#</div>",
            "data"=>array("title"=>"Note:","value"=>nl2br($value))
        ));
        
        //Prima riga
        $riga=new AA_JSON_Template_Layout($id."_FirstRow",array("height"=>$rows_fixed_height,"css"=>array("border-top"=>"1px solid #dadee0 !important")));
        $riga->AddCol($piva);
        if(($object->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $riga->AddCol($data_inizio);
        else $riga->AddCol($data_costituzione);
        $layout->AddRow($riga);
        
        //seconda riga
        $riga=new AA_JSON_Template_Layout($id."_SecondRow",array("height"=>$rows_fixed_height));
        $riga->AddCol($sede_legale);
        if(($object->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $riga->AddCol($data_fine);
        else $riga->AddCol($data_cessazione);
        $layout->AddRow($riga);
        
        //terza riga
        $riga=new AA_JSON_Template_Layout($id."_ThirdRow",array("height"=>$rows_fixed_height));
        $riga->AddCol($pec);
        if(($object->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) 
        {
            $riga->AddCol($partecipazione);
            $riga->AddCol($partecipazione_indiretta);
        }
        else $riga->AddCol(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $layout->AddRow($riga);
        
        //Quarta riga
        $riga=new AA_JSON_Template_Layout($id."_FourRow",array("height"=>$rows_fixed_height));
        $riga->AddCol($sito);
        if(($object->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $riga->AddCol($stato_società);
        else $riga->AddCol(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $layout->AddRow($riga);
        
        //layout ultima riga
        $last_row=new AA_JSON_Template_Layout($id."_LastRow");
        $riga=new AA_JSON_Template_Layout($id."_FiveRow",array("css"=>array("border-top"=>"1px solid #dadee0 !important")));
        
        //funzioni
        $box=new AA_JSON_Template_Generic($id."_funzioni_box",array("view"=>"scrollview","scroll"=>"y","autoheight"=>true,"body"=>$funzioni));
        $riga->AddRow($box);
        
        //note
        $box=new AA_JSON_Template_Generic($id."_note_box",array("view"=>"scrollview","scroll"=>"y","autoheight"=>true,"body"=>$note));
        $riga->AddRow($box);
        
        $last_row->AddCol($riga);
        
        //partecipazioni
        //if(($object->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $last_row->AddCol($this->TemplateDettaglio_Partecipazioni($object, $canModify));

        //documenti
        $last_row->AddCol($this->TemplateDettaglio_Provvedimenti($object, $id, $canModify));
        
        $layout->AddRow($last_row);
        
        return $layout;
    }
    
    //Template section detail, tab dati contabili
    public function TemplateDettaglio_DatiContabili_Tab($object=null)
    {
        $id=static::AA_UI_PREFIX."_Detail_DatiContabili_Tab_".$object->GetID();
        if(!($object instanceof AA_Organismi)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));
        
        //flag società
        if(($object->GetTipologia(true)&AA_Organismi_Const::AA_ORGANISMI_SOCIETA_PARTECIPATA) > 0) $società=true;
        else $società=false;
        
        //righe con altezza imposta
        $rows_fixed_height=50;
        
        //permessi
        $perms = $object->GetUserCaps($this->oUser);
        $canModify=false;
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0) $canModify=true;
        
        //layout generale
        $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean"));
        
        $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar",array("height"=>38,"width"=>130));
        
        if($canModify)
        {            
            //Pulsante di Aggiunta dato contabile
            $addnew_btn=new AA_JSON_Template_Generic($id."_AddNew_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-pencil-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "css"=>"webix_primary",
                "width"=>120,
                "tooltip"=>"Aggiungi annualità",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoAddNewDatoContabileDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
            ));
            $toolbar->AddElement($addnew_btn);
        }
        else
        {
            $toolbar->AddElement(new AA_JSON_Template_Generic(""));
        }
        
        $header=new AA_JSON_Template_Layout($id."_Header",array("type"=>"clean", "height"=>38, "css"=>"AA_SectionContentHeader"));

        $dati_contabili=$object->GetDatiContabili();
        if(sizeof($dati_contabili) > 0)
        {
            $tabbar=new AA_JSON_Template_Generic($id."_TabBar",array(
                "view"=>"tabbar",
                "borderless"=>true,
                "css"=>"AA_Bottom_TabBar",
                "multiview"=>true,
                "optionWidth"=>100,
                "view_id"=>$id."_Multiview",
                "type"=>"bottom"
            ));
            
            $header->AddCol($tabbar);
            
            $multiview=new AA_JSON_Template_Multiview($id."_Multiview",array(
                "type"=>"clean",
                "css"=>"AA_Detail_Content"
            ));
        }
        else
        {
            $multiview=new AA_JSON_Template_Template($id."_Multiview",array(
                "type"=>"clean",
                "css"=>"AA_Detail_Content",
                "template"=>"<div style='display: flex; justify-content: center; align-items:center; flex-direction: column; font-weight: 400; height: 100%'><p>Non sono presenti annualità.</p><p>Fai click sul pulsante 'Aggiungi' in basso a destra per aggiungerne una.</p></div>"
             ));
        }
        
        $header->AddCol(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $header->AddCol($toolbar);

        $layout->AddRow($multiview);
        $layout->addRow($header);
        
        //Aggiunge gli anni come tab
        $options=array();
        foreach($dati_contabili as $idDato=>$curDato)
        {
            $anno=$curDato->GetAnno();
            if($curDato->IsInGap()) 
            {
                $gap="*";
                $gap_label="<span class='AA_Label AA_Label_LightYellow' title='Stato scheda organismo'>GAP</span>";
            }
            else 
            {
                $gap="";
                $gap_label="";
            }
            
            if($curDato->IsInGbc()) 
            {
                $gbc="*";
                $gbc_label="<span class='AA_Label AA_Label_LightYellow' title='Stato scheda organismo'>GBC</span>";
            }
            else 
            {
                $gbc=$gbc_label="";
            }

            if($canModify) $label="<div style='display: flex; justify-content: space-between; align-items: center; padding-left: 5px; padding-right: 5px;'><span>".$anno.$gap.$gbc."</span><a style='margin-left: 1em;' class='AA_DataTable_Ops_Button_Red' title='Elimina annualità' onClick='".'AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoTrashDatoContabileDlg", params: [{id: "'.$object->GetId().'"},{id_dato_contabile:"'.$curDato->GetId().'"}]},"'.$this->id.'")'."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $label="<div style='display: flex; justify-content: center; align-items: center; padding-left: 5px; padding-right: 5px;'><span>".$anno.$gap.$gbc."</span></div>";
            $options[]=array("id"=>$id."_".$curDato->GetID()."_Tab", "id_rec"=>$idDato, "value"=>$label);
            
            $curAnno=new AA_JSON_Template_Layout($id."_".$curDato->GetID()."_Tab",array("type"=>"clean"));
            
            $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar_".$idDato,array("height"=>38, "css"=>"AA_Header_Tabbar_Title"));
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
            $toolbar->AddElement(new AA_JSON_Template_Generic($id."_Toolbar_".$curDato->GetID()."_Label",array("view"=>"label","label"=>"<span style='color:#003380'>Dati contabili e dotazione organica - anno ".$anno." ".$gap_label." ".$gbc_label."</span>", "align"=>"center")));
                
            //Pulsante di Modifica dato contabile
            if($canModify)
            {
                $modify_btn=new AA_JSON_Template_Generic($id."_Modify_".$curDato->GetID()."_btn",array(
                   "view"=>"button",
                    "type"=>"icon",
                    "icon"=>"mdi mdi-pencil",
                    "label"=>"Modifica",
                    "css"=>"webix_primary",
                    "align"=>"right",
                    "width"=>120,
                    "tooltip"=>"Modifica dati contabili e dotazione organica per l'anno ".$anno,
                    "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoModifyDatoContabileDlg\", params: [{id: ".$object->GetId()."},{id_dato_contabile:".$curDato->GetId()."}]},'$this->id')"
                ));                
                $toolbar->AddElement($modify_btn);
            }
            else
            {
                $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
            }
            
            $curAnno->AddRow($toolbar);
            
            //Oneri totali
            $value=$curDato->GetOneriTotali();
            if($value=="")$value="n.d.";
            else $value="€ ".number_format(floatVal(str_replace(array(".",","),array("","."),$value)),2,",",".");
            $val1=new AA_JSON_Template_Template($id."_OneriTotali_".$curDato->GetID(),array(
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Oneri totali:","value"=>$value)
            ));

            //Dotazione organica
            $value=$curDato->GetDotazioneOrganica();
            if($value=="") $value="n.d.";
            $val2=new AA_JSON_Template_Template($id."_DotazioneOrganica_".$curDato->GetID(),array(
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Dotazione organica:","value"=>$value)
            ));
            
            //Prima riga
            $riga=new AA_JSON_Template_Layout($id."_FirstRow_".$curDato->GetID(),array("height"=>$rows_fixed_height));
            $riga->AddCol($val1);$riga->AddCol($val2);
            $curAnno->AddRow($riga);
            
            //Spesa lavoro flessibile
            $value=$curDato->GetSpesaLavoroFlessibile();
            if($value=="")$value="n.d.";
            else $value="€ ".number_format(floatVal(str_replace(array(".",","),array("","."),$value)),2,",",".");
            $val1=new AA_JSON_Template_Template($id."_SpesaLavoroFlessibile_".$curDato->GetID(),array(
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Spesa lavoro flessibile:","value"=>$value)
            ));

            //Dipendenti
            $value=intVal($curDato->GetDipendenti());
            $value2=intVal($curDato->GetDipendentiDir());
            if($value+$value2 == 0)$value="n.d.";
            if($value2 > 0)
            {
                $value=($value+$value2)." di cui ".$value2." dirigenti";
            }
            $val2=new AA_JSON_Template_Template($id."_Dipendenti_".$curDato->GetID(),array(
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Personale assunto a tempo indeterminato:","value"=>$value)
            ));

            // riga
            $riga=new AA_JSON_Template_Layout($id."_SecondRow_".$curDato->GetID(),array("height"=>$rows_fixed_height));
            $riga->AddCol($val1);$riga->AddCol($val2);
            $curAnno->AddRow($riga);


            //spesa incarichi
            $value=$curDato->GetSpesaIncarichi();
            if($value=="")$value="n.d.";
            else $value="€ ".number_format(floatVal(str_replace(array(".",","),array("","."),$value)),2,",",".");
            $val1=new AA_JSON_Template_Template($id."_SpesaIncarichi_".$curDato->GetID(),array(
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Spesa incarichi:","value"=>$value)
            ));

            #Dipendenti a tempo
            $value=intVal($curDato->GetDipendentiDet());
            $value2=intVal($curDato->GetDipendentiDetDir());
            if($value+$value2 == 0)$value="n.d.";
            if($value2 > 0)
            {
                $value=($value+$value2)." di cui ".$value2." dirigenti";
            }
            $val2=new AA_JSON_Template_Template($id."_DipendentiDet_".$curDato->GetID(),array(
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Personale assunto a tempo determinato:","value"=>$value)
            ));          

            //riga
            $riga=new AA_JSON_Template_Layout($id."_FourRow_".$curDato->GetID(),array("height"=>$rows_fixed_height));
            $riga->AddCol($val1);$riga->AddCol($val2);
            $curAnno->AddRow($riga);

            #Fatturato
            if($società)
            {
                $value=$curDato->GetFatturato();
                if($value=="")$value="n.d.";
                else $value="€ ".number_format(floatVal(str_replace(array(".",","),array("","."),$value)),2,",",".");
                $val1=new AA_JSON_Template_Template($id."_Fatturato_".$curDato->GetID(),array(
                    "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                    "data"=>array("title"=>"Fatturato:","value"=>$value)
                ));
            }
            else
            {
                $val1 = new AA_JSON_Template_Generic("",array("view"=>"spacer"));
            }
            
            //Spesa dotazione 
            $value=$curDato->GetSpesaDotazioneOrganica();
            if($value=="") $value="n.d.";
            else $value="€ ".number_format(floatVal(str_replace(array(".",","),array("","."),$value)),2,",",".");
            $val2=new AA_JSON_Template_Template($id."_SpesaDotazione_".$curDato->GetID(),array(
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Spesa dotazione organica:","value"=>$value)
            ));

            //riga
            $riga=new AA_JSON_Template_Layout($id."_FiveRow_".$curDato->GetID(),array("height"=>$rows_fixed_height));           
            $riga->AddCol($val1);$riga->AddCol($val2);
            $curAnno->AddRow($riga);
            
            //note
            $value=$curDato->GetNote();
            $val1=new AA_JSON_Template_Template($id."_Note_".$curDato->GetID(),array("height"=>60,
                "template"=>"<span style='font-weight:700'>#title#</span><br><span>#value#</span>",
                "data"=>array("title"=>"Note:","value"=>$value)
            ));

            $riga=new AA_JSON_Template_Layout($id."_SixRow_".$curDato->GetID(), array("css"=>array("border-top"=>"1px solid #dadee0 !important")));
            $riga->AddCol($val1);
            $curAnno->AddRow($riga);

            //if($curDato->IsInGap()) $curAnno->AddRow(new AA_JSON_Template_Template($id."_Gap",array("template"=>"<span>*Il presente organismo fa parte del gap per l'anno $anno</span>","height"=>22)));
            
            #bilanci----------------------------------
           
            $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar_Bilanci_".$curDato->GetID(),array("height"=>38, "css"=>array("background"=>"#dadee0 !important;")));
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));

            $toolbar->AddElement(new AA_JSON_Template_Generic($id."_Toolbar_Bilanci_Title_".$curDato->GetID(),array("view"=>"label","label"=>"<span style='color:#003380'>Bilanci e risultati di amministrazione - anno ".$anno."</span>", "align"=>"center")));

            if($canModify)
            {
                //Pulsante di aggiunta bilancio
                $add_bilancio_btn=new AA_JSON_Template_Generic($id."_AddBilancio_".$curDato->GetID()."_btn",array(
                   "view"=>"button",
                    "type"=>"icon",
                    "icon"=>"mdi mdi-pencil-plus",
                    "label"=>"Aggiungi",
                    "align"=>"right",
                    "width"=>120,
                    "tooltip"=>"Aggiungi bilancio per l'anno ".$anno,
                    "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoAddNewBilancioDlg\", params: [{id: ".$object->GetId()."},{id_dato_contabile:".$curDato->GetId()."}]},'$this->id')"
                ));

                $toolbar->AddElement($add_bilancio_btn);
            }
            else 
            {
                $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
            }
            
            $curAnno->AddRow($toolbar);
            
            $options_bilanci=array();
            
            if($canModify)
            {
                $options_bilanci[]=array("id"=>"tipo", "header"=>"Tipo di bilancio", "width"=>250, "css"=>array("text-align"=>"left"));
                $options_bilanci[]=array("id"=>"risultati", "header"=>"Risultati in €", "width"=>350,"css"=>array("text-align"=>"center"));
                $options_bilanci[]=array("id"=>"note", "header"=>"note", "fillspace"=>true,"css"=>array("text-align"=>"left"));
                $options_bilanci[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
            }
            else
            {
                $options_bilanci[]=array("id"=>"tipo", "header"=>"Tipo di bilancio", "width"=>250, "css"=>array("text-align"=>"left"));
                $options_bilanci[]=array("id"=>"risultati", "header"=>"Risultati in €", "width"=>350,"css"=>array("text-align"=>"center"));
                $options_bilanci[]=array("id"=>"note", "header"=>"note", "fillspace"=>true,"css"=>array("text-align"=>"left"));                
            }
            
            $bilanci=new AA_JSON_Template_Generic($id."_Bilanci_".$curDato->GetID(),array("view"=>"datatable", "scrollX"=>false, "select"=>true,"css"=>"AA_Header_DataTable","headerRowHeight"=>28,"columns"=>$options_bilanci));
            
            $bilanci_data=array();
            foreach($curDato->GetBilanci($this->oUser) as $id_bil=>$curBil)
            {
                $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoModifyBilancioDlg", params: [{id: "'.$object->GetId().'"},{id_dato_contabile:"'.$curDato->GetId().'"},{id_bilancio:"'.$curBil->GetId().'"}]},"'.$this->id.'")';
                $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoTrashBilancioDlg", params: [{id: "'.$object->GetId().'"},{id_dato_contabile:"'.$curDato->GetId().'"},{id_bilancio:"'.$curBil->GetId().'"}]},"'.$this->id.'")';
                $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
                $bilanci_data[]=array("id"=>$curBil->GetId(),"id_tipo"=>$curBil->GetTipo(),"id_dato_contabile"=>$curDato->GetID(),"id_organismo"=>$object->GetID(),"tipo"=>$curBil->GetTipo(),"risultati"=>$curBil->GetRisultati(),"note"=>$curBil->GetNote(),"ops"=>$ops);
            }
            $bilanci->SetProp("data",$bilanci_data);
            if(sizeof($bilanci_data) > 0) 
            {
                //AA_Log::Log(__METHOD__." Aggiungo il bilancio: ".print_r($bilanci,true),100);
                $curAnno->AddRow($bilanci);
            }
            else $curAnno->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
            #--------------------------------------
            
            
            //$multiview->AddCell(new AA_JSON_Template_Generic($id."_ScrollView_".$curDato->GetID()."_Tab",array("view"=>"scrollview","scroll"=>"y","body"=>$curAnno)));
            $multiview->AddCell($curAnno);
        }
        
        if(isset($tabbar)) $tabbar->SetProp("options",$options);
        
        return $layout;
    }
    
    //Template section detail, tab nomina
    public function TemplateDettaglio_Nomine_Tab($object=null,$filterData="")
    {
        $id=static::AA_UI_PREFIX."_Detail_Nomine_Tab_".$object->GetID();
        if(!($object instanceof AA_Organismi)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));
        
        //permessi
        $perms = $object->GetUserCaps($this->oUser);
        $canModify=false;
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0) $canModify=true;
        
        //layout generale
        $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean"));

        //Recupera le nomine
        $filter= AA_SessionVar::Get($id);
        if($filter->isValid())
        {
            $params=(array)$filter->GetValue();
            //AA_Log::Log(__METHOD__." - ".print_r($params,true),100);
        }
        $nomine=$object->GetNomineGrouped($params);
        #--------------------------------
        
        //AA_Log::Log(__METHOD__.print_r($nomine,true),100);

        //Data odierna
        $now = Date("Y-m-d");
        $riepilogo_data=array();

        foreach($nomine as $id_intestazione_nomine=>$curNomine)
        {
            $riepilogo_data_item=array();

            foreach($curNomine as $curNomina)
            {
                $riepilogo_data_item['nome']=trim($curNomina->GetNome());
                $riepilogo_data_item['cognome']=trim($curNomina->GetCognome());
                $riepilogo_data_item['cf']="";

                if(trim($curNomina->GetCodiceFiscale()) !="") $riepilogo_data_item['cf']=trim($curNomina->GetCodiceFiscale());
                
                //dati incarichi per riepilogo
                $riepilogo_incarico_label="<div style='display:flex;flex-direction: column; align-items:center'><b>".$curNomina->GetTipologia()."</b></div>";
                $scaduto=false;
                if($curNomina->GetDataFine()< $now) $scaduto=true;

                $facenteFunzione=$curNomina->IsFacenteFunzione();
                
                $dataScadenza=$curNomina->GetDataFine();
                $dataInizio=$curNomina->GetDataInizio();
                $ras=$curNomina->IsNominaRas();
                $tempo_indeterminato=false;
                if($dataScadenza == "9999-12-31" || $facenteFunzione) $tempo_indeterminato=true;
            
                $riepilogo_incarico_label.="<div style='display:flex;align-items:center;flex-direction:column'>";
                if($ras) $riepilogo_incarico_label.="<span style='font-size: smaller;'>nomina RAS</span>";
            
                if($scaduto && !$facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>cessato il: ".$dataScadenza."</span>";
                if(!$scaduto && !$tempo_indeterminato && !$facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>cessa il: ".$dataScadenza."</span>";
                if($facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>facente funzione</span><br/><span style='font-size: smaller;'>dal: ".$dataInizio."</span>";
                if($tempo_indeterminato && !$facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>a tempo indeterminato</span>";
                $riepilogo_incarico_label.="</div>";

                if($ras) $labelTheme="AA_Label_LightGreen";
                else $labelTheme="AA_Label_LightBlue";
                if($scaduto) $labelTheme="AA_Label_LightRed";
                if($facenteFunzione) $labelTheme="AA_Label_LightYellow";
                if($curNomina->IsStorico())  $labelTheme="AA_Label_LightGray";

                $onClick="AA_MainApp.curModule.setRuntimeValue('".static::AA_UI_PREFIX."_".static::AA_UI_WND_NOMINA_DETAIL."_".static::AA_UI_LAYOUT_NOMINA_DETAIL."', 'filter_data', {id:".$object->GetId().",id_incarico:".$curNomina->GetId()."});AA_MainApp.utils.callHandler('dlg', {task:'GetOrganismoNominaDetailViewDlg', postParams: {id: ".$object->GetId().",id_incarico:".$curNomina->GetId()."},module: '" . $this->id . "'},'".$this->id."')";
                $riepilogo_data_item['incarichi'].="<div onclick=\"".$onClick."\" class='AA_Label $labelTheme' style='display:flex;justify-content:space-between; align-items:center; flex-direction:column; text-align: center; margin-right: 5px;min-width: 220px'>".$riepilogo_incarico_label."</div>";
                //-------------------------
            }

            if($canModify) 
            {
                if($riepilogo_data_item)
                {
                    $ids=array_keys($curNomine);
                    $riepilogo_data_item['ids']=implode(",",$ids);
                    $riepilogo_data_item['addNew']='<a title="Aggiungi un nuovo incarico" onclick=\'AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoAddNewIncaricoDlg", postParams: {id: "'.$object->GetID().'",nome: "'.$curNomina->GetNome().'",cognome: "'.$curNomina->GetCognome().'",cf: "'.$curNomina->GetCodiceFiscale().'", refresh:1, detail:1}},"'.$this->id.'")\' class="AA_Button_Link" style="width: 90px"><span class="mdi mdi-pencil-plus">&nbsp;<span>Aggiungi</span></a>';
                    $riepilogo_data_item['deleteAll']='<a title="Elimina tutti gli incarichi" onclick=\'AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoTrashNominaDlg", postParams: {ids: "'.json_encode($ids).'",id: "'.$object->GetID().'"}},"'.$this->id.'")\' class="AA_Button_Link_Red" style="width: 20px"><span class="mdi mdi-trash-can"></span></a>';
                }
            }
            else 
            {
                $riepilogo_data_item['ids']='';
                $riepilogo_data_item['deleteAll']="&nbsp;";
                $riepilogo_data_item['addNew']="&nbsp;";
            }

            if(!empty($riepilogo_data_item)) $riepilogo_data[]=$riepilogo_data_item;
        }

        //Riepilogo tab
        $riepilogo_layout=$this->TemplateDettaglio_Nomine_Riepilogo_Tab($object,$id, $riepilogo_data, $id);
        
        $layout->AddRow($riepilogo_layout);

        return $layout;
    }
    
    //Template section detail, tab nomina
    public function TemplateDettaglio_Organigramma_Tab($object=null,$filterData="")
    {
        $id=static::AA_UI_PREFIX."_Detail_Organigramma_Tab_".$object->GetID();
        if(!($object instanceof AA_Organismi)) return new AA_JSON_Template_Template($id,array("template"=>"Dati non validi"));
        
        //permessi
        $perms = $object->GetUserCaps($this->oUser);
        $canModify=false;
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0 && $this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN)) $canModify=true;
        
        //layout generale
        $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean"));
        
        $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar",array("height"=>38,"borderless"=>true,"width"=>130));
        $toolbar->AddElement(new AA_JSON_Template_Generic());

        if($canModify)
        {            
            //Pulsante di Aggiunta organigramma
            $addnew_btn=new AA_JSON_Template_Generic($id."_AddNew_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-account-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "width"=>120,
                "tooltip"=>"Aggiungi organigramma",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoAddNewOrganigrammaDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
            ));
            
            //pulsante di filtraggio
            $saveFilterId=$id;
            $filterDlgTask="GetOrganismiOrganigrammaFilterDlg";
            $filterClickAction= "try{module=AA_MainApp.getModule('".$this->id."'); if(module.isValid()){module.ui.dlg('".$filterDlgTask."',module.getRuntimeValue(".$saveFilterId.",'filter_data'),'".$this->id."')}}catch(msg){console.error(msg)}";

            $filter_btn = new AA_JSON_Template_Generic($id."_Filter_btn",array(
                "view"=>"button",
                "align"=>"right",
                "type"=>"icon",
                "icon"=>"mdi mdi-filter",
                "label"=>"Filtra",
                "width"=>80,
                "filter_data"=>$filterData,
                "tooltip"=>"Imposta un filtro di ricerca",
                "click"=>$filterClickAction
            ));
            if($this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN)) $toolbar->AddElement($addnew_btn);
        }
        
        $footer=new AA_JSON_Template_Layout($id."_Footer",array("type"=>"clean", "height"=>38, "css"=>"AA_SectionContentHeader"));
        
        $tabbar=new AA_JSON_Template_Generic($id."_TabBar",array(
            "view"=>"tabbar",
            "borderless"=>true,
            "css"=>"AA_Bottom_TabBar",
            "multiview"=>true,
            "optionWidth"=>150,
            "view_id"=>$id."_Multiview",
            "type"=>"bottom"
        ));
        
        $footer->AddCol($tabbar);
        //$header->AddCol(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $footer->AddCol($toolbar);
        
        $multiview=new AA_JSON_Template_Multiview($id."_Multiview",array(
            "type"=>"clean",
            "css"=>"AA_Detail_Content"
         ));
        $layout->AddRow($multiview);
        $layout->addRow($footer);
        
        //Recupera gli organigrammi
        $riepilogo_layout_id=$id."_Riepilogo_Layout";
        $filter= AA_SessionVar::Get($id);
        if($filter->isValid())
        {
            $params=(array)$filter->GetValue();
            //AA_Log::Log(__METHOD__." - ".print_r($params,true),100);
        }
        $organigrammi=$object->GetOrganigrammi($params);
        #--------------------------------
        
        //AA_Log::Log(__METHOD__.print_r($nomine,true),100);
        
        $options=array();
        
        //Data odierna
        $now = Date("Y-m-d");
        
        //nomine
        if(sizeof($organigrammi) > 0)
        {
            $nomine=$object->GetNomineGroupedForOrganigramma();
            $nomine_index=array();
            //AA_Log::Log(__METHOD__.print_r($nomine,true),100);    
        }

        foreach($organigrammi as $id_organigramma=>$curOrganigramma)
        {
            //Resetta l'idice dell'assegnazione delle nomine
            $nomine_index=array();

            //Dati riepilogo
            $riepilogo_data_item=array("tipo"=>$curOrganigramma->GetTipologia(),"scadenzario"=>"<span class='AA_DataView_ItemSubTitle AA_Label AA_Label_LightRed'>Escluso dallo scadenzario</span>");
            if($curOrganigramma->IsScadenzarioEnabled()) $riepilogo_data_item['scadenzario']="<span class='AA_DataView_ItemSubTitle AA_Label AA_Label_LightGreen'>incluso nello scadenzario</span>";

            $tab_label=$curOrganigramma->GetTipologia();
            if($canModify) $tab_label="<div style='display: flex; justify-content: space-between; align-items: center; padding-left: 5px; padding-right: 5px; font-size: smaller'><span>".$tab_label."</span><a style='margin-left: 1em;' class='AA_DataTable_Ops_Button_Red' title='Elimina organigramma' onClick='".'AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoDeleteOrganigrammaDlg", params: [{id_organigramma: "'.$curOrganigramma->GetProp("id").'"},{id: "'.$object->GetID().'"}]},"'.$this->id.'")'."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $tab_label="<div style='display: flex; justify-content: center; align-items: center; padding-left: 5px; padding-right: 5px; font-size: smaller'><span>".$tab_label."</span></div>";
           
            //Tab label
            $options[]=array("id"=>$id."_".$curOrganigramma->GetProp("id")."_Tab", "value"=>$tab_label);
            
            $curOrganigrammaTab=new AA_JSON_Template_Layout($id."_".$curOrganigramma->GetProp("id")."_Tab",array("type"=>"clean"));
            
            $toolbar=new AA_JSON_Template_Toolbar($id."_Toolbar_".$curOrganigramma->GetProp("id"),array("height"=>42, "css"=>"AA_Header_Tabbar_Title"));
            
            //torna al riepilogo
            $toolbar->AddElement(new AA_JSON_Template_Generic($id."_Riepilogo_".$curOrganigramma->GetProp("id")."_btn",array(
                   "view"=>"button",
                    "type"=>"icon",
                    "icon"=>"mdi mdi-keyboard-backspace",
                    "label"=>"Riepilogo",
                    "align"=>"left",
                    "width"=>120,
                    "tooltip"=>"Torna al riepilogo",
                    "click"=>"$$('".$tabbar->GetId()."').setValue('".$riepilogo_layout_id."')"
                )));
            
            //$toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
            
            //Organigramma label
            $organigramma_label="<div style='display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;'><span style='color:#003380; font-weight: 900; font-size: larger;'>".$curOrganigramma->GetTipologia()."</span>";
            $organigramma_label.="</div>";
            $toolbar->AddElement(new AA_JSON_Template_Template($id."_Toolbar_".$curOrganigramma->GetProp("id")."_Label",array("type"=>"clean","template"=>$organigramma_label)));
                
            //Pulsante di Aggiunta/modifica
            if($canModify)
            {
                $addnew_btn=new AA_JSON_Template_Generic($id."_ModifyOrganigramma_".$curOrganigramma->GetProp("id")."_btn",array(
                   "view"=>"button",
                    "type"=>"icon",
                    "icon"=>"mdi mdi-pencil-plus",
                    "label"=>"Aggiungi",
                    "align"=>"right",
                    "width"=>120,
                    "tooltip"=>"Aggiungi un nuovo incarico all'organigramma",
                    "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoAddNewOrganigrammaIncaricoDlg\", params: [{id: ".$object->GetId()."},{id_organigramma:\"".$curOrganigramma->GetProp("id")."\"}]},'$this->id')"
                ));
                
                $modify_btn=new AA_JSON_Template_Generic($id."_Organigramma_Modify_".$curOrganigramma->GetProp("id")."_btn",array(
                   "view"=>"button",
                    "type"=>"icon",
                    "icon"=>"mdi mdi-pencil",
                    "label"=>"Modifica",
                    "align"=>"right",
                    "width"=>120,
                    "tooltip"=>"Modifica i dati dell'organigramma",
                    "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoModifyOrganigrammaDlg\", params: [{id: ".$object->GetId()."},{id_organigramma:".$curOrganigramma->GetProp("id")."}]},'$this->id')"
                ));
                //$toolbar->AddElement($addnew_btn);
                $toolbar->AddElement($modify_btn);
            }
            else
            {
                $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
            }
            
            $curOrganigrammaTab->AddRow($toolbar);

            $content_layout=new AA_JSON_Template_Layout($id."_Box_layout_".$id_organigramma,array());
            $left=new AA_JSON_Template_Layout($id."_Box_layout_LeftPanel_".$id_organigramma,array());
            $toolbar_left=new AA_JSON_Template_Toolbar($id."_Toolbar_Left_".$id_organigramma,array("height"=>42, "css"=>"AA_Header_Tabbar_Title"));

            //scadenzario
            $scadenzario_label="<span class='AA_Label AA_Label_LightGreen'>Si</span>&nbsp;";
            if(!$curOrganigramma->IsScadenzarioEnabled())$scadenzario_label="<span class='AA_Label AA_Label_LightRed'>No</span>&nbsp;";
            $toolbar_left->AddElement(new AA_JSON_Template_Template($id."_Enable_Scadenzario_".$id_organigramma,array("type"=>"clean", "width"=>210,"template"=>"<div style='margin-top: 2px; padding-left: .7em; border-right: 1px solid #dedede;'><span style='font-weight: 700;'>Includi nello scadenzario: </span><br>$scadenzario_label</div>")));
            $left->addRow($toolbar_left);
            
            $left->addRow(new AA_JSON_Template_Template($id."_Note_".$id_organigramma,array("template"=>"#note#","data"=>array("note"=>nl2br($curOrganigramma->GetProp("note"))))));
            
            $content_layout->addCol($left);

            #incarichi----------------------------------
            $curId=$id."_Organigramma_".$curOrganigramma->GetId()."_Incarichi";
            $incarichi_box=new AA_JSON_Template_Layout($curId."_Box",array("type"=>"clean","css"=>array("border-right"=>"1px solid #dedede !important;")));

            $toolbar=new AA_JSON_Template_Toolbar($curId."_Toolbar_Incarichi",array("height"=>38, "css"=>array("background"=>"#dadee0 !important;")));
            $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
            $toolbar->AddElement(new AA_JSON_Template_Generic($curId."_Toolbar_Incarichi_Title",array("view"=>"label","label"=>"<span style='color:#003380'>Incarichi</span>", "align"=>"center")));

            if($canModify)
            {
                //Pulsante di aggiunta incarico organigramma
                $add_incarico_btn=new AA_JSON_Template_Generic($curId."_AddIncarico_btn",array(
                   "view"=>"button",
                    "type"=>"icon",
                    "icon"=>"mdi mdi-pencil-plus",
                    "label"=>"Aggiungi",
                    "align"=>"right",
                    "width"=>120,
                    "tooltip"=>"Aggiungi un incarico all'organigramma",
                    "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoAddNewOrganigrammaIncaricoDlg\", params: [{id: ".$object->GetId()."},{id_organigramma:".$curOrganigramma->GetProp("id")."}]},'$this->id')"
                ));

                $toolbar->AddElement($add_incarico_btn);
            }
            else 
            {
                $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));
            }

            $incarichi_box->AddRow($toolbar);

            //Tabella incarichi
            $options_incarichi=array();
            if($canModify)
            {
                $options_incarichi[]=array("id"=>"tipo", "header"=>"Tipo", "width"=>250, "css"=>array("text-align"=>"left"));
                $options_incarichi[]=array("id"=>"ras", "header"=>"Ras", "width"=>90,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"opzionale", "header"=>"Opzionale", "width"=>90,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"forza_scadenzario", "header"=>"Scadenzario", "width"=>100,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"compenso_spettante", "header"=>"Compenso s.", "width"=>100,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"note", "header"=>"Note", "fillspace"=>true,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
            }
            else
            {
                $options_incarichi[]=array("id"=>"tipo", "header"=>"Tipo", "width"=>250, "css"=>array("text-align"=>"left"));
                $options_incarichi[]=array("id"=>"ras", "header"=>"Ras", "width"=>50,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"opzionale", "header"=>"Opzionale", "width"=>50,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"forza_scadenzario", "header"=>"Scadenzario", "width"=>100,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"compenso_spettante", "header"=>"Compenso s.", "width"=>100,"css"=>array("text-align"=>"center"));
                $options_incarichi[]=array("id"=>"note", "header"=>"Note", "fillspace"=>true,"css"=>array("text-align"=>"center"));
            }

            $incarichi_table=new AA_JSON_Template_Generic($curId."_Table",array("view"=>"datatable", "headerRowHeight"=>28, "select"=>true, "scrollX"=>false,"css"=>"AA_Header_DataTable","columns"=>$options_incarichi));
            $incarichi_data=array();
            $incarichi=$curOrganigramma->GetIncarichi();
            
            //AA_Log::Log(__METHOD__." - ".print_r($incarichi,TRUE),100);
            $riepilogo_data_item['incarichi']="";
            foreach($incarichi as $id_incarico=>$incarico)
            {
                //dati incarichi organigramma per riepilogo
                $riepilogo_incarico_label="<div style='display:flex;flex-direction: column; align-items:center'><b>".$incarico->GetTipologia()."</b>";
                $curTipoIncarico=$incarico->GetTipologia(true);
                $scaduto=false;
                $vacante=true;
                $onClick="";
                $opzionale=false;
                $facenteFunzione=false;
                $dataScadenza="";
                $dataInizio="";
                $ras=false;
                $tempo_indeterminato=false;
                if($incarico->IsOpzionale()) 
                {
                    $opzionale=true;
                }
                if($incarico->IsNominaRas())
                {
                    $ras=true;
                }
                if(!is_array($nomine_index[$curTipoIncarico])) $nomine_index[$curTipoIncarico]=array($incarico->getProp('ras')=>0);
                
                //AA_Log::Log(__METHOD__." - curTipoIncarico: $curTipoIncarico - NominaRas: ".$incarico->getProp('ras')." - ".print_r($nomine[$curTipoIncarico][$incarico->getProp('ras')],TRUE),100);

                if(is_array($nomine[$curTipoIncarico][$incarico->getProp('ras')]) && sizeof($nomine[$curTipoIncarico][$incarico->getProp('ras')]) > $nomine_index[$curTipoIncarico][$incarico->getProp('ras')])
                {
                    $curNominaIndex=0+$nomine_index[$curTipoIncarico][$incarico->getProp('ras')];
                    if($nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['data_fine'] < $now) 
                    {
                        $scaduto=true;
                    }
                    if($nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['facente_funzione']) 
                    {
                        $facenteFunzione=true;
                    }
                    $dataScadenza=$nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['data_fine'];
                    $dataInizio=$nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['data_inizio'];
                    if($dataScadenza == "9999-12-31") $tempo_indeterminato=true;
                    if(!$opzionale || ($opzionale && !$scaduto))
                    {
                        $onClick="AA_MainApp.curModule.setRuntimeValue('".static::AA_UI_PREFIX."_".static::AA_UI_WND_NOMINA_DETAIL."_".static::AA_UI_LAYOUT_NOMINA_DETAIL."', 'filter_data', {id:".$object->GetId().",id_incarico:".$nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['id']."});AA_MainApp.utils.callHandler('dlg', {task:'GetOrganismoNominaDetailViewDlg', postParams: {id: ".$object->GetId().",id_incarico:".$nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['id']."},module: '" . $this->id . "'},'".$this->id."')";
                        $riepilogo_incarico_label.="<span>".$nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['nome']." ".$nomine[$curTipoIncarico][$incarico->getProp('ras')][$curNominaIndex]['cognome']."</span></div>";
                        $vacante=false;
                        $nomine_index[$curTipoIncarico][$incarico->getProp('ras')]+=1;
                    }
                }
                if($vacante) $riepilogo_incarico_label.="<span>vacante</span></div>";
                $riepilogo_incarico_label.="<div style='display:flex;align-items:center;flex-direction:column'>";
                if($incarico->IsNominaRas()) $riepilogo_incarico_label.="<span style='font-size: smaller;'>nomina RAS</span>";
                if($opzionale) 
                {
                    $riepilogo_incarico_label.="<span style='font-size: smaller;'>(opzionale)</span>";
                }

                if($scaduto && !$vacante && !$facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>cessato il: ".$dataScadenza."</span>";
                if(!$scaduto && !$vacante && !$tempo_indeterminato && !$facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>cessa il: ".$dataScadenza."</span>";
                if($facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>facente funzione</span><br/><span style='font-size: smaller;'>dal: ".$dataInizio."</span>";
                if($tempo_indeterminato && !$facenteFunzione) $riepilogo_incarico_label.="<span style='font-size: smaller;'>a tempo indeterminato</span>";
                $riepilogo_incarico_label.="</div>";

                if($ras) $labelTheme="AA_Label_LightGreen";
                else $labelTheme="AA_Label_LightBlue";
                if($vacante) $labelTheme="AA_Label_LightYellow";
                if($opzionale && $vacante) $labelTheme="AA_Label_LightOrange";
                if($scaduto && !$opzionale) $labelTheme="AA_Label_LightRed";
                if($facenteFunzione) $labelTheme="AA_Label_LightYellow";
                $riepilogo_data_item['incarichi'].="<div onclick=\"".$onClick."\" class='AA_Label $labelTheme' style='display:flex;justify-content:space-between; align-items:center; flex-direction:column; text-align: center; margin-right: 5px;'>".$riepilogo_incarico_label."</div>";
                //-------------------------

                //Dati tabella
                $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoModifyOrganigrammaIncaricoDlg", params: [{id: "'.$object->GetId().'"},{id_incarico:"'.$incarico->GetId().'"},{id_organigramma:"'.$curOrganigramma->GetId().'"}]},"'.$this->id.'")';
                $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoDeleteOrganigrammaIncaricoDlg", params: [{id: "'.$object->GetId().'"},{id_incarico:"'.$incarico->GetId().'"},{id_organigramma:"'.$curOrganigramma->GetId().'"}]},"'.$this->id.'")';
                $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
                $ras="No";
                if($incarico->IsNominaRas())$ras="Si";
                $opzionale="No";
                $forza_scadenzario="No";
                if($incarico->IsScadenzarioEnabled() > 0) $forza_scadenzario="Si";
                $opzionale="No";
                $compenso_spettante=$incarico->GetProp("compenso_spettante");
                //if($compenso_spettante=="0,00" || $compenso_spettante=="0,0" || $compenso_spettante=="0") $compenso_spettante="gratuito";
                //$compenso_spettante=$incarico->GetProp("compenso_spettante");

                if($incarico->IsOpzionale())$opzionale="Si";
                //note come popup
                $note=str_replace(array("\n","\r"),"",nl2br($incarico->GetProp('note')));
                if($note != "") $note='<a href="#" onClick=\'let note=CryptoJS.enc.Utf8.stringify(CryptoJS.enc.Base64.parse("'.base64_encode($note).'"));AA_MainApp.ui.modalBox(note,"Note")\'><span class="mdi mdi-eye"></span></a>';
                $incarichi_data[]=array("id"=>$id_incarico,"compenso_spettante"=>$compenso_spettante,"tipo"=>$incarico->GetTipologia(),"note"=>$note,"ras"=>$ras,"opzionale"=>$opzionale,"forza_scadenzario"=>$forza_scadenzario,"ops"=>$ops);
                #--------------------------------------
            }

            if(sizeof($incarichi_data) > 0)
            {
                $incarichi_table->SetProp("data",$incarichi_data);
                $incarichi_box->AddRow($incarichi_table);
            } 
            else $incarichi_box->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
            
            $content_layout->addCol($incarichi_box);

            //Aggiunge la lista incarichi alla pagina
            $curOrganigrammaTab->AddRow($content_layout);
            
            //Aggiunge una barra
            $curOrganigrammaTab->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer","height"=>3,"css"=>array("border-top"=>"1px solid #dedede !important;"))));
            
            //Imposta l'azione del pulsante di dettaglio
            $riepilogo_data_item["onclick"]='$$("'.$tabbar->GetId().'").setValue("'.$curOrganigrammaTab->GetId().'")';
            $riepilogo_data[]=$riepilogo_data_item;
            
            //Aggiunge la pagina alla lista delle pagine
            $multiview->AddCell($curOrganigrammaTab);
        }
        
        //Riepilogo tab
        $riepilogo_layout=$this->TemplateDettaglio_Organigramma_Riepilogo_Tab($object,$id, $riepilogo_data, $id);
        
        array_unshift($options,array("id"=>$riepilogo_layout->GetId(), "value"=>"Riepilogo"));
        
        $multiview->AddCell($riepilogo_layout,true);
        
        $tabbar->SetProp("options",$options);
        
        return $layout;
    }

    //Template dettaglio partecipazioni
    public function TemplateDettaglio_Partecipazioni($object=null,$canModify=false)
    {
        $id=static::AA_UI_PREFIX."_".static::AA_UI_TEMPLATE_PARTECIPAZIONI;
    
        #partecipazioni----------------------------------
        $partecipazione=$object->GetPartecipazione(true);
        $pratiche_data=array();
        foreach($partecipazione['partecipate'] as $id_org=>$curPartecipazione)
        {
            //AA_Log::Log(__METHOD__." - criterio: ".print_r($curDoc,true),100);
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetSinesTrashPartecipazioneDlg", params: [{id:"'.$object->GetId().'"},{id_org:"'.$id_org.'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetSinesModifyPertecipazioneDlg", params: [{id:"'.$object->GetId().'"},{id_org:"'.$id_org.'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops' style='justify-content: space-between;width: 100%'><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="&nbsp;";

            $pratiche_data[]=array("id"=>$id_org,"organismo"=>$curPartecipazione['organismo'],"percentuale"=>AA_Utils::number_format($curPartecipazione['percentuale'],2,",","."),"euro"=>AA_Utils::number_format($curPartecipazione['euro'],2,",","."),"ops"=>$ops);
        }

        $template=new AA_GenericDatatableTemplate($id,"<span style='color:#003380'>Partecipazioni</span>",4,array("css"=>"AA_PartecipazioniHeader_DataTable"));
        $template->SetHeaderCss(array("background-color"=>"#dadee0 !important"));
        $template->EnableScroll(false,true);
        $template->EnableRowOver();
        $template->EnableHeader();
        $template->SetHeaderHeight(38);

        if($canModify) 
        {
            $template->EnableAddNew(true,"GetSinesAddNewPartecipazioneDlg");
            $template->SetAddNewTaskParams(array("postParams"=>array("id"=>$object->GetId())));
        }

        $template->SetColumnHeaderInfo(0,"denominazione","<div style='text-align: left'>Denominazione</div>","fillSpace",null,"text","SinesTable_left");
        $template->SetColumnHeaderInfo(1,"percentuale","<div style='text-align: center'>%</div>",120,null,"int","SinesTable");
        $template->SetColumnHeaderInfo(2,"euro","<div style='text-align: center'>&euro;</div>",120,null,"int","SinesTable_right");
        $template->SetColumnHeaderInfo(3,"ops","<div style='text-align: center'>Operazioni</div>",120,null,null,"SinesTable");

        $template->SetData($pratiche_data);

        return $template;
    }

    //Template dettaglio partecipazioni
    public function TemplateDettaglio_Partecipazioni_Tab($object=null,$canModify=false)
    {
        $id=static::AA_UI_PREFIX."_".static::AA_UI_TEMPLATE_PARTECIPAZIONI."_".$object->GetId();
    
        $layout=new AA_JSON_Template_Layout($id,array("type"=>"clean"));

        #partecipazioni passive----------------------------------
        $partecipazione=$object->GetPartecipazione(true);
        $pratiche_data=array();
        foreach($partecipazione['partecipazioni'] as $id_org=>$curPartecipazione)
        {
            //AA_Log::Log(__METHOD__." - criterio: ".print_r($curDoc,true),100);
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetSinesTrashPartecipazioneDlg", params: [{id:"'.$object->GetId().'"},{id_org:"'.$id_org.'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetSinesModifyPartecipazioneDlg", params: [{id:"'.$object->GetId().'"},{id_org:"'.$id_org.'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops' style='justify-content: space-between;width: 100%'><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="&nbsp;";

            $pratiche_data[]=array("id"=>$id_org,"denominazione"=>$curPartecipazione['denominazione'],"percentuale"=>AA_Utils::number_format($curPartecipazione['percentuale'],2,",","."),"euro"=>AA_Utils::number_format($curPartecipazione['euro'],2,",","."),"ops"=>$ops);
        }

        $template=new AA_GenericDatatableTemplate($id."_passive","<span style='color:#003380'>Organismi che detengono quote di partecipazione</span>",4,array("css"=>"AA_PartecipazioniHeader_DataTable"));
        //$template->SetHeaderCss(array("background-color"=>"#dadee0 !important"));
        $template->EnableScroll(false,true);
        $template->EnableRowOver();
        $template->EnableHeader();
        $template->SetHeaderHeight(38);

        if($canModify) 
        {
            $template->EnableAddNew(true,"GetSinesAddNewPartecipazioneDlg");
            $template->SetAddNewTaskParams(array("postParams"=>array("id"=>$object->GetId())));
        }

        $template->SetColumnHeaderInfo(0,"denominazione","<div style='text-align: left'>Denominazione</div>","fillspace",null,"text","PartecipazioniTable_left");
        $template->SetColumnHeaderInfo(1,"percentuale","<div style='text-align: center'>%</div>",120,null,"int","PartecipazioniTable_right");
        $template->SetColumnHeaderInfo(2,"euro","<div style='text-align: center'>&euro;</div>",120,null,"int","PartecipazioniTable_right");
        $template->SetColumnHeaderInfo(3,"ops","<div style='text-align: center'>Operazioni</div>",120,null,null,"PartecipazioniTable");

        $template->SetData($pratiche_data);
        $layout->AddCol($template);

        //Attive
        $orgPartecipati=$object->GetListaOrganismiPartecipati();
        $pratiche_data=array();
        foreach($orgPartecipati as $id_org=>$curPartecipazione)
        {
            $pratiche_data[]=array("id"=>$id_org,"denominazione"=>$curPartecipazione['denominazione'],"percentuale"=>AA_Utils::number_format($curPartecipazione['partecipazione']['partecipazioni'][$object->GetId()]['percentuale'],2,",","."),"euro"=>AA_Utils::number_format($curPartecipazione['partecipazione']['partecipazioni'][$object->GetId()]['euro'],2,",","."),"ops"=>$ops);
        }
        $template=new AA_GenericDatatableTemplate($id."_attive","<span style='color:#003380'>Societa' di cui detiene quote di partecipazione</span>",3,array("css"=>"AA_PartecipazioniHeader_DataTable AA_PartecipazioniBoxBorderLeft"));
        //$template->SetHeaderCss(array("background-color"=>"#dadee0 !important"));
        $template->EnableScroll(false,true);
        $template->EnableRowOver();
        $template->EnableHeader();
        $template->SetHeaderHeight(38);

        if($canModify) 
        {
            $template->DisableAddNew();
        }

        $template->SetColumnHeaderInfo(0,"denominazione","<div style='text-align: left'>Denominazione</div>","fillspace",null,"text","PartecipazioniTable_left");
        $template->SetColumnHeaderInfo(1,"percentuale","<div style='text-align: center'>%</div>",120,null,"int","PartecipazioniTable");
        $template->SetColumnHeaderInfo(2,"euro","<div style='text-align: center'>&euro;</div>",120,null,"int","PartecipazioniTable_right");

        $template->SetData($pratiche_data);

        $layout->AddCol($template);

        return $layout;
    }

    //Template dettaglio provvedimenti
    public function TemplateDettaglio_Provvedimenti($object=null,$id="", $canModify=false)
    {
        #documenti----------------------------------
        $curId=$id."_Layout_Provvedimenti";
        $provvedimenti=new AA_JSON_Template_Layout($curId,array("type"=>"clean","css"=>array("border-left"=>"1px solid #dedede !important;")));

        $toolbar=new AA_JSON_Template_Toolbar($curId."_Toolbar_Provvedimenti",array("height"=>38, "css"=>array("background"=>"#dadee0 !important;")));
        $toolbar->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>120)));

        $toolbar->AddElement(new AA_JSON_Template_Generic($curId."_Toolbar_Provvedimenti_Title",array("view"=>"label","label"=>"<span style='color:#003380'>Provvedimenti</span>", "align"=>"center")));

        if($canModify)
        {
            //Pulsante di aggiunta documento
            $add_documento_btn=new AA_JSON_Template_Generic($curId."_AddProvvedimento_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-file-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "width"=>120,
                "tooltip"=>"Aggiungi provvedimento",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoAddNewProvvedimentoDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
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
            $options_documenti[]=array("id"=>"anno", "header"=>"Anno", "width"=>"auto","css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"tipo", "header"=>"Tipo", "width"=>200,"css"=>array("text-align"=>"center"));
            $options_documenti[]=array("id"=>"estremi", "header"=>"Estremi", "fillspace"=>true,"css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }
        else
        {
            $options_documenti[]=array("id"=>"anno", "header"=>"Anno", "width"=>"auto","css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"tipo", "header"=>"Tipo", "width"=>200,"css"=>array("text-align"=>"center"));
            $options_documenti[]=array("id"=>"estremi", "header"=>"Estremi", "fillspace"=>true,"css"=>array("text-align"=>"left"));
            $options_documenti[]=array("id"=>"ops", "header"=>"operazioni", "width"=>100,"css"=>array("text-align"=>"center"));
        }

        $documenti=new AA_JSON_Template_Generic($curId."_Provvedimenti_Table",array("view"=>"datatable", "headerRowHeight"=>28, "select"=>true,"scrollX"=>false,"css"=>"AA_Header_DataTable","columns"=>$options_documenti));

        $documenti_data=array();
        foreach($object->GetProvvedimenti() as $id_doc=>$curDoc)
        {
            if($curDoc->GetUrl() == "")
            {
                $view='AA_MainApp.utils.callHandler("pdfPreview", {url: "'.$curDoc->GetFilePublicPath().'&embed=1"},"'.$this->id.'")';
                $view_icon="mdi-floppy";
            }
            else 
            {
                $view='AA_MainApp.utils.callHandler("wndOpen", {url: "'.$curDoc->GetUrl().'"},"'.$this->id.'")';
                $view_icon="mdi-eye";
            }
            
            
            $trash='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoTrashProvvedimentoDlg", params: [{id: "'.$object->GetId().'"},{id_provvedimento:"'.$curDoc->GetId().'"}]},"'.$this->id.'")';
            $modify='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoModifyProvvedimentoDlg", params: [{id: "'.$object->GetId().'"},{id_provvedimento:"'.$curDoc->GetId().'"}]},"'.$this->id.'")';
            if($canModify) $ops="<div class='AA_DataTable_Ops'><a class='AA_DataTable_Ops_Button' title='Vedi' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a><a class='AA_DataTable_Ops_Button' title='Modifica' onClick='".$modify."'><span class='mdi mdi-pencil'></span></a><a class='AA_DataTable_Ops_Button_Red' title='Elimina' onClick='".$trash."'><span class='mdi mdi-trash-can'></span></a></div>";
            else $ops="<div class='AA_DataTable_Ops' style='justify-content: center'><a class='AA_DataTable_Ops_Button' title='Vedi' onClick='".$view."'><span class='mdi ".$view_icon."'></span></a></div>";
            $documenti_data[]=array("id"=>$id_doc,"id_tipo"=>$curDoc->GetTipologia(true) ,"tipo"=>$curDoc->GetTipologia(),"anno"=>$curDoc->GetAnno(),"estremi"=>$curDoc->GetEstremi(),"ops"=>$ops);
        }
        $documenti->SetProp("data",$documenti_data);
        if(sizeof($documenti_data) > 0) $provvedimenti->AddRow($documenti);
        else $provvedimenti->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        #--------------------------------------
        
        return $provvedimenti;
    }
    
    //Template dettaglio riepilogo nomine
    public function TemplateDettaglio_Nomine_Riepilogo_Tab($object=null,$id="",$riepilogo_data=array(),$filter_id="")
    {
        //permessi
        $perms = $object->GetUserCaps($this->oUser);
        $canModify=false;
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0) $canModify=true;
        
        $riepilogo_layout=new AA_JSON_Template_Layout($id."_Riepilogo_Layout",array("type"=>"clean"));

        //rename
        $onclickRename='AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoRenameNominaDlg", postParams: {id: "'.$object->GetID().'",nome: "#nome#",cognome:"#cognome#",cf:"#cf#",ids:#ids#, refresh:1}},"'.$this->id.'")';

        //$onDblClickEvent="try{console.log('_TabBar')}catch(msg){console.error(msg)}";
        $riepilogo_template="<div style='display: flex; justify-content: space-between; align-items: center; height: 100%;'>"
            . "<div onClick='".$onclickRename."' style='min-width: 300px; padding:10px'><span class='AA_DataView_ItemTitle'>#cognome# #nome#</span><br><span style='font-size: smaller'>#cf#</span></div>"
            . "<div style='height:85%; width:100%; padding: 5px; display: flex; overflow: auto'>#incarichi#</div>"
            . "<div style='display: flex; flex-direction: row; justify-content: space-between; align-items: center; height: 85%; min-width: 140px;padding: 5px'>#addNew##deleteAll#</div></div>";
        $riepilogo_tab=new AA_JSON_Template_Generic($id."_Riepilogo_Tab",array(
            "view"=>"dataview",
            "filtered"=>true,
            "xCount"=>1,
            "module_id"=>$this->id,
            "type"=>array(
                "type"=>"tiles",
                "height"=>90,
                "width"=>"auto",
                "css"=>"AA_DataView_Nomine_item",
            ),
            "template"=>$riepilogo_template,
            "data"=>$riepilogo_data,
            //"eventHandlers"=>array("onItemDblClick"=>array("handler"=>"NominaDblClick","module_id"=>$this->GetId()))
        ));
        
        $toolbar_riepilogo=new AA_JSON_Template_Toolbar($id."_Toolbar_Riepilogo",array("height"=>38,"borderless"=>true));
        
        //Flag filtri
        $filter= AA_SessionVar::Get($filter_id);
        if($filter->isValid())
        {
            $label="<div style='display: flex; height: 100%; justify-content: flex-start; align-items: center; padding-left: 5px;'>Mostra:";
            
            $values=(array)$filter->GetValue();
            
            //Storiche
            if($values['storico']=="0") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>archiviate</span>";

            //Scadute
            if($values['scadute']=="0") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>solo in corso</span>";
            //else $label.="<span class='AA_Label AA_Label_LightBlue'>mostra scadute</span>";

            //in corso
            if($values['in_corso']=="0") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>solo cessate</span>";
            //else $label.="<span class='AA_Label AA_Label_LightBlue'>mostra in corso</span>";
            
            //nomina ras
            if($values['nomina_ras']=="0") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>solo nomine non RAS</span>";
            //else $label.="<span class='AA_Label AA_Label_LightBlue'>mostra nomine RAS</span>";

            //nomina altri
            if($values['nomina_altri']=="0") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>solo nomine RAS</span>";
            //else $label.="<span class='AA_Label AA_Label_LightBlue'>mostra nomine non RAS</span>";
            
            //Incarico
            $incarichi= AA_Organismi_Const::GetTipoNomine();
            if($values['tipo'] > 0) $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>".$incarichi[$values['tipo']]."</span>";
            
            //tutte
            if(($values['scadute'] == "1" || !isset($values['scadute'])) && ($values['in_corso'] == "1" || !isset($values['in_corso'])) && ($values['nomina_ras'] =="1" || !isset($values['nomina_ras'])) && ($values['nomina_altri'] =="1" || !isset($values['nomina_altri'])) && ($values['tipo'] == 0 || !isset($values['tipo'])))
            {
                $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>tutte</span>";
            }
            
            $label.="</div>";
                    
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic($id."_Filter_Label",array("view"=>"label","label"=>$label, "width"=>"400", "align"=>"left")));
        }
        else
        {
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>400)));
        }
        
        $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic($id."_Toolbar_Riepilogo_Intestazione",array("view"=>"label","label"=>"<span style='color:#003380'>Riepilogo nomine</span>", "align"=>"center","width"=>"180")));
        $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        if($canModify)
        {            
            //Pulsante di Aggiunta nomina
            $addnew_btn=new AA_JSON_Template_Generic($id."_AddNewUp_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-account-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "css"=>"webix_primary",
                "width"=>120,
                "tooltip"=>"Aggiungi nomina",
                "click"=>'AA_MainApp.utils.callHandler("dlg", {task:"GetOrganismoAddNewIncaricoDlg", postParams: {id: "'.$object->GetID().'", refresh:1, detail:1}},"'.$this->id.'")'
            ));
            
            //pulsante di filtraggio
            if($filter_id=="") $filter_id=$id;
            
            $filterDlgTask="GetOrganismoNomineFilterDlg";
            $filterClickAction="AA_MainApp.utils.callHandler('dlg',{task: '".$filterDlgTask."', params:[{filter_id: '".$filter_id."'}]},'".$this->id."')";

            $filter_btn = new AA_JSON_Template_Generic($id."_FilterUp_btn",array(
                "view"=>"button",
                "align"=>"right",
                "type"=>"icon",
                "icon"=>"mdi mdi-filter",
                "label"=>"Filtra",
                "width"=>80,
                "tooltip"=>"Imposta un filtro di ricerca",
                "click"=>$filterClickAction
            ));
            
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>200)));
            $toolbar_riepilogo->AddElement($filter_btn);
            $toolbar_riepilogo->AddElement($addnew_btn);
        }
        else
        {
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>400)));
        }
        
        $riepilogo_layout->AddRow($toolbar_riepilogo);
        $riepilogo_layout->AddRow($riepilogo_tab);
        
        return $riepilogo_layout;
    }

    //Template dettaglio riepilogo nomine
    public function TemplateDettaglio_Organigramma_Riepilogo_Tab($object=null,$id="",$riepilogo_data=array(),$filter_id="")
    {
        //permessi
        $perms = $object->GetUserCaps($this->oUser);
        $canModify=false;
        if(($perms & AA_Const::AA_PERMS_WRITE) > 0) $canModify=true;
        
        $riepilogo_layout=new AA_JSON_Template_Layout($id."_Riepilogo_Layout",array("type"=>"clean"));
        
        $riepilogo_template="<div style='display: flex; justify-content: space-between; align-items: center; height: 100%;'><div class='AA_DataView_ItemContent' style='width:18%'>"
            . "<div><span class='AA_DataView_ItemTitle'>#tipo#</span></div>"
            . "<div>#scadenzario#</div>"
            . "</div><div style='display: flex; flex-direction: row; justify-content: left; align-items: stretch; height: 95%; width: 70%;'>#incarichi#</div><div style='display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; padding: 5px'><a title='Visualizza i dettagli dell'organigramma' onclick='#onclick#' class='AA_Button_Link'><span class='mdi mdi-account-search'></span>&nbsp;<span>Dettagli</span></a></div></div>";
        $riepilogo_tab=new AA_JSON_Template_Generic($id."_Riepilogo_Tab",array(
            "view"=>"dataview",
            "filtered"=>true,
            "xCount"=>1,
            "module_id"=>$this->id,
            "type"=>array(
                "type"=>"tiles",
                "height"=>140,
                "width"=>"auto",
                "css"=>"AA_DataView_Nomine_item",
            ),
            "template"=>$riepilogo_template,
            "data"=>$riepilogo_data
        ));
        
        $toolbar_riepilogo=new AA_JSON_Template_Toolbar($id."_Toolbar_Riepilogo",array("height"=>38,"borderless"=>true));
        
        //Flag filtri
        $filter= AA_SessionVar::Get($filter_id);
        if($filter->isValid())
        {
            $label="<div style='display: flex; height: 100%; justify-content: flex-start; align-items: center;padding-left: 5px'>Mostra:";
            
            $values=(array)$filter->GetValue();
            
            //mostra gli abilitati per lo scadenzario
            if($values['scadenzario']=="1") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>scadenzario</span>";

            //mostra gli organigrammi di tipo ammiinistrativo
            if($values['amministrazione']=="1") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>amministrazione</span>";

            //mostra gli organigrammi di controllo
            if($values['controllo']=="1") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>controllo</span>";
            
            //mostra gli organigrammi di governo
            if($values['governo']=="1") $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>governo</span>";
                        
            //tutte
            if(($values['scadenzario'] == "1" || !isset($values['amministrazione'])) && ($values['controllo'] == "1" || !isset($values['governo'])))
            {
                $label.="&nbsp;<span class='AA_Label AA_Label_LightBlue'>tutti</span>";
            }
            
            $label.="</div>";
                    
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic($id."_Filter_Label",array("view"=>"label","label"=>$label, "width"=>"400", "align"=>"left")));
        }
        else
        {
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>400)));
        }
        
        $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic($id."_Toolbar_Riepilogo_Intestazione",array("view"=>"label","label"=>"<span style='color:#003380'>Lista organigrammi</span>", "align"=>"center","width"=>"180")));
        $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer")));
        if($canModify)
        {            
            //Pulsante di Aggiunta nomina
            $addnew_btn=new AA_JSON_Template_Generic($id."_AddNewUp_btn",array(
               "view"=>"button",
                "type"=>"icon",
                "icon"=>"mdi mdi-account-plus",
                "label"=>"Aggiungi",
                "align"=>"right",
                "css"=>"webix_primary",
                "width"=>120,
                "tooltip"=>"Aggiungi organigramma",
                "click"=>"AA_MainApp.utils.callHandler('dlg', {task:\"GetOrganismoAddNewOrganigrammaDlg\", params: [{id: ".$object->GetId()."}]},'$this->id')"
            ));
            
            //pulsante di filtraggio
            if($filter_id=="") $filter_id=$id;
            
            $filterDlgTask="GetOrganismoOrganigrammaFilterDlg";
            $filterClickAction="AA_MainApp.utils.callHandler('dlg',{task: '".$filterDlgTask."', params:[{filter_id: '".$filter_id."'}]},'".$this->id."')";

            $filter_btn = new AA_JSON_Template_Generic($id."_FilterUp_btn",array(
                "view"=>"button",
                "align"=>"right",
                "type"=>"icon",
                "icon"=>"mdi mdi-filter",
                "label"=>"Filtra",
                "width"=>80,
                "tooltip"=>"Imposta un filtro di ricerca",
                "click"=>$filterClickAction
            ));
            
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>200)));
            $toolbar_riepilogo->AddElement($filter_btn);
            $toolbar_riepilogo->AddElement($addnew_btn);
        }
        else
        {
            $toolbar_riepilogo->AddElement(new AA_JSON_Template_Generic("",array("view"=>"spacer","width"=>400)));
        }
        
        $riepilogo_layout->AddRow($toolbar_riepilogo);
        $riepilogo_layout->AddRow($riepilogo_tab);
        
        return $riepilogo_layout;
    }
    
    //Template bozze context menu
    public function TemplateActionMenu_Bozze()
    {
         
        $menu=new AA_JSON_Template_Generic("AA_ActionMenuBozze",
            array(
            "view"=>"contextmenu",
            "data"=>array(array(
                "id"=>"refresh_bozze",
                "value"=>"Aggiorna",
                "icon"=>"mdi mdi-reload",
                "module_id"=>$this->GetId(),
                "handler"=>"refreshUiObject",
                "handler_params"=>array(static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX,true)
                ))
            ));
        
        return $menu; 
    }
    
    //Template scadenzario context menu
    public function TemplateActionMenu_Scadenzario()
    {
         
        $menu=new AA_JSON_Template_Generic("AA_ActionMenuScadenzario",
            array(
            "view"=>"contextmenu",
            "data"=>array(array(
                "id"=>"refresh_scadenzario",
                "value"=>"Aggiorna",
                "icon"=>"mdi mdi-reload",
                "module_id"=>$this->GetId(),
                "handler"=>"refreshUiObject",
                "handler_params"=>array(static::AA_UI_PREFIX."_".static::AA_UI_SCADENZARIO_BOX,true)
                ))
            ));
        
        return $menu; 
    }
    
    //Template pubblicate context menu
    public function TemplateActionMenu_Pubblicate()
    {
         
        $menu=new AA_JSON_Template_Generic("AA_ActionMenuPubblicate",
            array(
            "view"=>"contextmenu",
            "data"=>array(array(
                "id"=>"refresh_pubblicate",
                "value"=>"Aggiorna",
                "icon"=>"mdi mdi-reload",
                "module_id"=>$this->GetId(),
                "handler"=>"refreshUiObject",
                "handler_params"=>array(static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX,true)
                )
                )
            ));
        
        return $menu; 
    }
    
    //Template revisionate context menu
    public function TemplateActionMenu_Revisionate()
    {
         
        $menu=new AA_JSON_Template_Generic("AA_ActionMenuRevisionate",
            array(
            "view"=>"contextmenu",
            "data"=>array(array(
                "id"=>"refresh_revisionate",
                "value"=>"Aggiorna",
                "icon"=>"mdi mdi-reload",
                "module_id"=>$this->GetId(),
                "handler"=>"refreshUiObject",
                "handler_params"=>array(static::AA_UI_PREFIX."_".static::AA_UI_REVISIONATE_BOX,true)
                ))
            ));
        
        return $menu; 
    }
    
    //Template detail context menu
    public function TemplateActionMenu_Detail()
    {
         
        $menu=new AA_JSON_Template_Generic("AA_ActionMenuDetail",
            array(
            "view"=>"contextmenu",
            "data"=>array(array(
                "id"=>"refresh_detail",
                "value"=>"Aggiorna",
                "icon"=>"mdi mdi-reload",
                "panel_id"=>"back",
                "section_id"=>"Dettaglio",
                "module_id"=>$this->GetId(),
                "handler"=>"refreshUiObject",
                "handler_params"=>array(static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX,true)
                ))
            ));
        
        return $menu; 
    }
    
    //Template navbar bozze
    public function TemplateNavbar_Bozze($level=1,$last=false,$refresh_view=true)
    {
        $class="n".$level;
        if($last) $class.=" AA_navbar_terminator_left";
        $navbar =  new AA_JSON_Template_Template(static::AA_UI_PREFIX."_Navbar_Link_Bozze_Content_Box",array(
                "type"=>"clean",
                "section_id"=>"Bozze",
                "module_id"=>$this->GetId(),
                "refresh_view"=>$refresh_view,
                "tooltip"=>"Fai click per visualizzare le schede in bozza",
                "template"=>"<div class='AA_navbar_link_box_left #class#'><a class='AA_Sines_Navbar_Link_Bozze_Content_Box' onClick='AA_MainApp.utils.callHandler(\"setCurrentSection\",\"Bozze\",\"".$this->id."\")'><span class='#icon#' style='margin-right: .5em'></span><span>#label#</span></a></div>",
                "data"=>array("label"=>"Bozze","icon"=>"mdi mdi-file-document-edit","class"=>$class))
            );
        return $navbar;  
    }
    
    //Template navbar pubblicate
    public function TemplateNavbar_Pubblicate($level=1,$last=false,$refresh_view=true)
    {
        $class="n".$level;
        if($last) $class.=" AA_navbar_terminator_left";
        $navbar =  new AA_JSON_Template_Template(static::AA_UI_PREFIX."_Navbar_Link_".static::AA_UI_PUBBLICATE_BOX,array(
                "type"=>"clean",
                "section_id"=>"Pubblicate",
                "module_id"=>$this->GetId(),
                "refresh_view"=>$refresh_view,
                "tooltip"=>"Fai click per visualizzare le schede pubblicate",
                "template"=>"<div class='AA_navbar_link_box_left #class#'><a class='AA_Sines_Navbar_Link_Pubblicate_Content_Box' onClick='AA_MainApp.utils.callHandler(\"setCurrentSection\",\"Pubblicate\",\"".$this->id."\")'><span class='#icon#' style='margin-right: .5em'></span><span>#label#</span></a></div>",
                "data"=>array("label"=>"Pubblicate","icon"=>"mdi mdi-certificate","class"=>$class))
            );
        return $navbar;  
    }
    
    //Template navbar scadenzario
    public function TemplateNavbar_Scadenzario($level=1,$last=false,$refresh_view=true)
    {
        $class="n".$level;
        if($last) $class.=" AA_navbar_terminator_left";
        $navbar =  new AA_JSON_Template_Template(static::AA_UI_PREFIX."_Navbar_Link_Scadenzario_Content_Box",array(
                "type"=>"clean",
                "section_id"=>"Scadenzario",
                "module_id"=>$this->GetId(),
                "refresh_view"=>$refresh_view,
                "tooltip"=>"Fai click per visualizzare lo scadenzario delle nomine",
                "template"=>"<div class='AA_navbar_link_box_left #class#'><a class='AA_Sines_Navbar_Link_Scadenzario_Content_Box' onClick='AA_MainApp.utils.callHandler(\"setCurrentSection\",\"Scadenzario\",\"".$this->id."\")'><span class='#icon#' style='margin-right: .5em'></span><span>#label#</span></a></div>",
                "data"=>array("label"=>"Agenda nomine","icon"=>"mdi mdi-clipboard-clock","class"=>$class))
            );
        return $navbar;  
    }
    
    //Template navbar pubblicate
    public function TemplateNavbar_Back($level=1,$last=false,$refresh_view=false)
    {
        $class="n".$level;
        if($last) $class.=" AA_navbar_terminator_left";
        $id=static::AA_UI_PREFIX."_Navbar_Link_Back_Content_Box_".uniqid(time());
        $navbar =  new AA_JSON_Template_Template($id,array(
                "type"=>"clean",
                "css"=>"AA_NavbarEventListener",
                "module_id"=>"AA_MODULE_SINES",
                "refresh_view"=>$refresh_view,
                "tooltip"=>"Fai click per tornare alla lista",
                "template"=>"<div class='AA_navbar_link_box_left #class#'><a class='".$id."' onClick='AA_MainApp.utils.callHandler(\"goBack\",null,\"".$this->id."\")'><span class='#icon#' style='margin-right: .5em'></span><span>#label#</span></a></div>",
                "data"=>array("label"=>"Indietro","icon"=>"mdi mdi-keyboard-backspace","class"=>$class))
            );
        return $navbar;  
    }
    
    //Template navbar indietro
    public function TemplateNavbar_Revisionate($level=1,$last=false,$refresh_view=true)
    {
        $class="n".$level;
        if($last) $class.=" AA_navbar_terminator_left";
        $navbar =  new AA_JSON_Template_Template(static::AA_UI_PREFIX."_Navbar_Link_Revisionate_Content_Box",array(
                "type"=>"clean",
                "css"=>"AA_NavbarEventListener",
                "id_panel"=>static::AA_UI_PREFIX."_Revisionate_Content_Box",
                "module_id"=>"AA_MODULE_SINES",
                "refresh_view"=>$refresh_view,
                "tooltip"=>"Fai click per visualizzare le schede pubblicate revisionate",
                "template"=>"<div class='AA_navbar_link_box_left #class#'><a class='AA_Sines_Navbar_Link_Revisionate_Content_Box'><span class='#icon#' style='margin-right: .5em'></span><span>#label#</span></a></div>",
                "data"=>array("label"=>"Revisionate","icon"=>"mdi mdi-help-rhombus","class"=>$class))
            );
        return $navbar;  
    }
     
    //Task
    public function Task_GetActionMenu($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        
        $content="";
        
        switch($_REQUEST['section'])
        {
            case static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX:
                $content=$this->TemplateActionMenu_Bozze();
                break;
            
            case static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX:
                $content=$this->TemplateActionMenu_Pubblicate();
                break;
               
            case static::AA_UI_PREFIX."_Revisionate_Content_Box":
                $content=$this->TemplateActionMenu_Revisionate();
                break;
            case static::AA_UI_PREFIX."_Scadenzario_Content_Box":
                $content=$this->TemplateActionMenu_Scadenzario();
                break;
            case static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX:
                $content=$this->TemplateActionMenu_Detail();
                break;
            default:
                $content=new AA_JSON_Template_Generic();
                break;        
        }
        
        if($content !="") $sTaskLog.= $content->toBase64();
        
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task tipo bilanci
    public function Task_GetTipoBilanci($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $tipo_bilanci_collection=array();
        foreach(AA_Organismi_Const::GetTipoBilanci() as $id_tipo=>$value_tipo)
        {
            if($id_tipo>0) $tipo_bilanci_collection[]=array("id"=>$id_tipo,"value"=>$value_tipo);
        }
        
        $tipo_bilanci_collection="[";
        $sep="";
        foreach(AA_Organismi_Const::GetTipoBilanci() as $id_tipo=>$value_tipo)
        {
            if($id_tipo>0) 
            {
                $tipo_bilanci_collection.=$sep.'{"id": "'.$id_tipo.'", "value":"'.$value_tipo.'"}';
                $sep=",";
            }
        }
        $tipo_bilanci_collection.="]";
        
        $task->SetLog($tipo_bilanci_collection);
        
        return true;
    }
    
    //Task layout
    public function Task_GetLayout($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json'>";
        $content=$this->TemplateLayout();
        $sTaskLog.= $content;
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //GetLogDlg
    public function Task_GetLogDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $wnd = new AA_SinesLogDlg("AA_SinesLogDlg_".$_REQUEST['id'],"Logs",$this->oUser);
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>".$wnd->toBase64()."</content><error id='error'></error>";

        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task Update Organismo
    public function Task_UpdateOrganismo($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        $partecipazione=$organismo->GetPartecipazione(true);

        if(isset($_REQUEST['Partecipazione_percentuale']) && $_REQUEST['Partecipazione_percentuale'] == 0 && (!isset($_REQUEST['Partecipazione_euro']) || $_REQUEST['Partecipazione_euro'] !=0))
        {
            $task->SetError("Incongruenza tra le quote di partecipazione espresse in percentuale e quelle espresse in euro.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Incongruenza tra le quote di partecipazione espresse in percentuale e quelle espresse in euro.</error>";
            $task->SetLog($sTaskLog);

            return false;
        }

        if(isset($_REQUEST['Partecipazione_euro']) && $_REQUEST['Partecipazione_euro'] == 0 && (!isset($_REQUEST['Partecipazione_percentuale']) || $_REQUEST['Partecipazione_percentuale'] !=0))
        {
            $task->SetError("Incongruenza tra le quote di partecipazione espresse in percentuale e quelle espresse in euro.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Incongruenza tra le quote di partecipazione espresse in percentuale e quelle espresse in euro.</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(isset($_REQUEST['Partecipazione_percentuale']) && $_REQUEST['Partecipazione_percentuale'] !="")
        {
            $partecipazione['percentuale']=AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_percentuale'])),2,".");
        }
        if(isset($_REQUEST['Partecipazione_euro']) && $_REQUEST['Partecipazione_euro'] !="")
        {
            $partecipazione['euro']=AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_euro'])),2,".");
        }

        if(sizeof($partecipazione)>0)
        {
            //AA_Log::Log(__METHOD__." partecipazione: ".print_r($partecipazione,true),100);
            $_REQUEST['sPartecipazione']=json_encode($partecipazione);
        }

        //Aggiorna i dati
        if(!$organismo->ParseData($_REQUEST))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel parsing dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati
        if(!$organismo->UpdateDb($this->oUser,null,true," Aggiornamento dati generali"))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salavataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Dati aggiornati con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task trash Organismi
    public function Task_TrashOrganismi($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $result_error=array();
        $ids_final=array();

        //lista organismi da cestinare
        if($_REQUEST['ids'])
        {
            $ids= json_decode($_REQUEST['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_DELETE)>0)
                {
                    $ids_final[$curId]=$organismo;
                    unset($organismo);
                }
            }
            
            //Esiste almeno un organismo che può essere cestinato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $count=0;
                foreach( $ids_final as $id=>$organismo)
                {
                    
                    if(!$organismo->Trash($this->oUser))
                    {
                        $count++;
                        $result_error[$organismo->GetDenominazione()]=AA_Log::$lastErrorLog;
                    }
                }
                
                if(sizeof($result_error)>0)
                {
                    $wnd=new AA_GenericWindowTemplate("TrashOrganismi", "Avviso", $this->id);
                    $wnd->SetWidth("640");
                    $wnd->SetHeight("400");
                    $wnd->AddView(new AA_JSON_Template_Template("",array("template"=>"Sono stati cestinati ".(sizeof($ids)-sizeof($result_error))." organismi.<br>I seguenti non sono stati cestinati:")));
                
                    $tabledata=array();
                    foreach($result_error as $org=>$desc)
                    {
                        $tabledata[]=array("Denominazione"=>$org,"Errore"=>$desc);
                    }
                    $table=new AA_JSON_Template_Generic($id."_Table", array(
                        "view"=>"datatable",
                        "scrollX"=>false,
                        "autoConfig"=>true,
                        "select"=>false,
                        "data"=>$tabledata
                    ));
                    $wnd->AddView($table);
                    
                    $sTaskLog="<status id='status'>-1</status><error id='error' type='json' encode='base64'>";
                    $sTaskLog.=$wnd->toBase64();
                    $sTaskLog.="</error>";
                    $task->SetLog($sTaskLog);

                    return false;      
                }
                else
                {
                    $sTaskLog="<status id='status'>0</status><content id='content'>";
                    $sTaskLog.= "SOno stati cestinati ".sizeof($ids_final)." organismi.";
                    $sTaskLog.="</content>";

                    $task->SetLog($sTaskLog);

                    return true;
                }
            }
            else
            {
                $task->SetError("Nella selezione non sono presenti organismi cestinabili dall'utente corrente (".$this->oUser->GetName().").");
                $sTaskLog="<status id='status'>-1</status><error id='error'>Nella selezione non sono presenti organismi cestinabili dall'utente corrente (".$this->oUser->GetName().").</error>";
                $task->SetLog($sTaskLog);

                return false;          
            }
        }
        else
        {
            $task->SetError("Non sono stati selezionati organismi.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Non sono stati selezionati organismi.</error>";
            $task->SetLog($sTaskLog);

            return false;          
        } 
    }
    
    
    //Task trash Organismi
    public function Task_PdfExport($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sessVar= AA_SessionVar::Get("SaveAsPdf_ids");
        $sessParams = AA_SessionVar::Get("SaveAsPdf_params");
        
        //lista organismi da esportare
        if($sessVar->IsValid() && !isset($_REQUEST['fromParams']))
        {
            $ids = $sessVar->GetValue();
            $ids_final=array();
            
            if(is_array($ids))
            {
                foreach($ids as $curId)
                {
                    $organismo=new AA_Organismi($curId,$this->oUser);
                    if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_READ)>0)
                    {
                        $ids_final[$curId]=$organismo;
                    }
                }    
            }
            
            //Esiste almeno un organismo che può essere letto dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                if($_REQUEST['section'] == "Scadenzario") $this->Template_OrganismiScadenzarioPdfExport($ids_final);
                else $this->Template_OrganismiPdfExportFull($ids_final);
            }
            else
            {
                $task->SetError("Nella selezione non sono presenti organismi leggibili dall'utente corrente (".$this->oUser->GetName().").");
                $sTaskLog="<status id='status'>-1</status><error id='error'>Nella selezione non sono presenti organismi leggibili dall'utente corrente (".$this->oUser->GetName().").</error>";
                $task->SetLog($sTaskLog);

                return false;          
            }
        }
        else
        {
            if($sessParams->isValid())
            {
                $params=(array) $sessParams->GetValue();

                //Verifica della sezione
                if($params['section']=="Bozze")
                {
                    $params["status"]=AA_Const::AA_STATUS_BOZZA;
                }
                else
                {
                    if($params['section'] !="Scadenzario") $params["status"]=AA_Const::AA_STATUS_PUBBLICATA;
                    else 
                    {
                        //$params=unserialize($_SESSION['AA_Organismi_Scadenzario_Filter_Params']);
                        //if(is_array($params)) $params['count']='all';
                        //else $params=array('status'=>'AA_Const::AA_STATUS_PUBBLICATA','count'=>'all');
                        $params["status"]=AA_Const::AA_STATUS_PUBBLICATA;
                    }
                }
                
                if($params['cestinate'] == 1) 
                {
                    $params['status'] |=AA_Const::AA_STATUS_CESTINATA;
                }

                $objects=AA_Organismi::Search($params,false,$this->oUser);
                //AA_Log::Log(__METHOD__." - search params: ".print_r($params,true),100);
                
                if($objects[0]==0)
                {
                    $task->SetError("Non è stata individuata nessuna corrispondenza in base ai parametri indicati.");
                    $sTaskLog="<status id='status'>-1</status><error id='error'>Non è stata individuata nessa corrispondenza in base ai parametri indicati.</error>";
                    $task->SetLog($sTaskLog);
                    return false;          
                }
                else
                {
                    if($_REQUEST['section'] == "Scadenzario") $this->Template_OrganismiScadenzarioPdfExport($objects[1]);
                    else $this->Template_OrganismiPdfExportFull($objects[1]);
                }
            }
        } 
    }
    
    //Task resume Organismi
    public function Task_ResumeOrganismi($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        //lista organismi da ripristinare
        $ids_final=array();
        $result_error=array();

        if($_REQUEST['ids'])
        {
            $ids= json_decode($_REQUEST['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_WRITE)>0)
                {
                    $ids_final[$curId]=$organismo;
                    unset($organismo);
                }
            }
            
            //Esiste almeno un organismo che può essere ripristinato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $count=0;
                foreach( $ids_final as $id=>$organismo)
                {
                    
                    if(!$organismo->Resume($this->oUser))
                    {
                        $count++;
                        $result_error[$organismo->GetDenominazione()]=AA_Log::$lastErrorLog;
                    }
                }
                
                if(sizeof($result_error)>0)
                {
                    $wnd=new AA_GenericWindowTemplate("ResumeOrganismi", "Avviso", $this->id);
                    $wnd->SetWidth("640");
                    $wnd->SetHeight("400");
                    $wnd->AddView(new AA_JSON_Template_Template("",array("template"=>"Sono stati ripristinati ".(sizeof($ids)-sizeof($result_error))." organismi.<br>I seguenti non sono stati ripristinati:")));
                
                    $tabledata=array();
                    foreach($result_error as $org=>$desc)
                    {
                        $tabledata[]=array("Denominazione"=>$org,"Errore"=>$desc);
                    }
                    $table=new AA_JSON_Template_Generic($id."_Table", array(
                        "view"=>"datatable",
                        "scrollX"=>false,
                        "autoConfig"=>true,
                        "select"=>false,
                        "data"=>$tabledata
                    ));
                    $wnd->AddView($table);
                    
                    $sTaskLog="<status id='status'>-1</status><error id='error' type='json' encode='base64'>";
                    $sTaskLog.=$wnd->toBase64();
                    $sTaskLog.="</error>";
                    $task->SetLog($sTaskLog);

                    return false;      
                }
                else
                {
                    $sTaskLog="<status id='status'>0</status><content id='content'>";
                    $sTaskLog.= "Sono stati ripristinati ".sizeof($ids_final)." organismi.";
                    $sTaskLog.="</content>";

                    $task->SetLog($sTaskLog);

                    return true;
                }
            }
            else
            {
                $task->SetError("Nella selezione non sono presenti organismi ripristinabili dall'utente corrente (".$this->oUser->GetName().").");
                $sTaskLog="<status id='status'>-1</status><error id='error'>Nella selezione non sono presenti organismi ripristinabili dall'utente corrente (".$this->oUser->GetName().").</error>";
                $task->SetLog($sTaskLog);

                return false;          
            }
        }
        else
        {
            $task->SetError("Non sono stati selezionati organismi.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Non sono stati selezionati organismi.</error>";
            $task->SetLog($sTaskLog);

            return false;          
        } 
    }
    
    //Task publish Organismi
    public function Task_PublishOrganismo($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $ids_final=array();
        $result_error=array();
        //lista organismi da pubblicare
        if($_REQUEST['ids'])
        {
            $ids= json_decode($_REQUEST['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_PUBLISH)>0)
                {
                    $ids_final[$curId]=$organismo;
                    unset($organismo);
                }
            }
            
            //Esiste almeno un organismo che può essere pubblicato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $count=0;
                foreach( $ids_final as $id=>$organismo)
                {
                    if(!$organismo->Publish($this->oUser))
                    {
                        $count++;
                        $result_error[$organismo->GetDenominazione()]=AA_Log::$lastErrorLog;
                    }
                }
                
                if(sizeof($result_error)>0)
                {
                    $wnd=new AA_GenericWindowTemplate("PublishOrganismo", "Avviso", $this->id);
                    $wnd->SetWidth("640");
                    $wnd->SetHeight("400");
                    $wnd->AddView(new AA_JSON_Template_Template("",array("autoheight"=>true,"template"=>"Sono stati pubblicati ".(sizeof($ids)-sizeof($result_error))." organismi.<br>I seguenti non sono stati pubblicati:")));
                
                    $columns=array(
                        array("id"=>"Denominazione","header"=>array("<div style='text-align: center'>Denominazione</div>",array("content"=>"textFilter")),"fillspace"=>true,"sort"=>"text","css"=>"PraticheTable_left"),
                        array("id"=>"Errore","header"=>array("<div style='text-align: center'>Errore</div>",array("content"=>"textFilter")),"fillspace"=>true,"sort"=>"text","css"=>"PraticheTable_left"),
                    );
                    $tabledata=array();
                    foreach($result_error as $org=>$desc)
                    {
                        $tabledata[]=array("Denominazione"=>$org,"Errore"=>$desc);
                    }
                    $table=new AA_JSON_Template_Generic($id."_Table", array(
                        "view"=>"datatable",
                        "scrollX"=>false,
                        "columns"=>$columns,
                        "select"=>false,
                        "data"=>$tabledata
                    ));
                    $wnd->AddView($table);
                    
                    $sTaskLog="<status id='status'>-1</status><error id='error' type='json' encode='base64'>";
                    $sTaskLog.=$wnd->toBase64();
                    $sTaskLog.="</error>";
                    $task->SetLog($sTaskLog);

                    return false;      
                }
                else
                {
                    $sTaskLog="<status id='status'>0</status><content id='content'>";
                    $sTaskLog.= "Sono stati pubblicati ".sizeof($ids_final)." organismi.";
                    $sTaskLog.="</content>";

                    $task->SetLog($sTaskLog);

                    return true;
                }
            }
            else
            {
                $task->SetError("Nella selezione non sono presenti organismi pubblicabili dall'utente corrente (".$this->oUser->GetName().").");
                $sTaskLog="<status id='status'>-1</status><error id='error'>Nella selezione non sono presenti organismi pubblicabili dall'utente corrente (".$this->oUser->GetName().").</error>";
                $task->SetLog($sTaskLog);

                return false;          
            }
        }
        else
        {
            $task->SetError("Non sono stati selezionati organismi.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Non sono stati selezionati organismi.</error>";
            $task->SetLog($sTaskLog);

            return false;          
        } 
    }
    
    //Task reassign Organismi
    public function Task_ReassignOrganismi($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $result_error=array();
        $ids_final=array();
        //lista organismi da riassegnare
        if($_REQUEST['ids'])
        {
            $ids= json_decode($_REQUEST['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_WRITE)>0)
                {
                    $ids_final[$curId]=$organismo;
                    unset($organismo);
                }
            }
            
            //Esiste almeno un organismo che può essere ripristinato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $count=0;
                $params['riassegna-id-assessorato']=$_REQUEST['id_assessorato'];
                $params['riassegna-id-direzione']=$_REQUEST['id_direzione'];
                $params['riassegna-id-servizio']=$_REQUEST['id_servizio'];
                foreach( $ids_final as $id=>$organismo)
                {                    
                    if(!$organismo->Reassign($params,$this->oUser))
                    {
                        $count++;
                        $result_error[$organismo->GetDenominazione()]=AA_Log::$lastErrorLog;
                    }
                }
                
                if(sizeof($result_error)>0)
                {
                    $wnd=new AA_GenericWindowTemplate("ReassignOrganismi", "Avviso", $this->id);
                    $wnd->SetWidth("640");
                    $wnd->SetHeight("400");
                    $wnd->AddView(new AA_JSON_Template_Template("",array("template"=>"Sono stati riassegnati ".(sizeof($ids)-sizeof($result_error))." organismi alla struttura: ".$_REQUEST['struct_desc'].".<br>I seguenti non sono stati riassegnati:")));
                
                    $tabledata=array();
                    foreach($result_error as $org=>$desc)
                    {
                        $tabledata[]=array("Denominazione"=>$org,"Errore"=>$desc);
                    }
                    $table=new AA_JSON_Template_Generic($id."_Table", array(
                        "view"=>"datatable",
                        "scrollX"=>false,
                        "autoConfig"=>true,
                        "select"=>false,
                        "data"=>$tabledata
                    ));
                    $wnd->AddView($table);
                    
                    $sTaskLog="<status id='status'>-1</status><error id='error' type='json' encode='base64'>";
                    $sTaskLog.=$wnd->toBase64();
                    $sTaskLog.="</error>";
                    $task->SetLog($sTaskLog);

                    return false;      
                }
                else
                {
                    $sTaskLog="<status id='status'>0</status><content id='content'>";
                    $sTaskLog.= "Sono stati riassegnati ".sizeof($ids_final)." organismi.";
                    $sTaskLog.="</content>";

                    $task->SetLog($sTaskLog);

                    return true;
                }
            }
            else
            {
                $task->SetError("Nella selezione non sono presenti organismi riassegnabili dall'utente corrente (".$this->oUser->GetName().").");
                $sTaskLog="<status id='status'>-1</status><error id='error'>Nella selezione non sono presenti organismi riassegnabili dall'utente corrente (".$this->oUser->GetName().").</error>";
                $task->SetLog($sTaskLog);

                return false;          
            }
        }
        else
        {
            $task->SetError("Non sono stati selezionati organismi.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Non sono stati selezionati organismi.</error>";
            $task->SetLog($sTaskLog);

            return false;          
        } 
    }
    
    //Task delete Organismi
    public function Task_DeleteOrganismi($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $ids_final=array();
        $result_error=array();
        
        //lista organismi da eliminare
        if($_REQUEST['ids'])
        {
            $ids= json_decode($_REQUEST['ids']);
            
            foreach($ids as $curId)
            {
                $organismo=new AA_Organismi($curId,$this->oUser);
                if($organismo->isValid() && ($organismo->GetUserCaps($this->oUser)&AA_Const::AA_PERMS_DELETE)>0)
                {
                    $ids_final[$curId]=$organismo;
                    unset($organismo);
                }
            }
            
            //Esiste almeno un organismo che può essere cestinato dall'utente corrente
            if(sizeof($ids_final)>0)
            {
                $count=0;
                foreach( $ids_final as $id=>$organismo)
                {
                    
                    if(!$organismo->Trash($this->oUser,true))
                    {
                        $count++;
                        $result_error[$organismo->GetDenominazione()]=AA_Log::$lastErrorLog;
                    }
                }
                
                if(sizeof($result_error)>0)
                {
                    $wnd=new AA_GenericWindowTemplate("DeleteOrganismi", "Avviso", $this->id);
                    $wnd->SetWidth("640");
                    $wnd->SetHeight("400");
                    $wnd->AddView(new AA_JSON_Template_Template("",array("template"=>"Sono stati eliminati ".(sizeof($ids)-sizeof($result_error))." organismi.<br>I seguenti non sono stati eliminati:")));
                
                    $tabledata=array();
                    foreach($result_error as $org=>$desc)
                    {
                        $tabledata[]=array("Denominazione"=>$org,"Errore"=>$desc);
                    }
                    $table=new AA_JSON_Template_Generic($id."_Table", array(
                        "view"=>"datatable",
                        "scrollX"=>false,
                        "autoConfig"=>true,
                        "select"=>false,
                        "data"=>$tabledata
                    ));
                    $wnd->AddView($table);
                    
                    $sTaskLog="<status id='status'>-1</status><error id='error' type='json' encode='base64'>";
                    $sTaskLog.=$wnd->toBase64();
                    $sTaskLog.="</error>";
                    $task->SetLog($sTaskLog);

                    return false;      
                }
                else
                {
                    $sTaskLog="<status id='status'>0</status><content id='content'>";
                    $sTaskLog.= "Sono stati eliminati ".sizeof($ids_final)." organismi.";
                    $sTaskLog.="</content>";

                    $task->SetLog($sTaskLog);

                    return true;
                }
            }
            else
            {
                $task->SetError("Nella selezione non sono presenti organismi eliminabili dall'utente corrente (".$this->oUser->GetName().").");
                $sTaskLog="<status id='status'>-1</status><error id='error'>Nella selezione non sono presenti organismi eliminabili dall'utente corrente (".$this->oUser->GetName().").</error>";
                $task->SetLog($sTaskLog);

                return false;          
            }
        }
        else
        {
            $task->SetError("Non sono stati selezionati organismi.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Non sono stati selezionati organismi.</error>";
            $task->SetLog($sTaskLog);

            return false;          
        } 
    }
    
    //Task Aggiungi organismo
    public function Task_AddNewOrganismo($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $task->SetError("L'utente corrente non ha i permessi per aggiugere nuovi organismi");
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente non ha i permessi per aggiugere nuovi organismi</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        $organismo= AA_Organismi::AddNewToDb($_REQUEST, $this->oUser);
        
        if(!($organismo instanceof AA_Organismi))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status' id_Rec='".$organismo->GetId()."' action='showDetailView' action_params='".json_encode(array("id"=>$organismo->GetId()))."'>0</status><content id='content'>";
        $sTaskLog.= "Organismo aggiunto con successo (identificativo: ".$organismo->GetId().")";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task Aggiungi dato contabile
    public function Task_AddNewOrganismoDatoContabile($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati
        $new_dato=AA_OrganismiDatiContabili::AddNewToDb($_REQUEST,$organismo,$this->oUser);
        
        if(!($new_dato instanceof AA_OrganismiDatiContabili))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status' id_Rec='".$new_dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Dato contabile inserito con successo (identificativo: ".$new_dato->GetId().").";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //help task
    //funzione di aiuto
    public function Task_AMAAI_Start($task)
    {
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        
        $task->SetContent($this->Template_GetSinesHelpDlg(),true);
        
        //$help_url="";
        //$action='AA_MainApp.utils.callHandler("pdfPreview", { url: this.taskManager + "?task=PdfExport&section=" + this.curSection.id }, this.id);';
        
        return true;

    }

    //Help dlg
    public function Template_GetSinesHelpDlg()
    {
        $id=$this->GetId()."_Help_Dlg";
        
        $wnd=new AA_GenericWindowTemplate($id, "Aiuto", $this->id);
        
        $wnd->SetWidth(350);

        $platform=AA_Platform::GetInstance($this->oUser);
        $manualPath=$platform->GetModulePathURL($this->GetId())."/docs/manuale.pdf";
        $action='AA_MainApp.utils.callHandler("pdfPreview", { url: "'.$manualPath.'" }, "'.$this->GetId().'");';

        $layout=new AA_JSON_Template_Layout($id."_Aiuto_box",array("type"=>"clean"));
        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));
        $toolbar_oc=new AA_JSON_Template_Toolbar($id."_ToolbarOC",array("type"=>"clean","borderless"=>true));

        //manuale operatore comunale
        $btn=new AA_JSON_Template_Generic($id."_Manuale_btn",array(
            "view"=>"button",
            "type"=>"icon",
            "icon"=>"mdi mdi-help-circle",
            "label"=>"Manuale operativo",
            "align"=>"center",
            "inputWidth"=>300,
            "click"=>$action,
            "tooltip"=>"Visualizza o scarica il manuale operativo."
        ));

        $toolbar_oc->AddCol($btn);
        $layout->AddRow($toolbar_oc);

        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));

        $toolbar_oc=new AA_JSON_Template_Toolbar($id."_ToolbarOC",array("type"=>"clean","borderless"=>true));
        $manualPath=$platform->GetModulePathURL($this->GetId())."/docs/lista_referenti.pdf";
        $action='AA_MainApp.utils.callHandler("pdfPreview", { url: "'.$manualPath.'" }, "'.$this->GetId().'");';
        //manuale operatore comunale rendiconti
        $btn=new AA_JSON_Template_Generic($id."_ReferentiSines_btn",array(
            "view"=>"button",
            "type"=>"icon",
            "icon"=>"mdi mdi-help-circle",
            "label"=>"Lista refrerenti",
            "align"=>"center",
            "inputWidth"=>300,
            "click"=>$action,
            "tooltip"=>"Visualizza o scarica la lista dei referenti"
        ));

        $toolbar_oc->AddCol($btn);
        $layout->AddRow($toolbar_oc);

        $layout->AddRow(new AA_JSON_Template_Generic("",array("height"=>20)));

        $wnd->AddView($layout);        

        return $wnd;
    }
    
    //Task Aggiungi dato contabile
    public function Task_AddNewOrganismoNomina($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati
        $new_dato=AA_OrganismiNomine::AddNewToDb($_REQUEST,$organismo,$this->oUser);
        
        if(!($new_dato instanceof AA_OrganismiNomine))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent("Incarico inserito con successo (identificativo: ".$new_dato->GetId().").",false);

        if(!empty($_REQUEST['detail']))
        {
            //apri la pagina di dettaglio dell'incarico
            $task->SetStatusAction("dlg",array("task"=>"GetOrganismoNominaDetailViewDlg","params"=>array("id"=>$organismo->GetId(),"id_incarico"=>$new_dato->GetId())),true);
        }

        return true;
    }

    //Task Aggiungi parftecipazione
    public function Task_AddNewSinesPartecipazione($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $organismoPartecipante=new AA_Organismi($_REQUEST['organismo'],$this->oUser);

        if(!$organismoPartecipante->isValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Organismo partecipante non valido.",false);
            return false;            
        }

        $partecipazione=$organismo->GetPartecipazione(true);
        if(!isset($partecipazione['partecipazioni'])) $partecipazione['partecipazioni']=array();

        //verifica percentuali partecipazione
        $partecipazione_tot=$partecipazione['percentuale'];
        foreach($partecipazione['partecipazioni'] as $curPart)
        {
            $partecipazione_tot+=$curPart['percentuale'];
        }
        if($partecipazione_tot+AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_percentuale'])),2,".") > 100)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("La somma delle partecipazioni dirette ed indirette non puo' superare il 100%.",false);
            return false;
        }
       
        $partecipazione['partecipazioni'][$_REQUEST['organismo']]=array(
            "denominazione"=>$organismoPartecipante->GetDenominazione(),
            "percentuale"=>AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_percentuale'])),2,"."),
            "euro"=>AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_euro'])),2,".")
        );
        $organismo->SetPartecipazione(json_encode($partecipazione));
       
        //Salva i dati
        if(!$organismo->UpdateDb($this->oUser,null,true," Aggiunta nuova partecipazione (".$organismoPartecipante->GetDenominazione().")"))
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError(AA_Log::$lastErrorLog,false);

            return false;       
        }

        $task->SetStatus(AA_GenericModuleTask::AA_STATUS_SUCCESS);
        $task->SetContent("Dati aggiornati con successo.",false);
        
        return true;
    }

    //Task aggiorna partecipazione
    public function Task_UpdateSinesPartecipazione($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $organismoPartecipante=new AA_Organismi($_REQUEST['organismo'],$this->oUser);

        if(!$organismoPartecipante->isValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Organismo partecipante non valido.",false);
            return false;            
        }

        $partecipazione=$organismo->GetPartecipazione(true);
        if(!isset($partecipazione['partecipazioni'])) $partecipazione['partecipazioni']=array();
        
        //verifica percentuali partecipazione
        $partecipazione_tot=$partecipazione['percentuale'];
        foreach($partecipazione['partecipazioni'] as $idOrg=>$curPart)
        {
            if($idOrg!=$_REQUEST['organismo']) $partecipazione_tot+=$curPart['percentuale'];
        }
        if($partecipazione_tot+AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_percentuale'])),2,".") > 100)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("La somma delle partecipazioni dirette ed indirette non puo' superare il 100%.",false);
            return false;
        }

        $partecipazione['partecipazioni'][$_REQUEST['organismo']]=array(
            "denominazione"=>$organismoPartecipante->GetDenominazione(),
            "percentuale"=>AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_percentuale'])),2,"."),
            "euro"=>AA_Utils::number_format(str_replace(",",".",str_replace(".","",$_REQUEST['Partecipazione_euro'])),2,".")
        );
        $organismo->SetPartecipazione(json_encode($partecipazione));
       
        //Salva i dati
        if(!$organismo->UpdateDb($this->oUser,null,true," Aggionamento partecipazione (".$organismoPartecipante->GetDenominazione().")"))
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError(AA_Log::$lastErrorLog,false);

            return false;       
        }

        $task->SetStatus(AA_GenericModuleTask::AA_STATUS_SUCCESS);
        $task->SetContent("Dati aggiornati con successo.",false);
        
        return true;
    }

    //Task aggiorna partecipazione
    public function Task_TrashSinesPartecipazione($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $organismoPartecipante=new AA_Organismi($_REQUEST['id_org'],$this->oUser);

        if(!$organismoPartecipante->isValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Organismo partecipante non valido.",false);
            return false;            
        }

        $partecipazione=$organismo->GetPartecipazione(true);
        if(!isset($partecipazione['partecipazioni'])) $partecipazione['partecipazioni']=array();
        
        if(isset($partecipazione['partecipazioni'][$_REQUEST['id_org']]))
        unset($partecipazione['partecipazioni'][$_REQUEST['id_org']]);
        $organismo->SetPartecipazione(json_encode($partecipazione));
       
        //Salva i dati
        if(!$organismo->UpdateDb($this->oUser,null,true," Rimozione partecipazione per ".$organismoPartecipante->GetDenominazione().""))
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError(AA_Log::$lastErrorLog,false);

            return false;       
        }

        $task->SetStatus(AA_GenericModuleTask::AA_STATUS_SUCCESS);
        $task->SetContent("Dati aggiornati con successo.",false);
        
        return true;
    }
    
    //Task Aggiungi dato contabile
    public function Task_AddNewOrganismoIncarico($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati
        $new_dato=AA_OrganismiNomine::AddNewToDb($_REQUEST,$organismo,$this->oUser);
        
        if(!($new_dato instanceof AA_OrganismiNomine))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError(AA_Log::$lastErrorLog,false);

            return false;       
        }
        
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent("Incarico inserito con successo (identificativo: ".$new_dato->GetId().").",false);

        if(!empty($_REQUEST['detail']))
        {
            //apri la pagina di dettaglio dell'incarico
            $task->SetStatusAction("dlg",array("task"=>"GetOrganismoNominaDetailViewDlg","params"=>array("id"=>$organismo->GetId(),"id_incarico"=>$new_dato->GetId())),true);
        }

        return true;
    }
    
    //Task Aggiungi dato contabile
    public function Task_AddNewOrganismoOrganigramma($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati
        $newOrganigramma=new AA_Organismi_Organigramma($_REQUEST);
        $new_dato=$organismo->AddNewOrganigramma($newOrganigramma);
        if($new_dato==0)
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status' id_Rec='".$new_dato."'>0</status><content id='content'>";
        $sTaskLog.= "Organigramma inserito con successo (identificativo: ".$new_dato.").";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task Aggiungi incarico all'organigramma
    public function Task_AddNewOrganismoOrganigrammaIncarico($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati        
        $incarico=$incarico=new AA_Organismi_Organigramma_Incarico($_REQUEST);
        $new_dato=$organismo->AddNewOrganigrammaIncarico($incarico,$_REQUEST['id_organigramma']);
        if($new_dato==0)
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }

        $sTaskLog="<status id='status' id_Rec='".$new_dato."'>0</status><content id='content'>";
        $sTaskLog.= "Incarico inserito con successo (identificativo: ".$new_dato.").";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task modifica incarico dell'organigramma
    public function Task_UpdateOrganismoOrganigrammaIncarico($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati        
        $incarico=new AA_Organismi_Organigramma_Incarico($_REQUEST);
        $incarico->SetProp("id",$_REQUEST['id_incarico']);

        AA_Log::Log(__METHOD__." - incarico: ".print_r($incarico,TRUE),100);

        $new_dato=$organismo->UpdateOrganigrammaIncarico($incarico,$_REQUEST['id_organigramma']);
        if($new_dato==0)
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }

        $sTaskLog="<status id='status' id_Rec='".$new_dato."'>0</status><content id='content'>";
        $sTaskLog.= "Incarico aggiornato con successo (identificativo: ".$new_dato.").";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task Aggiungi dato contabile
    public function Task_AddNewOrganismoIncaricoDoc($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $task->SetError("Identificativo organismo o incarico non validi. (".$_REQUEST['id'].",".$_REQUEST['id_incarico'].")");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo o incarico non validi. (".$_REQUEST['id'].",".$_REQUEST['id_incarico'].")</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $file = AA_SessionFileUpload::Get("NewIncaricoDoc");
        
        if(!$file->isValid() || $_REQUEST['anno'] == "" || $_REQUEST['tipo'] == "")
        {
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($file->GetValue(),true)." - ".print_r($_REQUEST,true),100);
            $task->SetError("Parametri non validi: ".print_r($file,true)." - ".print_r($_REQUEST,true));
            $sTaskLog="<status id='status'>-1</status><error id='error'>Parametri non validi: ".print_r($file->GetValue(),true)." - ".print_r($_REQUEST,true)."</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
        
        $filespecs=$file->GetValue();
        
        if(!AA_OrganismiNomineDocument::UploadDoc($incarico, $_REQUEST['anno'], $_REQUEST['tipo'],$filespecs['tmp_name'], true, $this->oUser))
        {        
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio del documento. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Documento caricato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task Aggiungi dato contabile
    public function Task_AddNewOrganismoProvvedimento($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido. (".$_REQUEST['id'].")");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido. (".$_REQUEST['id'].")</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $file = AA_SessionFileUpload::Get("NewProvvedimentoDoc");
        
        if(!$file->isValid() && $_REQUEST['url'] == "")
        {   
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($file,true)." - ".print_r($_REQUEST,true),100);
            $task->SetError("Parametri non validi occorre indicare un url o un file.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Parametri non validi: occorre indicare un url o un file.</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
        
        $provvedimento=new AA_OrganismiProvvedimenti(0,$organismo->GetID(),$_REQUEST['tipo'],$_REQUEST['url'],$_REQUEST['anno'],$_REQUEST['estremi']);
        AA_Log::Log(__METHOD__." - "."Provvedimento: ".print_r($provvedimento, true),100);
        
        if($file->isValid()) $filespec=$file->GetValue();
        else $filespec=array();
        
        if(!$organismo->AddNewProvvedimento($provvedimento, $filespec['tmp_name'], $this->oUser))
        {        
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio del provvedimento. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Provvedimento caricato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task Modifica provvedimento
    public function Task_UpdateOrganismoProvvedimento($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido. (".$_REQUEST['id'].")");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido. (".$_REQUEST['id'].")</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $file = AA_SessionFileUpload::Get("NewProvvedimentoDoc");
        $provvedimento=new AA_OrganismiProvvedimenti($_REQUEST['id_provvedimento'],$organismo->GetID(),$_REQUEST['tipo'],$_REQUEST['url'],$_REQUEST['anno'],$_REQUEST['estremi']);
        
        if(!$file->isValid() && $_REQUEST['url'] == "" && !is_file($provvedimento->GetFilePath()))
        {   
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($file,true)." - ".print_r($_REQUEST,true),100);
            $task->SetError("Parametri non validi occorre indicare un url o un file.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Parametri non validi: occorre indicare un url o un file.</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
        
        if($file->isValid()) $filespec=$file->GetValue();
        else $filespec=array();
        
        if(!$organismo->UpdateProvvedimento($provvedimento, $filespec['tmp_name'], $this->oUser))
        {        
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio del provvedimento. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Provvedimento aggiornato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task Elimina provvedimento
    public function Task_TrashOrganismoProvvedimento($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido. (".$_REQUEST['id'].")");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido. (".$_REQUEST['id'].")</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        if(!$organismo->DeleteProvvedimento($_REQUEST['id_provvedimento'],$this->oUser))
        {        
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nell'eliminazione del provvedimento. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Provvedimento rimosso.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task Aggiungi compenso
    public function Task_AddNewOrganismoIncaricoCompenso($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $task->SetError("Identificativo organismo o incarico non validi. (".$_REQUEST['id'].",".$_REQUEST['id_incarico'].")");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo o incarico non validi. (".$_REQUEST['id'].",".$_REQUEST['id_incarico'].")</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        if($_REQUEST['anno'] == "")
        {
            AA_Log::Log(__METHOD__." - "."Parametri non validi: ".print_r($_REQUEST,true),100);
            $task->SetError("Parametro anno non valido.");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Parametro anno non valido.</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }

        $compenso=new AA_OrganismiNomineCompensi(0,$_REQUEST['anno'],$_REQUEST['parte_fissa'],$_REQUEST['parte_variabile'],$_REQUEST['rimborsi'],$_REQUEST['note']);
                
        if(!$incarico->AddNewCompenso($compenso, $this->oUser))
        {        
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio del compenso. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Compenso aggiunto con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task modifica dato contabile
    public function Task_UpdateOrganismoDatoContabile($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $dato=new AA_OrganismiDatiContabili($_REQUEST["id_dato_contabile"],null,$this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(!$dato->isValid())
        {
            $task->SetError("Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Aggiorna i dati
        if(!$dato->ParseData($_REQUEST))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel parsing dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati
        if(!$dato->UpdateDb($this->oUser,null,true," Aggiornamento dati contabili (anno ".$dato->GetAnno().")"))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salavataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status' id_Rec='".$dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Dato contabile aggiornato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiorna incarico
    public function Task_UpdateOrganismoIncarico($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST["id_incarico"],null,$this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(!$incarico->isValid())
        {
            $task->SetError("Identificativo nomina non valido: ".$_REQUEST['id_incarico']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo nomina non valido: ".$_REQUEST['id_nomina']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Aggiorna i dati
        if(!$incarico->ParseData($_REQUEST))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel parsing dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Salva i dati
        if(!$incarico->UpdateDb($this->oUser,null,true,"Aggiornamento incarico di ".$incarico->GetTipologia()." per : ".$incarico->GetNome()." ".$incarico->GetCognome()))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;       
        }
        
        $sTaskLog="<status id='status' id_Rec='".$incarico->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Incarico aggiornato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task aggiorna incarico
    public function Task_UpdateOrganismoOrganigramma($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        $organigramma=$organismo->GetOrganigramma($_REQUEST['id_organigramma']);
        if(!($organigramma instanceof AA_Organismi_Organigramma))
        {
            $task->SetError("Identificativo organigramma non valido: ".$_REQUEST['id_organigramma']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organigramma non valido: ".$_REQUEST['id_organigramma']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Aggiorna i dati
        $organigramma->SetProp('tipo',$_REQUEST['tipo']);
        $organigramma->SetProp('note',$_REQUEST['note']);
        $organigramma->SetProp('ordine',$_REQUEST['ordine']);
        $organigramma->SetProp('enable_scadenzario',$_REQUEST['enable_scadenzario']);

        if(!$organismo->UpdateOrganigramma($organigramma))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nel salvataggio dei dati. (".AA_Log::$lastErrorLog.")</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status' id_Rec='".$organigramma->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Organigramma aggiornato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiorna nomine
    public function Task_RenameOrganismoNomina($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if($_REQUEST['ids']=="" || trim($_REQUEST['sNome'])=="" || trim($_REQUEST['sCognome'])=="" || trim($_REQUEST['sCodiceFiscale']==""))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Dati nomina non validi (nome, cognome o codice fiscale assenti).</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        //Aggiorna i dati
        $db= new AA_Database();
        $query="UPDATE ".AA_Organismi_Const::AA_ORGANISMI_NOMINE_DB_TABLE." set nome='".addslashes(trim($_REQUEST['sNome']))."', cognome='".addslashes(trim($_REQUEST['sCognome']))."', codice_fiscale='".addslashes(trim($_REQUEST['sCodiceFiscale']))."' " ;
        $query.=" WHERE id in (".addslashes($_REQUEST['ids']).")";
        $query.=" AND id_organismo='".addslashes($_REQUEST['id'])."'";
        
        AA_Log::Log(__METHOD__." - ".$query,100);
        
        if(!$db->Query($query))
        {
            $task->SetError($db->GetLastErrorMessage());
            $sTaskLog="<status id='status'>-1</status><error id='error'>Errore nell'aggiornamento dei dati. (".$db->GetLastErrorMessage().")</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status'>0</status><content id='content'>";
        $sTaskLog.= "Nomine aggiornate con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task modifica bilancio
    public function Task_UpdateOrganismoBilancio($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $dato=new AA_OrganismiDatiContabili($_REQUEST["id_dato_contabile"],null,$this->oUser);

        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(!$dato->isValid())
        {
            $task->SetError("Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $bilancio=new AA_OrganismiBilanci();
        $bilancio->SetIdDatiContabili($dato->GetId());
        $bilancio->SetTipo($_REQUEST['nTipologia']);
        $bilancio->SetRisultati($_REQUEST['sRisultati']);
        $bilancio->SetNote($_REQUEST['sNote']);
        $bilancio->SetId($_REQUEST['id_bilancio']);

        //Aggiorna i dati
        if(!$dato->UpdateBilancio($bilancio,$this->oUser))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status' id_Rec='".$dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Bilancio aggiornato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task trash bilancio
    public function Task_TrashOrganismoBilancio($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $dato=new AA_OrganismiDatiContabili($_REQUEST["id_dato_contabile"],null,$this->oUser);

        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(!$dato->isValid())
        {
            $task->SetError("Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        if($_REQUEST['id_bilancio']=="")
        {
            $task->SetError("identificativo bilancio non impostato");
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo bilancio non impostato.</error>";
            $task->SetLog($sTaskLog);
            return false;
        }
       
        //Aggiorna i dati
        if(!$dato->DelBilancio($_REQUEST['id_bilancio'],$this->oUser))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status' id_Rec='".$dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Bilancio eliminato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task trash dato contabile
    public function Task_TrashOrganismoDatoContabile($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $dato=new AA_OrganismiDatiContabili($_REQUEST["id_dato_contabile"],null,$this->oUser);

        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(!$dato->isValid())
        {
            $task->SetError("Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
       
        //Elimina i dati
        if(!$dato->Trash($this->oUser))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status' id_Rec='".$dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Dato contabile eliminato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task trash incarico
    public function Task_TrashOrganismoIncarico($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $dato=new AA_OrganismiNomine($_REQUEST["id_incarico"],null,$this->oUser);

        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(!$dato->isValid())
        {
            $task->SetError("Identificativo incarico non valido: ".$_REQUEST['id_incarico']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo incarico non valido: ".$_REQUEST['id_incarico']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
       
        //Elimina i dati
        if(!$dato->Trash($this->oUser))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent("Incarico eliminato con successo.",false);
        $task->SetStatusAction("CloseNominaDetailWnd",array("wnd"=>static::AA_UI_PREFIX."_".static::AA_UI_WND_NOMINA_DETAIL."_Wnd"),true);
        
        return true;
    }

    //Task trash organigramma
    public function Task_DeleteOrganismoOrganigramma($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }

        $dato=$organismo->GetOrganigramma($_REQUEST["id_organigramma"]);
        if($dato == null)
        {
            $task->SetError("Identificativo organigramma non valido: ".$_REQUEST['id_incarico']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organigramma non valido: ".$_REQUEST['id_organigramma']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
       
        //Elimina i dati
        if(!$organismo->DeleteOrganigramma($_REQUEST['id_organigramma']))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status' id_Rec='".$dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Organigramma eliminato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task trash organigramma
    public function Task_DeleteOrganismoOrganigrammaIncarico($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }

        $dato=$organismo->GetOrganigramma($_REQUEST["id_organigramma"]);
        if($dato == null)
        {
            $task->SetError("Identificativo organigramma non valido: ".$_REQUEST['id_organigramma']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organigramma non valido: ".$_REQUEST['id_organigramma']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
       
        $incarico=AA_Organismi_Organigramma_Incarico::LoadFromDb($_REQUEST['id_incarico']);
        if($incarico == null)
        {
            $task->SetError("Identificativo incarico non valido: ".$_REQUEST['id_incarico']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo incarico non valido: ".$_REQUEST['id_incarico']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }

        if($incarico->GetProp("id_organigramma") != $dato->GetId())
        {
            $task->SetError("Identificativo incarico non valido: ".$_REQUEST['id_incarico']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo incarico non valido: ".$_REQUEST['id_incarico']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }

        //Elimina i dati
        if(!$organismo->DeleteOrganigrammaIncarico($_REQUEST['id_organigramma'], $_REQUEST['id_incarico']))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status' id_Rec='".$dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Incarico eliminato con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiungi bilancio
    public function Task_AddNewOrganismoBilancio($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        $dato=new AA_OrganismiDatiContabili($_REQUEST["id_dato_contabile"],null,$this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetError("Identificativo organismonon valido: ".$_REQUEST['id']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo organismo non valido: ".$_REQUEST['id']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(!$dato->isValid())
        {
            $task->SetError("Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']);
            $sTaskLog="<status id='status'>-1</status><error id='error'>Identificativo dato contabile non valido: ".$_REQUEST['id_dato_contabile']."</error>";
            $task->SetLog($sTaskLog);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione());
            $sTaskLog="<status id='status'>-1</status><error id='error'>L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione()."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $bilancio=new AA_OrganismiBilanci();
        $bilancio->SetIdDatiContabili($dato->GetId());
        $bilancio->SetTipo($_REQUEST['nTipologia']);
        $bilancio->SetRisultati($_REQUEST['sRisultati']);
        $bilancio->SetNote($_REQUEST['sNote']);
        
        //Aggiorna i dati
        if(!$dato->AddNewBilancio($bilancio))
        {
            $task->SetError(AA_Log::$lastErrorLog);
            $sTaskLog="<status id='status'>-1</status><error id='error'>".AA_Log::$lastErrorLog."</error>";
            $task->SetLog($sTaskLog);

            return false;            
        }
        
        $sTaskLog="<status id='status' id_Rec='".$dato->GetId()."'>0</status><content id='content'>";
        $sTaskLog.= "Bilancio aggiunto con successo.";
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task aggiungi bilancio
    public function Task_GetSinesAddNewPartecipazioneDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id'],false);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione(),false);
           
            return false;            
        }
        
        $task->SetStatus(AA_GenericModuleTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetSinesAddNewPartecipazioneDlg($organismo),true);
        
        return true;
    }

    //Task modify partecipazione dlg
    public function Task_GetSinesModifyPartecipazioneDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id'],false);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione(),false);
           
            return false;            
        }

        $organismoPartecipante=new AA_Organismi($_REQUEST['id_org'],$this->oUSer);
        if(!$organismoPartecipante->IsValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Organismo partecipante non valido",false);
           
            return false;            
        }

        $task->SetStatus(AA_GenericModuleTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetSinesModifyPartecipazioneDlg($organismo,$_REQUEST['id_org']),true);
        
        return true;
    }

    //Task modify partecipazione dlg
    public function Task_GetSinesTrashPartecipazioneDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo=new AA_Organismi($_REQUEST['id'], $this->oUser);
        if(!$organismo->isValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Identificativo organismo non valido: ".$_REQUEST['id'],false);

            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE)==0)
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("L'utente corrente (".$this->oUser->GetName().") non ha i privileggi per modificare l'organismo: ".$organismo->GetDenominazione(),false);
           
            return false;            
        }

        $organismoPartecipante=new AA_Organismi($_REQUEST['id_org'],$this->oUSer);
        if(!$organismoPartecipante->IsValid())
        {
            $task->SetStatus(AA_GenericModuleTask::AA_STATUS_FAILED);
            $task->SetError("Organismo partecipante non valido",false);
           
            return false;            
        }

        $task->SetStatus(AA_GenericModuleTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetSinesTrashPartecipazioneDlg($organismo,$_REQUEST['id_org']),true);
        
        return true;
    }
        
    //Task sections
    public function Task_GetSections($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $sTaskLog.= $this->GetSections("base64");
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task modifica organismo
    public function Task_GetOrganismoModifyDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        else
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoModifyDlg($organismo)->toBase64();
            $sTaskLog.="</content>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task resume organismo
    public function Task_GetOrganismoResumeDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per ripristinare organismi.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoResumeDlg($_REQUEST)->toBase64();
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
    
    //Task publish organismo
    public function Task_GetOrganismoPublishDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per pubblicare organismi.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoPublishDlg($_REQUEST)->toBase64();
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
    
    //Task resume organismo
    public function Task_GetOrganismoReassignDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per riassegnare organismi.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoReassignDlg($_REQUEST)->toBase64();
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
    public function Task_GetOrganismoTrashDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per cestinare/eliminare organismi.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        if($_REQUEST['ids']!="")
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashDlg($_REQUEST)->toBase64();
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
    
    //Task elimina bilancio dlg
    public function Task_GetOrganismoTrashBilancioDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $dato_contabile=new AA_OrganismiDatiContabili($_REQUEST['id_dato_contabile'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$dato_contabile->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o dato contabile non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $bilancio=$dato_contabile->GetBilancio($_REQUEST['id_bilancio'],$this->oUser);
        if(!($bilancio instanceof AA_OrganismiBilanci))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Identificativo di bilancio non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashBilancioDlg($organismo, $dato_contabile,$bilancio)->toBase64();
            $sTaskLog.="</content>";
            $task->SetLog($sTaskLog);
        
            return true;
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        return true;
    }
    
    //Task elimina incarico dlg
    public function Task_GetOrganismoTrashIncaricoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashIncaricoDlg($organismo, $incarico)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task elimina incarico dlg
    public function Task_GetOrganismoDeleteOrganigrammaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $organigramma=$organismo->GetOrganigramma($_REQUEST['id_organigramma']);
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0 && $organigramma instanceof AA_Organismi_Organigramma)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoDeleteOrganigrammaDlg($organismo, $organigramma)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task elimina incarico dlg
    public function Task_GetOrganismoDeleteOrganigrammaIncaricoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }

        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $organigramma=$organismo->GetOrganigramma($_REQUEST['id_organigramma']);
        if(!($organigramma instanceof AA_Organismi_Organigramma))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo organigramma non valido.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $incarico=AA_Organismi_Organigramma_Incarico::LoadFromDb($_REQUEST['id_incarico']);
        if($incarico == null)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo incarico non valido.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        if($incarico->GetProp("id_organigramma") != $organigramma->GetId())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo incarico non valido.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $sTaskLog.= $this->Template_GetOrganismoDeleteOrganigrammaIncaricoDlg($organismo, $organigramma,$incarico)->toBase64();
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task elimina incarico doc dlg
    public function Task_GetOrganismoTrashIncaricoDocDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $doc = AA_OrganismiNomineDocument::GetDoc($incarico, $_REQUEST['anno'], $_REQUEST['tipo'], $_REQUEST['serial'], $this->oUser);
        if(!$doc->IsValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Parametri documento non validi.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashIncaricoDocDlg($organismo, $incarico,$doc)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task elimina incarico compenso dlg
    public function Task_GetOrganismoTrashIncaricoCompensoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
       
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $compenso = $incarico->GetCompenso($_REQUEST['id_compenso'],"",$this->oUser);
        if(!($compenso instanceof AA_OrganismiNomineCompensi))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Parametri compenso non validi.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashIncaricoCompensoDlg($organismo, $incarico,$compenso)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task modifica incarico compenso dlg
    public function Task_GetOrganismoModifyIncaricoCompensoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
       
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $compenso = $incarico->GetCompenso($_REQUEST['id_compenso'],"",$this->oUser);
        if(!($compenso instanceof AA_OrganismiNomineCompensi))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Parametri compenso non validi.</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoModifyIncaricoCompensoDlg($organismo, $incarico,$compenso)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task elimina incarico doc
    public function Task_TrashOrganismoIncaricoDoc($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
            
            return false;
        }

        $doc = AA_OrganismiNomineDocument::GetDoc($incarico,$_REQUEST['anno'], $_REQUEST['tipo'], $_REQUEST['serial'],$this->oUser);
        
        if(!$doc->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo documento non corretto.</error>";
            
            $task->SetLog($sTaskLog);
             
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            if($incarico->DelDoc($_REQUEST['anno'],$_REQUEST['tipo'],$_REQUEST['serial'],$this->oUser))
            {
                $sTaskLog="<status id='status'>0</status><content id='content'>";
                $sTaskLog.="Documento eliminato.";
                $sTaskLog.="</content>";
                
                $task->SetLog($sTaskLog);
                 
                return true;
            }
            else
            {
                $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
                $sTaskLog.= "{}";
                $sTaskLog.="</content><error id='error'>Errore durate l'eliminazione del documento (".AA_Log::$lastErrorLog.").</error>";

                $task->SetLog($sTaskLog);

                return false;
            }
            
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        return true;
    }
    
    //Task elimina incarico compenso
    public function Task_TrashOrganismoIncaricoCompenso($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
            
            return false;
        }

        $compenso = $incarico->GetCompenso($_REQUEST['id_compenso'],"",$this->oUser);
        
        if(!($compenso instanceof AA_OrganismiNomineCompensi))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo compenso non corretto.</error>";
            
            $task->SetLog($sTaskLog);
             
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            if($incarico->TrashCompenso($_REQUEST['id_compenso'],$this->oUser))
            {
                $sTaskLog="<status id='status'>0</status><content id='content'>";
                $sTaskLog.="Compenso eliminato.";
                $sTaskLog.="</content>";
                
                $task->SetLog($sTaskLog);
                 
                return true;
            }
            else
            {
                $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
                $sTaskLog.= "{}";
                $sTaskLog.="</content><error id='error'>Errore durate l'eliminazione del documento (".AA_Log::$lastErrorLog.").</error>";

                $task->SetLog($sTaskLog);

                return false;
            }
            
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        return true;
    }
    
    //Task aggiorna incarico compenso
    public function Task_UpdateOrganismoIncaricoCompenso($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
            
            $task->SetLog($sTaskLog);
            
            return false;
        }

        $compenso = $incarico->GetCompenso($_REQUEST['id_compenso'],"",$this->oUser);
        
        if(!($compenso instanceof AA_OrganismiNomineCompensi))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo compenso non corretto.</error>";
            
            $task->SetLog($sTaskLog);
             
            return false;
        }
        
        $compenso= new AA_OrganismiNomineCompensi($_REQUEST['id_compenso'],$_REQUEST['anno'],$_REQUEST['parte_fissa'],$_REQUEST['parte_variabile'],$_REQUEST['rimborsi'],$_REQUEST['note']);
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            if($incarico->UpdateCompenso($compenso,$this->oUser))
            {
                $sTaskLog="<status id='status'>0</status><content id='content'>";
                $sTaskLog.="Compenso aggiornato.";
                $sTaskLog.="</content>";
                
                $task->SetLog($sTaskLog);
                 
                return true;
            }
            else
            {
                $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
                $sTaskLog.= "{}";
                $sTaskLog.="</content><error id='error'>Errore durate l'eliminazione del documento (".AA_Log::$lastErrorLog.").</error>";

                $task->SetLog($sTaskLog);

                return false;
            }
            
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        return true;
    }
    
    //Task aggiungi doc incarico dlg
    public function Task_GetOrganismoAddNewIncaricoDocDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewIncaricoDocDlg($organismo, $incarico)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiungi compenso incarico dlg
    public function Task_GetOrganismoAddNewIncaricoCompensoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o incarico non valido o permessi insufficienti.</error>";
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewIncaricoCompensoDlg($organismo, $incarico)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task aggiungi organigramma dlg
    public function Task_GetOrganismoAddNewOrganigrammaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }
                
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewOrganigrammaDlg($organismo)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task modifica organigramma
    public function Task_GetOrganismoModifyOrganigrammaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        $organigramma=$organismo->GetOrganigramma($_REQUEST['id_organigramma']);
        if(!($organigramma instanceof AA_Organismi_Organigramma))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo organigramma non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }

        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoModifyOrganigrammaDlg($organismo,$organigramma)->toBase64();
            $sTaskLog.="</content>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task elimina bilancio dlg
    public function Task_GetOrganismoTrashDatoContabileDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $dato_contabile=new AA_OrganismiDatiContabili($_REQUEST['id_dato_contabile'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$dato_contabile->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o dato contabile non valido o permessi insufficienti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashDatoContabileDlg($organismo, $dato_contabile)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task elimina organismo
    public function Task_GetOrganismoDeleteDlg($task)
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
            $sTaskLog.= $this->Template_GetOrganismoDeleteDlg($_REQUEST)->toBase64();
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
    
    //Task aggiunta organismo
    public function Task_GetOrganismoAddNewDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
       
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per istanziare nuovi organismi.</error>";
        }
        else
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewDlg()->toBase64();
            $sTaskLog.="</content>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task modifica dato contabile
    public function Task_GetOrganismoModifyDatoContabileDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $dato_contabile=new AA_OrganismiDatiContabili($_REQUEST['id_dato_contabile'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$dato_contabile->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o dato contabile non valido o permessi insufficienti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoModifyDatoContabileDlg($organismo, $dato_contabile)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiungi dato contabile
    public function Task_GetOrganismoAddNewDatoContabileDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewDatoContabileDlg($organismo)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiungi dato contabile
    public function Task_GetOrganismoAddNewOrganigrammaIncaricoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }
        
        $organigramma=$organismo->GetOrganigramma($_REQUEST['id_organigramma']);

        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0 && $organigramma != null) 
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewOrganigrammaIncaricoDlg($organismo,$organigramma)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            if($organigramma ==null)
            {
                $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
                $sTaskLog.= "{}";
                $sTaskLog.="</content><error id='error'>identificativo organigramma non valido (".$_REQUEST['id_organigramma'].").</error>";    
            }
            else
            {
                $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
                $sTaskLog.= "{}";
                $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";    
            }
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task modifica incarico dell'organigramma
    public function Task_GetOrganismoModifyOrganigrammaIncaricoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }

        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) == 0) 
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
    
            $task->SetLog($sTaskLog);
            return false;
        }

        $organigramma=$organismo->GetOrganigramma($_REQUEST['id_organigramma']);
        if($organigramma==null)
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo organigramma non valido (".$_REQUEST['id_organigramma'].").</error>";
            $task->SetLog($sTaskLog);
            return false; 
        }

        $incarico =AA_Organismi_Organigramma_Incarico::LoadFromDb($_REQUEST['id_incarico']);
        if(!$incarico->IsValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativo incarico non valido (".$_REQUEST['id_incarico'].").</error>";
            $task->SetLog($sTaskLog);
            return false; 
        }

        //AA_Log::Log(__METHOD__." - incarico: ".print_r($incarico,TRUE),100);

        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $sTaskLog.= $this->Template_GetOrganismoModifyOrganigrammaIncaricoDlg($organismo,$organigramma,$incarico)->toBase64();
        $sTaskLog.="</content>";

        $task->SetLog($sTaskLog);
        
        return true;
    }

    //Task aggiungi dato contabile
    public function Task_GetOrganismoAddNewProvvedimentoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewProvvedimentoDlg($organismo)->toBase64();
            $sTaskLog.="</content>";
            $task->SetLog($sTaskLog);
        
            return true;
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            $task->SetLog($sTaskLog);
        
            return false;
        }
    }
    
    //Task modifica Provvedimento
    public function Task_GetOrganismoModifyProvvedimentoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
            return false;
        }
        
        $provvedimento=$organismo->GetProvvedimento($_REQUEST['id_provvedimento'], $this->oUser);
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0 && $provvedimento instanceof AA_OrganismiProvvedimenti)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoModifyProvvedimentoDlg($organismo,$provvedimento)->toBase64();
            $sTaskLog.="</content>";

            $task->SetLog($sTaskLog);
            
            return true;
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
    }
    
    //Task elimina Provvedimento
    public function Task_GetOrganismoTrashProvvedimentoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
            $task->SetLog($sTaskLog);
            return false;
        }
        
        $provvedimento=$organismo->GetProvvedimento($_REQUEST['id_provvedimento'], $this->oUser);
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0 && $provvedimento instanceof AA_OrganismiProvvedimenti)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashProvvedimentoDlg($organismo,$provvedimento)->toBase64();
            $sTaskLog.="</content>";

            $task->SetLog($sTaskLog);
            
            return true;
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
            $task->SetLog($sTaskLog);
            
            return false;
        }
    }
    
    //Task affluenza view Comune
    public function Task_GetOrganismoNominaDetailViewDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $object= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$object->isValid())
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Elemento non valido o permessi insufficienti.",false);
            return false;
        }

        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$object,$this->oUser);
        if(!($incarico->IsValid()))
        {
            $task->SetStatus(AA_GenericTask::AA_STATUS_FAILED);
            $task->SetError("Incarico non valido",false);
            return false;
        }
    
        $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
        $task->SetContent($this->Template_GetOrganismoNominaDetailViewDlg($object,$incarico),true);
        return true;
    }

    //Task modifica dato contabile
    public function Task_GetOrganismoModifyIncaricoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $incarico=new AA_OrganismiNomine($_REQUEST['id_incarico'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$incarico->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o dati nomina non validi o permessi insufficienti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoModifyIncaricoDlg($organismo, $incarico)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task modifica bilancio dlg
    public function Task_GetOrganismoModifyBilancioDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $dato_contabile=new AA_OrganismiDatiContabili($_REQUEST['id_dato_contabile'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$dato_contabile->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o dato contabile non valido o permessi insufficienti.</error>";
        }
        
        $bilancio=$dato_contabile->GetBilancio($_REQUEST['id_bilancio'],$this->oUser);
        if(!($bilancio instanceof AA_OrganismiBilanci))
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Identificativo di bilancio non valido o permessi insufficienti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoModifyBilancioDlg($organismo, $dato_contabile,$bilancio)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiungi bilancio
    public function Task_GetOrganismoAddNewBilancioDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        $dato_contabile=new AA_OrganismiDatiContabili($_REQUEST['id_dato_contabile'],$organismo,$this->oUser);
        
        if(!$organismo->isValid() || !$dato_contabile->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo o dato contabile non valido o permessi insufficienti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewBilancioDlg($organismo, $dato_contabile)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiungi dato contabile
    public function Task_GetOrganismoAddNewIncaricoDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }
        
        /*
        if(trim($_REQUEST['nome'])=="" || $_REQUEST['cognome']=="" || $_REQUEST['cf']=="")
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Dati nomina non validi (nome, cognome o codice fiscale assenti).</error>";
        }*/
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $params['nome']=trim($_REQUEST['nome']);
            $params['cognome']=trim($_REQUEST['cognome']);
            $params['cf']=trim($_REQUEST['cf']);
            
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewIncaricoDlg($organismo,$params)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
       
    //Task aggiungi dato contabile
    public function Task_GetOrganismoAddNewNominaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {   
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoAddNewNominaDlg($organismo)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task aggiungi dato contabile
    public function Task_GetOrganismoRenameNominaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }
        
        if($_REQUEST['ids'] =="" || trim($_REQUEST['nome'])=="" || trim($_REQUEST['cognome'])=="" || trim($_REQUEST['cf'])=="")
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Dati nomina non validi (nome, cognome o codice fiscale assenti).</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {
            $params['nome']=trim($_REQUEST['nome']);
            $params['cognome']=trim($_REQUEST['cognome']);
            $params['cf']=trim($_REQUEST['cf']);
            $params['ids']=$_REQUEST['ids'];
            
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoRenameNominaDlg($organismo,$params)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task elimina nomina dlg
    public function Task_GetOrganismoTrashNominaDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
        }
        
        if($_REQUEST['ids'] =="")
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativi nomine non validi o assensti.</error>";
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {                    
            $ids = json_decode($_REQUEST['ids']);
            $incarichi=array();
            foreach($ids as $curId)
            {
                $incarico=new AA_OrganismiNomine($curId,$organismo,$this->oUser);
                if($incarico->IsValid()) $incarichi[]=$incarico;
            }
            
            $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
            $sTaskLog.= $this->Template_GetOrganismoTrashNominaDlg($organismo,$incarichi)->toBase64();
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task elimina nomina
    public function Task_TrashOrganismoNomina($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $organismo= new AA_Organismi($_REQUEST['id'],$this->oUser);
        
        if(!$organismo->isValid())
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>Organismo non valido o permessi insufficienti.</error>";
            
             $task->SetLog($sTaskLog);
             return false;
        }
        
        if($_REQUEST['ids'] =="")
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>identificativi nomine non validi o assensti.</error>";
            
             $task->SetLog($sTaskLog);
             return false;
        }
        
        if(($organismo->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_WRITE) > 0)
        {                    
            $ids = json_decode($_REQUEST['ids']);
            $incarichi=array();
            foreach($ids as $curId)
            {
                $incarico=new AA_OrganismiNomine($curId,$organismo,$this->oUser);
                if($incarico->IsValid()) $incarichi[]=$incarico;
            }
            
            foreach($incarichi as $incarico)
            {
                if(!$incarico->Trash($this->oUser))
                {
                    $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
                    $sTaskLog.= "{}";
                    $sTaskLog.="</content><error id='error'>Errore durante l'eliminazione degli incarichi.</error>";
                    
                    $task->SetLog($sTaskLog);
                    return false;
                }
            }
            
            $sTaskLog="<status id='status'>0</status><content id='content'>";
            $sTaskLog.= "Nomina eliminata con successo.";
            $sTaskLog.="</content>";
        }
        else
        {
            $sTaskLog="<status id='status'>-1</status><content id='content' type='json'>";
            $sTaskLog.= "{}";
            $sTaskLog.="</content><error id='error'>L'utente corrente non ha i permessi per poter modificare l'organismo (".$organismo->GetDenominazione().").</error>";
        }
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    
    //Task filter dlg
    public function Task_GetPubblicateFilterDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $content=$this->TemplatePubblicateFilterDlg();
        $sTaskLog.= base64_encode($content);
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task filter dlg
    public function Task_GetBozzeFilterDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $content=$this->TemplateBozzeFilterDlg();
        $sTaskLog.= base64_encode($content);
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task filter dlg
    public function Task_GetScadenzarioFilterDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $content=$this->TemplateScadenzarioFilterDlg();
        $sTaskLog.= base64_encode($content);
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task filter nomine
    public function Task_GetOrganismoNomineFilterDlg($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $content=$this->Template_GetOrganismoNomineFilterDlg(null,$_REQUEST['filter_id']);
        $sTaskLog.= base64_encode($content);
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task filter dlg
    public function Task_GetObjectData($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        
        $objectData=array(array());
        
        switch($_REQUEST['object'])
        {
            case static::AA_UI_PREFIX."_Pubblicate_List_Box":
                $_REQUEST['count']=10;
                $data=$this->GetDataSectionPubblicate_List($_REQUEST);
                if($data[0]>0) $objectData = $data[1];
                break;

            case static::AA_UI_PREFIX."_Bozze_List_Box":
                $_REQUEST['count']=10;
                $data=$this->GetDataSectionBozze_List($_REQUEST);
                if($data[0]>0) $objectData = $data[1];
                break;
                
            case static::AA_UI_PREFIX."_Scadenzario_List_Box":
                $_REQUEST['count']=10;
                $data=$this->GetDataSectionScadenzario_List($_REQUEST);
                if($data[0]>0) $objectData = $data[1];
                break;
                
            default:
                $objectData=array();
        }
        
        $sTaskLog.= base64_encode(json_encode($objectData));
        $sTaskLog.="</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Task NavBarContent
    public function Task_GetNavbarContent($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        
        $content=array();
        
        //Istanza del modulo
        $module= AA_SinesModule::GetInstance();
        
        if(!$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22_ADMIN) && !$this->oUser->HasFlag(AA_Const::AA_USER_FLAG_ART22))
        {
            $_REQUEST['section']=static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX;
        }
        
        switch($_REQUEST['section'])
        {
            case static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX:
                $content[]=$module->TemplateNavbar_Pubblicate(1,true)->toArray();
                //$content[]=$module->TemplateNavbar_Revisionate(2,true)->toArray();
                break;
            case static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX:
                //$content[]=$module->TemplateNavbar_Revisionate()->toArray();
                $content[]=$module->TemplateNavbar_Bozze(1,false)->toArray();
                $content[]=$module->TemplateNavbar_Scadenzario(2,true)->toArray();
                break;
            case static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX:
                $content[]=$module->TemplateNavbar_Back(1,true)->toArray();
                break;
            default:
                $content[]=$module->TemplateNavbar_Pubblicate(1,false)->toArray();
                $content[]=$module->TemplateNavbar_Scadenzario(2,true)->toArray();
        }      
        
        $spacer=new AA_JSON_Template_Generic("navbar_spacer");
        $content[]= $spacer->toArray();
        
        $sTaskLog.=base64_encode(json_encode($content))."</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //TAsk section layout
    public function Task_GetSectionContent($task)
    {
        AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        
        switch($_REQUEST['section'])
        {
            case "Bozze":
            case static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX:
                $template=$this->TemplateSection_Bozze();
                $content=array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX,"content"=>$template->toArray());
                break;
            
            case "Pubblicate":
            case static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX:
                $template = $this->TemplateSection_Pubblicate();
                $content=array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX,"content"=>$template->toArray());
                break;
            
            case "Dettaglio":
            case static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX:
               $content=array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX,"content"=>$this->TemplateSection_Detail($_REQUEST)->toArray());
                break;
            
            default:
                 $content=array(array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX,"content"=>$this->TemplateSection_Placeholder()->toArray()));
        }
        
        //Codifica il contenuto in base64
        $sTaskLog.= base64_encode(json_encode($content))."</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
     //TAsk section layout
    public function Task_GetObjectContent($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());
        
        $sTaskLog="<status id='status'>0</status><content id='content' type='json' encode='base64'>";
        $content="";

        switch($_REQUEST['object'])
        {
            case "Bozze":
            case static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX:
                $template=$this->TemplateSection_Bozze();
                $content=array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_BOZZE_BOX,"content"=>$template->toArray());
                break;
            
            case "Pubblicate":
            case static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX:
                $template = $this->TemplateSection_Pubblicate();
                $content=array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX,"content"=>$template->toArray());
                break;
            
            case "Dettaglio":
            case static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX:
               $template=$this->TemplateSection_Detail($_REQUEST);
               $content=array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX,"content"=>$template->toArray());
                break;
            
            case "Scadenzario":
            case static::AA_UI_PREFIX."_Scadenzario_Content_Box":
                $template = $this->TemplateSection_Scadenzario();
                $content=array("id"=>static::AA_UI_PREFIX."_Scadenzario_Content_Box","content"=>$template->toArray());
                break;
            
            default:
                return $this->Task_GetGenericObjectContent($task, $_REQUEST);
                /*$content=array(
                    array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_PUBBLICATE_BOX,"content"=>$this->TemplateSection_Placeholder()->toArray()),
                    array("id"=>static::AA_UI_PREFIX."_".static::AA_UI_DETAIL_BOX,"content"=>$this->TemplateSection_Placeholder()->toArray()));*/
        }
        
        //AA_Log::Log(__METHOD__." - task: ".$task->GetName(),100);

        //Codifica il contenuto in base64
        $sTaskLog.= base64_encode(json_encode($content))."</content>";
        
        $task->SetLog($sTaskLog);
        
        return true;
    }
    
    //Template filtro di ricerca
    public function TemplatePubblicateFilterDlg()
    {
        //Valori runtime
        $formData=array("partecipazione"=>$_REQUEST['partecipazione'],"over65"=>$_REQUEST['over65'],"stato_organismo"=>$_REQUEST['stato_organismo'],"id_assessorato"=>$_REQUEST['id_assessorato'],"id_direzione"=>$_REQUEST['id_direzione'],"struct_desc"=>$_REQUEST['struct_desc'],"id_struct_tree_select"=>$_REQUEST['id_struct_tree_select'],"tipo"=>$_REQUEST['tipo'],"tipo_nomina"=>$_REQUEST['tipo_nomina'],"denominazione"=>$_REQUEST['denominazione'],"cestinate"=>$_REQUEST['cestinate'], "incaricato"=>$_REQUEST['incaricato']);
        
        //Valori default
        if($_REQUEST['tipo']=="") $formData['tipo']="0";
        if($_REQUEST['tipo_nomina']=="") $formData['tipo_nomina']="0";
        if($_REQUEST['struct_desc']=="") $formData['struct_desc']="Qualunque";
        if($_REQUEST['id_assessorato']=="") $formData['id_assessorato']=0;
        if($_REQUEST['id_direzione']=="") $formData['id_direzione']=0;
        if($_REQUEST['id_servizio']=="") $formData['id_servizio']=0;
        if($_REQUEST['cestinate']=="") $formData['cestinate']=0;
        if($_REQUEST['stato_organismo']=="") $formData['stato_organismo']=0;
        if($_REQUEST['over65']=="") $formData['over65']=0;
        if($_REQUEST['partecipazione']=="") $formData['partecipazione']=0;
        
        //Valori reset
        $resetData=array("partecipazione"=>0,"stato_organismo"=>0,"tipo_nomina"=>0,"id_assessorato"=>0,"id_direzione"=>0,"id_servizio"=>0, "struct_desc"=>"Qualunque","id_struct_tree_select"=>"","tipo"=>0,"denominazione"=>"","cestinate"=>0,"incaricato"=>"");
        
        //Azioni da eseguire dopo l'applicazione del filtro
        $applyActions="module.refreshCurSection()";
        
        $dlg = new AA_GenericFilterDlg(static::AA_UI_PREFIX."_Pubblicate_Filter", "Parametri di ricerca per le schede pubblicate",$this->GetId(),$formData,$resetData,$applyActions);
       
        $dlg->SetHeight(640);
        
        //Cestinate
        $dlg->AddSwitchBoxField("cestinate","Cestino",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede cestinate."));
        
        //Denominazione
        $dlg->AddTextField("denominazione","Denominazione/P.IVA",array("bottomLabel"=>"*Filtra in base alla denominazione o alla partita iva dell'organismo.", "placeholder"=>"Denominazione o piva..."));
        
        //Struttura
        $dlg->AddStructField(array("showAll"=>1,"hideServices"=>1,"targetForm"=>$dlg->GetFormId()),array("select"=>true),array("bottomLabel"=>"*Filtra in base alla struttura controllante."));
        
        //Tipologia
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoOrganismi() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("tipo","Tipologia",array("bottomLabel"=>"*Filtra in base alla tipologia dell'organismo.","options"=>$options,"value"=>"0"));
        
        //partecipazione
        $options=array(
            array("id"=>"0","value"=>"Qualunque"),
            array("id"=>"1","value"=>"Solo dirette"),
            array("id"=>"2","value"=>"Solo indirette"),
            array("id"=>"3","value"=>"Almeno dirette"),
            array("id"=>"4","value"=>"Almeno indirette"),
            array("id"=>"5","value"=>"Dirette e indirette")
        );
        $dlg->AddSelectField("partecipazione","Partecipazione",array("bottomLabel"=>"*Filtra in base al tipo di partecipazione RAS (solo societa').","options"=>$options,"value"=>"0"));
        
        //stato organismo
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetListaStatoOrganismi() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("stato_organismo","Stato",array("bottomLabel"=>"*Filtra in base allo stato dell'organismo.","options"=>$options,"value"=>"0"));

        //Tipo nomina
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoNomine() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("tipo_nomina","Tipo nomina",array("bottomLabel"=>"*Filtra in base alla tipologia della nomina.","options"=>$options,"value"=>"0"));

        //Nominato
        $dlg->AddTextField("incaricato","Nominato",array("bottomLabel"=>"*Filtra in base al nome, cognome o cf del nominato.", "placeholder"=>"nome, cognome o cf del nominato..."));
        
        //Over 65
        $dlg->AddSwitchBoxField("over65","Età nomine",array("onLabel"=>"solo over 65","bottomPadding"=>28,"offLabel"=>"tutti","bottomLabel"=>"*Mostra solo gli organismi con individui nominati che hanno 65 anni o più durante la durata dell'incarico."));

        $dlg->SetApplyButtonName("Filtra");

        return $dlg->GetObject();
    }
    
    //Template filtro di ricerca
    public function TemplateBozzeFilterDlg()
    {
        //Valori runtime
        $formData=array("partecipazione"=>$_REQUEST['partecipazione'],"over65"=>$_REQUEST['over65'],"stato_organismo"=>$_REQUEST['stato_organismo'],"id_assessorato"=>$_REQUEST['id_assessorato'],"id_direzione"=>$_REQUEST['id_direzione'],"struct_desc"=>$_REQUEST['struct_desc'],"id_struct_tree_select"=>$_REQUEST['id_struct_tree_select'],"tipo"=>$_REQUEST['tipo'],"tipo_nomina"=>$_REQUEST['tipo_nomina'],"denominazione"=>$_REQUEST['denominazione'],"cestinate"=>$_REQUEST['cestinate'], "incaricato"=>$_REQUEST['incaricato']);

        //Valori default
        if($_REQUEST['tipo']=="") $formData['tipo']="0";
        if($_REQUEST['tipo_nomina']=="") $formData['tipo_nomina']="0";
        if($_REQUEST['struct_desc']=="") $formData['struct_desc']="Qualunque";
        if($_REQUEST['id_assessorato']=="") $formData['id_assessorato']=0;
        if($_REQUEST['id_direzione']=="") $formData['id_direzione']=0;
        if($_REQUEST['id_servizio']=="") $formData['id_servizio']=0;
        if($_REQUEST['cestinate']=="") $formData['cestinate']=0;
        if($_REQUEST['stato_organismo']=="") $formData['stato_organismo']=0;
        if($_REQUEST['over65']=="") $formData['over65']=0;
        if($_REQUEST['partecipazione']=="") $formData['partecipazione']=0;
                
        //Valori reset
        $resetData=array("partecipazione"=>0,"stato_organismo"=>0,"tipo_nomina"=>0,"id_assessorato"=>0,"id_direzione"=>0,"id_servizio"=>0, "struct_desc"=>"Qualunque","id_struct_tree_select"=>"","tipo"=>0,"denominazione"=>"","cestinate"=>0,"incaricato"=>"");
        
        //Azioni da eseguire dopo l'applicazione del filtro
        $applyActions="module.refreshCurSection()";
        
        $dlg = new AA_GenericFilterDlg(static::AA_UI_PREFIX."_Bozze_Filter", "Parametri di ricerca per le bozze pubblicate",$this->GetId(),$formData,$resetData,$applyActions);
        
        $dlg->SetHeight(640);
                
        //Cestinate
        $dlg->AddSwitchBoxField("cestinate","Cestino",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le schede cestinate."));
        
        //Denominazione
        $dlg->AddTextField("denominazione","Denominazione/P.IVA",array("bottomLabel"=>"*Filtra in base alla denominazione o alla partita iva dell'organismo.", "placeholder"=>"Denominazione o piva..."));
        
        //Struttura
        $dlg->AddStructField(array("hideServices"=>1,"targetForm"=>$dlg->GetFormId()),array("select"=>true),array("bottomLabel"=>"*Filtra in base alla struttura controllante."));
        
        //Tipologia
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoOrganismi() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("tipo","Tipologia",array("bottomLabel"=>"*Filtra in base alla tipologia dell'organismo.","options"=>$options,"value"=>"0"));
        
        //partecipazione
        $options=array(
            array("id"=>"0","value"=>"Qualunque"),
            array("id"=>"1","value"=>"Solo dirette"),
            array("id"=>"2","value"=>"Solo indirette"),
            array("id"=>"3","value"=>"Almeno dirette"),
            array("id"=>"4","value"=>"Almeno indirette"),
            array("id"=>"5","value"=>"Dirette e indirette")
        );
        $dlg->AddSelectField("partecipazione","Partecipazione",array("bottomLabel"=>"*Filtra in base al tipo di partecipazione RAS (solo societa').","options"=>$options,"value"=>"0"));
        
        //stato organismo
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetListaStatoOrganismi() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("stato_organismo","Stato",array("bottomLabel"=>"*Filtra in base allo stato dell'organismo.","options"=>$options,"value"=>"0"));

        //Tipo nomina
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoNomine() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("tipo_nomina","Tipo nomina",array("bottomLabel"=>"*Filtra in base alla tipologia della nomina.","options"=>$options,"value"=>"0"));

        //Nominato
        $dlg->AddTextField("incaricato","Nominato",array("bottomLabel"=>"*Filtra in base al nome, cognome o cf del nominato.", "placeholder"=>"nome, cognome o cf del nominato..."));
        
        //Over 65
        $dlg->AddSwitchBoxField("over65","Età nomine",array("onLabel"=>"solo over 65","offLabel"=>"tutti","bottomPadding"=>28,"bottomLabel"=>"*Mostra solo le nomine che raggiungono i 65 anni entro la durata dell'incarico."));

        $dlg->SetApplyButtonName("Filtra");

        return $dlg->GetObject();
    }
    
    //Template filtro di ricerca
    public function TemplateScadenzarioFilterDlg()
    {
        //Valori runtime
        $formData=array("archivio"=>$_REQUEST['archivio'],"cessati"=>$_REQUEST['cessati'],"raggruppamento"=>$_REQUEST['raggruppamento'], "finestra_temporale"=>$_REQUEST['finestra_temporale'], "data_scadenzario"=>$_REQUEST['data_scadenzario'],"scadute"=>$_REQUEST['scadute'],"recenti"=>$_REQUEST['recenti'],"in_scadenza"=>$_REQUEST['in_scadenza'],"in_corso"=>$_REQUEST['in_corso'],"id_assessorato"=>$_REQUEST['id_assessorato'],"id_direzione"=>$_REQUEST['id_direzione'],"struct_desc"=>$_REQUEST['struct_desc'],"id_struct_tree_select"=>$_REQUEST['id_struct_tree_select'],"tipo"=>$_REQUEST['tipo'], "tipo_nomina"=>$_REQUEST['tipo_nomina'],"denominazione"=>$_REQUEST['denominazione'],"incaricato"=>$_REQUEST['incaricato']);
        
        //Valori default
        if($_REQUEST['tipo']=="") $formData['tipo']="0";
        if($_REQUEST['tipo_nomina']=="") $formData['tipo_nomina']="0";
        if($_REQUEST['struct_desc']=="") $formData['struct_desc']="Qualunque";
        if($_REQUEST['id_assessorato']=="") $formData['id_assessorato']="0";
        if($_REQUEST['id_direzione']=="") $formData['id_direzione']="0";
        if($_REQUEST['id_servizio']=="") $formData['id_servizio']="0";
        if($_REQUEST['in_corso']=="") $formData['in_corso']="0";
        if($_REQUEST['in_scadenza']=="") $formData['in_scadenza']="1";
        if($_REQUEST['recenti']=="") $formData['recenti']="1";
        if($_REQUEST['scadute']=="") $formData['scadute']="0";
        if($_REQUEST['data_scadenzario']=="") $formData['data_scadenzario'] = Date("Y-m-d");
        if($_REQUEST['finestra_temporale']=="") $formData['finestra_temporale'] = "1";
        if($_REQUEST['raggruppamento']=="") $formData['raggruppamento'] = "0";
        if($_REQUEST['archivio']=="") $formData['archivio'] = "0";
        if($_REQUEST['cessati']=="") $formData['cessati'] = "0";
        
        //Valori reset
        $resetData=array("archivio"=>"0","cessati"=>"0","tipo_nomina"=>"0","raggruppamento"=>"0","finestra_temporale"=>"1","in_corso"=>"0","in_scadenza"=>"1","recenti"=>"1","scadute"=>"0","data_scadenzario"=>Date("Y-m-d"),"id_assessorato"=>0,"id_direzione"=>0,"id_servizio"=>0, "struct_desc"=>"Qualunque","id_struct_tree_select"=>"","tipo"=>0,"denominazione"=>"","incaricato"=>"");
        
        //Azioni da eseguire dopo l'applicazione del filtro
        $applyActions="module.refreshCurSection()";
        
        $dlg = new AA_GenericFilterDlg(static::AA_UI_PREFIX."_Scadenzario_Filter", "Parametri di ricerca per lo scadenzario nomine",$this->GetId(),$formData,$resetData,$applyActions);
        
        $dlg->SetHeight(1080);
        $dlg->SetWidth(1080);
        $dlg->SetLabelAlign("right");
        $dlg->SetLabelWidth(150);
        $dlg->SetBottomPadding(32);
                        
        //Denominazione
        $dlg->AddTextField("denominazione","Denominazione/P.IVA",array("bottomLabel"=>"*Filtra in base alla denominazione o alla partita iva dell'organismo.", "placeholder"=>"Denominazione o piva..."));
        
        //In corso
        $dlg->AddSwitchBoxField("in_corso","In corso",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Nomine che scadranno oltre l'arco temporale impostato."),false);
        
        //Struttura
        $dlg->AddStructField(array("hideServices"=>1,"targetForm"=>$dlg->GetFormId()),array("select"=>true),array("bottomLabel"=>"*Filtra in base alla struttura controllante."));

        //In scadenza
        $dlg->AddSwitchBoxField("in_scadenza","In scadenza",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Nomine che scadranno nell'arco temporale impostato."),false);
        
        //Tipologia
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoOrganismi() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("tipo","Tipologia",array("bottomLabel"=>"*Filtra in base alla tipologia dell'organismo.","options"=>$options,"value"=>"0"));
        
        //recenti
        $dlg->AddSwitchBoxField("recenti","Scadute a b.t.",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Nomine scadute nell'arco temporale impostato (breve termine)."),false);

        //Nominato
        $dlg->AddTextField("incaricato","Nominato",array("bottomLabel"=>"*Filtra in base al nome, cognome o cf del nominato.", "placeholder"=>"nome, cognome o cf del nominato..."));
        
        //Scadute
        $dlg->AddSwitchBoxField("scadute","Scadute a l.t.",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Nomine scadute oltre l'arco temporale impostato (lungo termine)."),false);
 
        //Tipo nomina
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoNomine() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("tipo_nomina","Tipo incarico",array("bottomLabel"=>"*Filtra in base alla tipologia dell'incarico conferito/designato.","options"=>$options,"value"=>"0"));
        
        //Raggruppamento
        $dlg->AddSwitchBoxField("raggruppamento","Raggruppamento",array("onLabel"=>"nominativi","offLabel"=>"incarico","bottomLabel"=>"*Imposta la modalità di raggruppamento degli incarichi (in base alla tipologia di incarico o ai nominativi degli incaricati)."),false);

        //Data scadenzario
        $dlg->AddDateField("data_scadenzario","Data scadenzario",array("editable"=>true,"bottomLabel"=>"*Seleziona la data di riferimento dello scadenzario."));

        //Organismi cessati
        $dlg->AddSwitchBoxField("cessati","Organismi cessati",array("onLabel"=>"includi","offLabel"=>"escludi","bottomLabel"=>"*Includi/escludi nella ricerca gli organismi cessati."),false);

        //Finestra temporale
        $options_finestra=array(array("id"=>1,"value"=>"1 mese"));
        for($i = 2; $i < 25; $i++)
        {
            $options_finestra[]=array("id"=>$i,"value"=>$i." mesi");
        }
        $dlg->AddSelectField("finestra_temporale","Arco temporale",array("bottomLabel"=>"*Seleziona l'arco temporale relativo alla data di riferimento.","options"=>$options_finestra,"value"=>"1"));

        //Nomine archiviate
        $dlg->AddSwitchBoxField("archivio","Incarichi archiviati",array("onLabel"=>"includi","offLabel"=>"escludi","bottomLabel"=>"*Includi/escludi nella ricerca gli incarichi archiviati."),false);

        $dlg->SetApplyButtonName("Filtra");
        
        return $dlg->GetObject();
    }
    
    //Template filtro di ricerca nomine
    public function Template_GetOrganismoNomineFilterDlg($params=null,$filter_id="")
    {
        if($filter_id=="") $filter_id=$this->id."_Nomine_Filter_Dlg";
        
        if($params==null || $params=="")
        {
            //prende i valori dalla sessione
            $sessionVar=AA_SessionVar::Get($filter_id);
            if($sessionVar->isValid())
            {
                $params=(array) $sessionVar->GetValue();
                //AA_Log::Log(__METHOD__." - ".print_r($params,true),100);
                
            }
            else $params=array();
        }
        
        //Valori runtime
        $formData=array("nomina_altri"=>$params['nomina_altri'],"nomina_ras"=>$params['nomina_ras'],"scadute"=>$params['scadute'], "in_corso"=>$params['in_corso'],"tipo"=>$params['tipo']);
        
        //Valori default
        if(!isset($params['tipo'])) $formData['tipo']="0";
        if(!isset($params['scadute'])) $formData['scadute']="1";
        if(!isset($params['in_corso'])) $formData['in_corso']="1";
        if(!isset($params['nomina_ras'])) $formData['nomina_ras']="1";
        if(!isset($params['nomina_altri'])) $formData['nomina_altri']="1";
        
        //Valori reset
        $resetData=array("tipo"=>"0","nomina_ras"=>"1","nomina_altri"=>"1", "scadute"=>"1","in_corso"=>"1");
        
        $applyActions="AA_MainApp.ui.showWaitMessage('Caricamento in corso...');setTimeout(module.refreshCurSection.bind(module),500)";
        $dlg = new AA_GenericFilterDlg($this->id."_Nomine_Filter_Dlg", "Parametri di filtraggio per le nomine",$this->GetId(),$formData,$resetData,$applyActions);
       
        $dlg->SetHeight(520);
        
        //scadute
        $dlg->AddSwitchBoxField("scadute","Nomine scadute",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le nomine scadute."));
        
        //in corso
        $dlg->AddSwitchBoxField("in_corso","Nomine in corso",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le nomine in corso."));
        
        //nomina ras
        $dlg->AddSwitchBoxField("nomina_ras","Nomine RAS",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le nomine RAS."));
        
        //nomina altri
        $dlg->AddSwitchBoxField("nomina_altri","Nomine non RAS",array("onLabel"=>"mostra","offLabel"=>"nascondi","bottomLabel"=>"*Mostra/nascondi le nomine non RAS."));
        
        //Tipologia
        $options=array(array("id"=>"0","value"=>"Qualunque"));
        foreach(AA_Organismi_Const::GetTipoNomine() as $id=>$label)
        {
            if($id > 0) $options[]=array("id"=>$id,"value"=>$label);
        }
        $dlg->AddSelectField("tipo","Incarico",array("tooltip"=>"Filtra in base alla tipologia dell'incarico.","options"=>$options,"value"=>"0"));

        //Imposta l'identificativo di salvataggio
        
        $dlg->SetSaveFilterId($filter_id);
        
        //Salva i valori come variabili di sessione
        $dlg->EnableSessionSave();
        
        return $dlg->GetObject();
    }
    
    
    //Task generic export csv 
    public function Task_CsvExport($task)
    {
        //AA_Log::Log(__METHOD__."() - task: ".$task->GetName());

        $sessVar = AA_SessionVar::Get("SaveAsCsv_ids");
        $sessParams = AA_SessionVar::Get("SaveAsCsv_params");

        $ids_final=array();

        //lista elementi da esportare
        if ($sessVar->IsValid() && !isset($_REQUEST['fromParams'])) {
            $ids = $sessVar->GetValue();

            if (is_array($ids)) {
                foreach ($ids as $curId) {
                    $object = new AA_Organismi($curId, $this->oUser);
                    if ($object->isValid() && ($object->GetUserCaps($this->oUser) & AA_Const::AA_PERMS_READ) > 0) {
                        $ids_final[$curId] = $object;
                    }
                }
            }

            //Esiste almeno un organismo che può essere letto dall'utente corrente
            if (sizeof($ids_final) > 0) {
                $this->Template_CsvExport($ids_final);
            } else {
                $task->SetError("Nella selezione non sono presenti dati leggibili dall'utente corrente (" . $this->oUser->GetName() . ").");
                $sTaskLog = "<status id='status'>-1</status><error id='error'>Nella selezione non sono presenti elementi leggibili dall'utente corrente (" . $this->oUser->GetName() . ").</error>";
                $task->SetLog($sTaskLog);

                return false;
            }
        } else {
            if ($sessParams->isValid()) {
                $params = (array) $sessParams->GetValue();
                //AA_Log::Log(__METHOD__." - params: ".print_r($params,true),100);

                //Verifica della sezione 
                if ($params['section'] == static::AA_ID_SECTION_BOZZE) {
                    $params["status"] = AA_Const::AA_STATUS_BOZZA;
                } else {
                    $params["status"] = AA_Const::AA_STATUS_PUBBLICATA;
                }

                if ($params['cestinate'] == 1) {
                    $params['status'] |= AA_Const::AA_STATUS_CESTINATA;
                }

                $objects = AA_Organismi::Search($params, false, $this->oUser);

                if ($objects[0] == 0) {
                    $task->SetError("Non è stata individuata nessuna corrispondenza in base ai parametri indicati.");
                    $sTaskLog = "<status id='status'>-1</status><error id='error'>Non è stata individuata nessuna corrispondenza in base ai parametri indicati.</error>";
                    $task->SetLog($sTaskLog);
                    return false;
                } else {
                    $task->SetStatus(AA_GenericTask::AA_STATUS_SUCCESS);
                    $task->SetContent("Exportazione effettuata con successo.",false);

                    $this->Template_CsvExport($objects[1],$params);

                    return true;
                }
            }
        }
    }

    //Funzione di esportazione in csv (da specializzare)
    public function Template_CsvExport($objects = array(),$params=null)
    {
        //AA_Log::Log(__METHOD__." - objects: ".print_r($objects,true),100);

        return $this->Template_GenericCsvExport($objects, $params);
    }

    //Template pdf export generic
    public function Template_OrganismiPdfExport($organismi=array(), $bToBrowser=true,$tipo_organismo="")
    {
        AA_Log::Log(__METHOD__." starting building pdf: ".time(),100);

        if(!is_array($organismi)) return "";
        if(sizeof($organismi)==0) return "";
        
        //recupero organismi
        
        //$organismi=AA_Organismi::Search(array("ids"=>$ids),false,$this->oUser);
        $count = sizeof($organismi);
        #--------------------------------------------
            
        //nome file
        $filename="pubblicazioni_art22";
        if($tipo_organismo !="")
        {
          $tipo=AA_Organismi_Const::GetTipoOrganismi(true);
          $filename.="-".str_replace(" ","_",$tipo[$tipo_organismo]);
        }
        $filename.="-".date("YmdHis");
        $doc = new AA_PDF_RAS_TEMPLATE_A4_PORTRAIT($filename);
        
        $doc->SetDocumentStyle("font-family: sans-serif; font-size: 3mm;");
        $doc->SetPageCorpoStyle("display: flex; flex-direction: column; justify-content: space-between; padding:0;");
        $curRow=0;
        $rowForPage=1;
        $lastRow=$rowForPage-1;
        $curPage=null;
        $curNumPage=0;
        //$columns_width=array("titolare"=>"10%","incarico"=>"8%","atto"=>"10%","struttura"=>"28%","curriculum"=>"10%","art20"=>"12%","altri_incarichi"=>"10%","1-ter"=>"10%","emolumenti"=>"10%");
        //$columns_width=array("dal"=>"10%","al"=>"10%","inconf"=>"10%","incomp"=>"10%","anno"=>"25%","titolare"=>"50%","tipo_incarico"=>"10%","atto_nomina"=>"10%","struttura"=>"40%","curriculum"=>"25%","altri_incarichi"=>"25%","1-ter"=>"25%","emolumenti"=>"10%");
        $rowContentWidth="width: 99.8%;";

        if($count >1)
        {
            //pagina di intestazione (senza titolo)
            $curPage=$doc->AddPage();
            $curPage->SetCorpoStyle("display: flex; flex-direction: column; justify-content: center; align-items: center; padding:0;");
            $curPage->SetFooterStyle("border-top:.2mm solid black");
            $curPage->ShowPageNumber(false);

            //Intestazione
            $intestazione="<div style='width: 100%; text-align: center; font-size: 24; font-weight: bold'>Pubblicazioni ai sensi dell'art.22 del d.lgs. 33/2013</div>";
            if($tipo_organismo !="") 
            {
              $intestazione.="<div style='width: 100%; text-align: center; font-size: 18; font-weight: bold;'>".$tipo[$tipo_organismo]."</div>";
            }
            $intestazione.="<div style='width: 100%; text-align: center; font-size: x-small; font-weight: normal;margin-top: 3em;'>documento generato il ".date("Y-m-d")."</div>";

            $curPage->SetContent($intestazione);
            $curNumPage++;

            //pagine indice (50 nominativi per pagina)
            $indiceNumVociPerPagina=50;
            for($i=0; $i<$count/$indiceNumVociPerPagina; $i++)
            {
              $curPage=$doc->AddPage();
              $curPage->SetCorpoStyle("display: flex; flex-direction: column; padding:0;");
              $curNumPage++;
            }
            #---------------------------------------
        }
        
        //Imposta il titolo per le pagine successive
        $doc->SetTitle("Pubblicazioni ai sensi dell'art.22 del d.lgs. 33/2013 - report generato il ".date("Y-m-d"));
  
        $indice=array();
        $lastPage=$count/$rowForPage+$curNumPage;
        $curPage_row="";

        //Rendering pagine
        foreach($organismi as $id=>$curOrganismo)
        {
            //Aggiunge una pagina
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";

            //Aggiorna l'indice
            $indice[$curOrganismo->GetID()]=$curNumPage."|".$curOrganismo->GetDescrizione();
            $curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";

            //$template=new AA_OrganismiPublicReportTemplateView("report_organismo_pdf_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            
            //Prima pagina
            $curPage_row.=new AA_OrganismiPublicReportTemplateGeneralPageView("report_organismo_pdf_general_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            
            $provvedimenti=$curOrganismo->GetProvvedimenti();
            if(sizeof($provvedimenti) > 0)
            {
                if(sizeof($provvedimenti) < 10)
                {
                    $provvedimenti_table = new AA_OrganismiReportProvvedimentiListTemplateView("report_organismo_pdf_provvedimenti_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser,$provvedimenti);
                    $curPage_row.=$provvedimenti_table;

                    //footer
                    $curPage_row.="<div style='font-style: italic; font-size: smaller; text-align: left; width: 100%;'>La dicitura 'n.d.' indica che l'informazione corrispondente non è disponibile o non è presente negli archivi dell'Amministrazione Regionale.<br><span>Le informazioni del presente organismo sono state aggiornate l'ultima volta il ".$curOrganismo->GetAggiornamento()."</span></div>";
                    $curPage_row.="</div>";
                    $curPage->SetContent($curPage_row);
                }
                else
                {
                    $curPage_row.="<div style='font-style: italic; font-size: smaller; text-align: left; width: 100%;'>La dicitura 'n.d.' indica che l'informazione corrispondente non è disponibile o non è presente negli archivi dell'Amministrazione Regionale.<br><span>Le informazioni del presente organismo sono state aggiornate l'ultima volta il ".$curOrganismo->GetAggiornamento()."</span></div>";
                    $curPage_row.="</div>";
                    $curPage->SetContent($curPage_row);

                    $curPage=$doc->AddPage();
                    $curNumPage++;
                    $curPage_row="";

                    $curPage_row.="<div style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";

                    $curPage_row.=new AA_OrganismiPublicReportTemplateProvvedimentiPageView("report_organismo_pdf_provvedimenti_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser,$provvedimenti);

                    $curPage_row.="</div>";
                    $curPage->SetContent($curPage_row);
                }
            }
            else
            {
                $curPage_row.="<div style='font-style: italic; font-size: smaller; text-align: left; width: 100%;'>La dicitura 'n.d.' indica che l'informazione corrispondente non è disponibile o non è presente negli archivi dell'Amministrazione Regionale.<br><span>Le informazioni del presente organismo sono state aggiornate l'ultima volta il ".$curOrganismo->GetAggiornamento()."</span></div>";
                $curPage_row.="</div>";
                $curPage->SetContent($curPage_row);
            }

            //seconda pagina
            //Aggiunge una pagina
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";
            $curPage_row.="<div style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";
            $curPage_row.=new AA_OrganismiPublicReportTemplateNominePageView("report_organismo_pdf_nomine_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            $curPage_row.="</div>";
            $curPage->SetContent($curPage_row);

            //AA_Log::Log($template,100,false,true);
        }
        //if($curPage != null) $curPage->SetContent($curPage_row);
        #-----------------------------------------
        
        if($count > 1)
        {
            //Aggiornamento indice
            $curNumPage=1;
            $curPage=$doc->GetPage($curNumPage);
            $vociCount=0;
            $curRow=0;
            $bgColor="";
            $curPage_row="";

            foreach($indice as $id=>$data)
            {
              if($curNumPage != (int)($vociCount/$indiceNumVociPerPagina)+1)
              {
                $curPage->SetContent($curPage_row);
                $curNumPage=(int)($vociCount/$indiceNumVociPerPagina)+1;
                $curPage=$doc->GetPage($curNumPage);
                $curRow=0;
                $bgColor="";
              }

              if($curPage instanceof AA_PDF_Page)
              {
                if($vociCount%2 > 0)
                {
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a href='#".$id."'>pag. ".$dati[0]."</a></div>";
                  $curPage_row.="</div>";
                  if($vociCount == (sizeof($indice)-1)) $curPage->SetContent($curPage_row);
                  $curRow++;
                }
                else
                {
                  //Intestazione
                  if($curRow==0) $curPage_row="<div style='width:100%;text-align: center; font-size: 18px; font-weight: bold; border-bottom: 1px solid gray; margin-bottom: .5em; margin-top: .3em;'>Indice</div>";

                  if($curRow%2) $bgColor="background-color: #f5f5f5;";
                  else $bgColor="";
                  $curPage_row.="<div style='display:flex; ".$rowContentWidth." align-items: center; justify-content: space-between; text-align: center; padding: .3mm; min-height: 9mm;".$bgColor."'>";
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a href='#".$id."'>pag. ".$dati[0]."</a></div>";

                  //ultima voce
                  if($vociCount == (sizeof($indice)-1))
                  {
                    $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'>&nbsp; </div><div style='width:9%;text-align: right;padding-left: 10mm'>&nbsp; </div></div>";
                    $curPage->SetContent($curPage_row);
                  } 
                }
              }

              $vociCount++;
            }            
        }

        AA_Log::Log(__METHOD__." done building pdf: ".time(),100);
        AA_Log::Log(__METHOD__." start rendering pdf: ".time(),100);
        if($bToBrowser) $doc->Render();
        else
        {
            $doc->Render(false);
            return $doc->GetFilePath();
        }
    }

    //Template pdf export generic
    public function Template_OrganismiPdfExportFull($organismi=array(), $bToBrowser=true,$tipo_organismo="")
    {
        //AA_Log::Log(__METHOD__." starting building pdf: ".time(),100);

        if(!is_array($organismi)) return "";
        if(sizeof($organismi)==0) return "";
        
        //recupero organismi
        
        //$organismi=AA_Organismi::Search(array("ids"=>$ids),false,$this->oUser);
        $count = sizeof($organismi);
        #--------------------------------------------
            
        //nome file
        $filename="organismi_export_full";
        if($tipo_organismo !="")
        {
          $tipo=AA_Organismi_Const::GetTipoOrganismi(true);
          $filename.="-".str_replace(" ","_",$tipo[$tipo_organismo]);
        }
        $filename.="-".date("YmdHis");
        $doc = new AA_PDF_RAS_TEMPLATE_A4_PORTRAIT($filename);
        $doc->EnableCache(false);
        
        $doc->SetDocumentStyle("font-family: sans-serif; font-size: 3mm;");
        $doc->SetPageCorpoStyle("display: flex; flex-direction: column; justify-content: space-between; padding:0;");
        $curRow=0;
        $rowForPage=1;
        $lastRow=$rowForPage-1;
        $curPage=null;
        $curNumPage=0;
        //$columns_width=array("titolare"=>"10%","incarico"=>"8%","atto"=>"10%","struttura"=>"28%","curriculum"=>"10%","art20"=>"12%","altri_incarichi"=>"10%","1-ter"=>"10%","emolumenti"=>"10%");
        //$columns_width=array("dal"=>"10%","al"=>"10%","inconf"=>"10%","incomp"=>"10%","anno"=>"25%","titolare"=>"50%","tipo_incarico"=>"10%","atto_nomina"=>"10%","struttura"=>"40%","curriculum"=>"25%","altri_incarichi"=>"25%","1-ter"=>"25%","emolumenti"=>"10%");
        $rowContentWidth="width: 99.8%;";

        if($count >1)
        {
            //pagina di intestazione (senza titolo)
            $curPage=$doc->AddPage();
            $curPage->SetCorpoStyle("display: flex; flex-direction: column; justify-content: center; align-items: center; padding:0;");
            $curPage->SetFooterStyle("border-top:.2mm solid black");
            $curPage->ShowPageNumber(false);

            //Intestazione
            $intestazione="<div style='width: 100%; text-align: center; font-size: 24; font-weight: bold'>Esportazione organismi censiti sul SINES</div>";
            if($tipo_organismo !="") 
            {
              $intestazione.="<div style='width: 100%; text-align: center; font-size: 18; font-weight: bold;'>".$tipo[$tipo_organismo]."</div>";
            }
            $intestazione.="<div style='width: 100%; text-align: center; font-size: x-small; font-weight: normal;margin-top: 3em;'>documento generato il ".date("Y-m-d")."</div>";

            $curPage->SetContent($intestazione);
            $curNumPage++;

            //pagine indice (50 nominativi per pagina)
            $indiceNumVociPerPagina=50;
            for($i=0; $i<$count/$indiceNumVociPerPagina; $i++)
            {
              $curPage=$doc->AddPage();
              $curPage->SetCorpoStyle("display: flex; flex-direction: column; padding:0;");
              $curNumPage++;
            }
            #---------------------------------------
        }
        
        //Imposta il titolo per le pagine successive
        $doc->SetTitle("Esportazione organismi censiti sul SINES - report generato il ".date("Y-m-d"));
        
        $indice=array();
        $lastPage=$count/$rowForPage+$curNumPage;
        $curPage_row="";

        //Rendering pagine
        foreach($organismi as $id=>$curOrganismo)
        {
            //Aggiunge una pagina
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";

            //Aggiorna l'indice
            $indice[$curOrganismo->GetID()]=$curNumPage."|".$curOrganismo->GetDescrizione();
            $curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm; height: 100%;'>";
            
            //Prima pagina -  dati generali
            $curPage_row.=new AA_OrganismiFullReportTemplateGeneralPageView("report_organismo_pdf_general_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            //$curPage_row.="<div style='font-style: italic; font-size: smaller; text-align: center; width: 100%;'>La dicitura 'n.d.' indica che l'informazione corrispondente non è disponibile o non è presente negli archivi dell'Amministrazione Regionale.<br><span>Le informazioni del presente organismo sono state aggiornate l'ultima volta il ".$curOrganismo->GetAggiornamento()."</span></div>";
            $curPage_row.="</div>";
            $curPage->SetFooterContent("<div style='font-style: italic; font-size: smaller; text-align: left; width: 100%;'>La dicitura 'n.d.' indica che l'informazione corrispondente non è disponibile o non è presente negli archivi dell'Amministrazione Regionale.<br><span>Le informazioni del presente organismo sono state aggiornate l'ultima volta il ".$curOrganismo->GetAggiornamento()."</span></div>");
            $curPage->SetContent($curPage_row);
            //seconda pagina - dati contabili
            //$curPage=$doc->AddPage();
            //$curNumPage++;
            //$curPage_row="";
            //$curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";
            $report = new AA_OrganismiFullReportTemplateDatiContabiliPageView("report_organismo_pdf_dati_contabili_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser,$doc);
            $curNumPage+=$report->GetRelNumPage();
            //$curPage_row.="</div>";
            //$curPage->SetContent($curPage_row);
            

            //terza pagina
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";
            $curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";
            $curPage_row.=new AA_OrganismiFullReportTemplateNominePageView("report_organismo_pdf_nomine_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            $curPage_row.="</div>";
            $curPage->SetFooterContent("<div style='font-style: italic; font-size: smaller; text-align: left; width: 100%;'>La dicitura 'n.d.' indica che l'informazione corrispondente non è disponibile o non è presente negli archivi dell'Amministrazione Regionale.<br><span>Le informazioni del presente organismo sono state aggiornate l'ultima volta il ".$curOrganismo->GetAggiornamento()."</span></div>");
            $curPage->SetContent($curPage_row);

            //AA_Log::Log($template,100,false,true);
        }
        //if($curPage != null) $curPage->SetContent($curPage_row);
        #-----------------------------------------
        
        if($count > 1)
        {
            //Aggiornamento indice
            $curNumPage=1;
            $curPage=$doc->GetPage($curNumPage);
            $vociCount=0;
            $curRow=0;
            $bgColor="";
            $curPage_row="";

            foreach($indice as $id=>$data)
            {
              if($curNumPage != (int)($vociCount/$indiceNumVociPerPagina)+1)
              {
                $curPage->SetContent($curPage_row);
                $curNumPage=(int)($vociCount/$indiceNumVociPerPagina)+1;
                $curPage=$doc->GetPage($curNumPage);
                $curRow=0;
                $bgColor="";
              }

              if($curPage instanceof AA_PDF_Page)
              {
                if($vociCount%2 > 0)
                {
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a href='#".$id."'>pag. ".$dati[0]."</a></div>";
                  $curPage_row.="</div>";
                  if($vociCount == (sizeof($indice)-1)) $curPage->SetContent($curPage_row);
                  $curRow++;
                }
                else
                {
                  //Intestazione
                  if($curRow==0) $curPage_row="<div style='width:100%;text-align: center; font-size: 18px; font-weight: bold; border-bottom: 1px solid gray; margin-bottom: .5em; margin-top: .3em;'>Indice</div>";

                  if($curRow%2) $bgColor="background-color: #f5f5f5;";
                  else $bgColor="";
                  $curPage_row.="<div style='display:flex; ".$rowContentWidth." align-items: center; justify-content: space-between; text-align: center; padding: .3mm; min-height: 9mm;".$bgColor."'>";
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a href='#".$id."'>pag. ".$dati[0]."</a></div>";

                  //ultima voce
                  if($vociCount == (sizeof($indice)-1))
                  {
                    $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'>&nbsp; </div><div style='width:9%;text-align: right;padding-left: 10mm'>&nbsp; </div></div>";
                    $curPage->SetContent($curPage_row);
                  } 
                }
              }

              $vociCount++;
            }            
        }

        //AA_Log::Log(__METHOD__." done building pdf: ".time(),100);
        //AA_Log::Log(__METHOD__." start rendering pdf: ".time(),100);
        if($bToBrowser) $doc->Render();
        else
        {
            $doc->Render(false);
            return $doc->GetFilePath();
        }
    }

    //Template pdf export rappresentazione grafica
    public function Template_OrganismiPdfRappresentazioneGraficaExport($organismi=array(), $bToBrowser=true,$tipo_organismo="")
    {
        AA_Log::Log(__METHOD__." starting building pdf: ".time(),100);

        if(!is_array($organismi)) return "";
        if(sizeof($organismi)==0) return "";
        
        //recupero organismi
        
        //$organismi=AA_Organismi::Search(array("ids"=>$ids),false,$this->oUser);
        $count = sizeof($organismi);
        #--------------------------------------------
            
        //nome file
        $filename="pubblicazioni_art22_rappresentazione_grafica";
        if($tipo_organismo !="")
        {
          $tipo=AA_Organismi_Const::GetTipoOrganismi(true);
          $filename.="-".str_replace(" ","_",$tipo[$tipo_organismo]);
        }
        $filename.="-".date("YmdHis");
        $doc = new AA_PDF_RAS_TEMPLATE_A4_PORTRAIT($filename);
        
        $doc->SetDocumentStyle("font-family: sans-serif; font-size: 3mm;");
        $doc->SetPageCorpoStyle("display: flex; flex-direction: column; justify-content: space-between; padding:0;");
        $curRow=0;
        $rowForPage=1;
        $lastRow=$rowForPage-1;
        $curPage=null;
        $curNumPage=0;
        //$columns_width=array("titolare"=>"10%","incarico"=>"8%","atto"=>"10%","struttura"=>"28%","curriculum"=>"10%","art20"=>"12%","altri_incarichi"=>"10%","1-ter"=>"10%","emolumenti"=>"10%");
        //$columns_width=array("dal"=>"10%","al"=>"10%","inconf"=>"10%","incomp"=>"10%","anno"=>"25%","titolare"=>"50%","tipo_incarico"=>"10%","atto_nomina"=>"10%","struttura"=>"40%","curriculum"=>"25%","altri_incarichi"=>"25%","1-ter"=>"25%","emolumenti"=>"10%");
        $rowContentWidth="width: 99.8%;";

        if($count >1)
        {
            //pagina di intestazione (senza titolo)
            $curPage=$doc->AddPage();
            $curPage->SetCorpoStyle("display: flex; flex-direction: column; justify-content: center; align-items: center; padding:0;");
            $curPage->SetFooterStyle("border-top:.2mm solid black");
            $curPage->ShowPageNumber(false);

            //Intestazione
            $intestazione="<div style='width: 100%; text-align: center; font-size: 24; font-weight: bold'>Pubblicazioni ai sensi dell'art.22 del d.lgs. 33/2013<br/>Rappresentazione grafica</div>";
            if($tipo_organismo !="") 
            {
              $intestazione.="<div style='width: 100%; text-align: center; font-size: 18; font-weight: bold;'>".$tipo[$tipo_organismo]."</div>";
            }
            $intestazione.="<div style='width: 100%; text-align: center; font-size: x-small; font-weight: normal;margin-top: 3em;'>documento generato il ".date("Y-m-d")."</div>";

            $curPage->SetContent($intestazione);
            $curNumPage++;

            //pagine indice (50 nominativi per pagina)
            $indiceNumVociPerPagina=50;
            for($i=0; $i<$count/$indiceNumVociPerPagina; $i++)
            {
              $curPage=$doc->AddPage();
              $curPage->SetCorpoStyle("display: flex; flex-direction: column; padding:0;");
              $curNumPage++;
            }
            #---------------------------------------
        }
        
        //Imposta il titolo per le pagine successive
        $doc->SetTitle("Pubblicazioni ai sensi dell'art.22 del d.lgs. 33/2013 - report generato il ".date("Y-m-d"));
  
        $indice=array();
        $lastPage=$count/$rowForPage+$curNumPage;
        $curPage_row="";

        //Rendering pagine
        foreach($organismi as $id=>$curOrganismo)
        {
            //Aggiunge una pagina
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";

            //Aggiorna l'indice
            $indice[$curOrganismo->GetID()]=$curNumPage."|".$curOrganismo->GetDescrizione();
            $curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";

            //$template=new AA_OrganismiPublicReportTemplateView("report_organismo_pdf_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            
            //Prima pagina
            $curPage_row.=new AA_OrganismiPublicReportTemplateGeneralPageView("report_organismo_pdf_general_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            $curPage_row.="</div>";
            $curPage->SetContent($curPage_row);

            //seconda pagina
            //Aggiunge una pagina
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";
            $curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";
            $curPage_row.=new AA_OrganismiPublicReportTemplateNominePageView("report_organismo_pdf_nomine_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            $curPage_row.="</div>";
            $curPage->SetContent($curPage_row);

            //AA_Log::Log($template,100,false,true);
        }
        //if($curPage != null) $curPage->SetContent($curPage_row);
        #-----------------------------------------
        
        if($count > 1)
        {
            //Aggiornamento indice
            $curNumPage=1;
            $curPage=$doc->GetPage($curNumPage);
            $vociCount=0;
            $curRow=0;
            $bgColor="";
            $curPage_row="";

            foreach($indice as $id=>$data)
            {
              if($curNumPage != (int)($vociCount/$indiceNumVociPerPagina)+1)
              {
                $curPage->SetContent($curPage_row);
                $curNumPage=(int)($vociCount/$indiceNumVociPerPagina)+1;
                $curPage=$doc->GetPage($curNumPage);
                $curRow=0;
                $bgColor="";
              }

              if($curPage instanceof AA_PDF_Page)
              {
                if($vociCount%2 > 0)
                {
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a href='#".$id."'>pag. ".$dati[0]."</a></div>";
                  $curPage_row.="</div>";
                  if($vociCount == (sizeof($indice)-1)) $curPage->SetContent($curPage_row);
                  $curRow++;
                }
                else
                {
                  //Intestazione
                  if($curRow==0) $curPage_row="<div style='width:100%;text-align: center; font-size: 18px; font-weight: bold; border-bottom: 1px solid gray; margin-bottom: .5em; margin-top: .3em;'>Indice</div>";

                  if($curRow%2) $bgColor="background-color: #f5f5f5;";
                  else $bgColor="";
                  $curPage_row.="<div style='display:flex; ".$rowContentWidth." align-items: center; justify-content: space-between; text-align: center; padding: .3mm; min-height: 9mm;".$bgColor."'>";
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a href='#".$id."'>pag. ".$dati[0]."</a></div>";

                  //ultima voce
                  if($vociCount == (sizeof($indice)-1))
                  {
                    $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'>&nbsp; </div><div style='width:9%;text-align: right;padding-left: 10mm'>&nbsp; </div></div>";
                    $curPage->SetContent($curPage_row);
                  } 
                }
              }

              $vociCount++;
            }            
        }

        AA_Log::Log(__METHOD__." done building pdf: ".time(),100);
        AA_Log::Log(__METHOD__." start rendering pdf: ".time(),100);
        if($bToBrowser) $doc->Render();
        else
        {
            $doc->Render(false);
            return $doc->GetFilePath();
        }
    }

    //Template pdf export scadenzario
    public function Template_OrganismiScadenzarioPdfExport($organismi=array(), $bToBrowser=true,$tipo_organismo="")
    {
        if(!is_array($organismi)) return "";
        if(sizeof($organismi)==0) return "";
        
        //recupero organismi
        
        //$organismi=AA_Organismi::Search(array("ids"=>$ids),false,$this->oUser);
        $count = sizeof($organismi);
        #--------------------------------------------
            
        //nome file
        $filename="pubblicazioni_art22";
        if($tipo_organismo !="")
        {
          $tipo=AA_Organismi_Const::GetTipoOrganismi(true);
          $filename.="-".str_replace(" ","_",$tipo[$tipo_organismo]);
        }
        $filename.="-".date("YmdHis");
        $doc = new AA_PDF_RAS_TEMPLATE_A4_PORTRAIT($filename);
        
        $doc->SetDocumentStyle("font-family: 'Roboto', verdana, sans-serif; font-size: 3mm;");
        $doc->SetPageCorpoStyle("display: flex; flex-direction: column; justify-content: space-between; padding:0;");
        $curRow=0;
        $rowForPage=1;
        $lastRow=$rowForPage-1;
        $curPage=null;
        $curNumPage=0;
        //$columns_width=array("titolare"=>"10%","incarico"=>"8%","atto"=>"10%","struttura"=>"28%","curriculum"=>"10%","art20"=>"12%","altri_incarichi"=>"10%","1-ter"=>"10%","emolumenti"=>"10%");
        //$columns_width=array("dal"=>"10%","al"=>"10%","inconf"=>"10%","incomp"=>"10%","anno"=>"25%","titolare"=>"50%","tipo_incarico"=>"10%","atto_nomina"=>"10%","struttura"=>"40%","curriculum"=>"25%","altri_incarichi"=>"25%","1-ter"=>"25%","emolumenti"=>"10%");
        $rowContentWidth="width: 99.8%;";

        //pagina di intestazione (senza titolo)
        $curPage=$doc->AddPage();
        $curPage->SetCorpoStyle("display: flex; flex-direction: column; justify-content: center; align-items: center; padding:0;");
        $curPage->SetFooterStyle("border-top:.2mm solid black");
        $curPage->ShowPageNumber(false);

        //Intestazione
        $intestazione="<div style='width: 100%; text-align: center; font-size: 32; font-weight: bold; margin-bottom: 2em;'>SINES<br><span style='font-size: smaller;font-weight: normal'>Sistema informativo Enti e Societa'</span></div>";
        $intestazione.="<div style='width: 100%; text-align: center; font-size: 24; font-weight: bold'>Agenda nomine</div>";
        $intestazione.="<div style='width: 100%; text-align: center; font-size: 18; font-weight: bold'>Estratto scadenzario incarichi</div>";
        if($tipo_organismo !="") 
        {
            $intestazione.="<div style='width: 100%; text-align: center; font-size: 18; font-weight: bold;'>".$tipo[$tipo_organismo]."</div>";
        }
        $intestazione.="<div style='width: 100%; text-align: center; font-size: x-small; font-weight: normal;margin-top: 3em;'>documento generato il ".date("Y-m-d")."</div>";

        $curPage->SetContent($intestazione);
        $curNumPage++;

        //pagine indice (50 nominativi per pagina)
        $indiceNumVociPerPagina=50;
        for($i=0; $i<$count/$indiceNumVociPerPagina; $i++)
        {
            $curPage=$doc->AddPage();
            $curPage->SetCorpoStyle("display: flex; flex-direction: column; padding:0;");
            $curNumPage++;
        }
        #---------------------------------------

        //Imposta il titolo per le pagine successive
        $doc->SetTitle("SINES - Agenda nomine - estratto scadenzario incarichi Organismi RAS- report generato il ".date("Y-m-d"));
  
        $indice=array();
        $lastPage=$count/$rowForPage+$curNumPage;
        $curPage_row="";

        //Rendering pagine
        foreach($organismi as $id=>$curOrganismo)
        {
            //Aggiunge una pagina
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";

            //Aggiorna l'indice
            $indice[$curOrganismo->GetID()]=$curNumPage."|".$curOrganismo->GetDescrizione();
            
            //pagina geenrale
            $curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";
            $curPage_row.=new AA_OrganismiReportScadenzarioTemplateGeneralPageView("report_organismo_scadenzario_generale_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            $curPage_row.="</div>";
            $curPage->SetContent($curPage_row);
            
            //nomine
            $curPage=$doc->AddPage();
            $curNumPage++;
            $curPage_row="";
            $curPage_row.="<div id='".$curOrganismo->GetID()."' style='display:flex;  flex-direction: column; width:100%; align-items: center; justify-content: space-between; text-align: center; padding: 0mm; min-height: 9mm;'>";
            $curPage_row.=new AA_OrganismiReportScadenzarioNomineTemplateView("report_organismo_scadenzario_nomine_page_".$curOrganismo->GetId(),null,$curOrganismo,$this->oUser);
            $curPage_row.="</div>";
            $curPage->SetContent($curPage_row);

        }
        #-----------------------------------------

        {
            //Aggiornamento indice
            $curNumPage=1;
            $curPage=$doc->GetPage($curNumPage);
            $vociCount=0;
            $curRow=0;
            $bgColor="";
            $curPage_row="";

            foreach($indice as $id=>$data)
            {
              if($curNumPage != (int)($vociCount/$indiceNumVociPerPagina)+1)
              {
                $curPage->SetContent($curPage_row);
                $curNumPage=(int)($vociCount/$indiceNumVociPerPagina)+1;
                $curPage=$doc->GetPage($curNumPage);
                $curRow=0;
                $bgColor="";
              }

              if($curPage instanceof AA_PDF_Page)
              {
                if($vociCount%2 > 0)
                {
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a style='text-decoration:none' href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a style='text-decoration:none' href='#".$id."'>pag. ".$dati[0]."</a></div>";
                  $curPage_row.="</div>";
                  if($vociCount == (sizeof($indice)-1)) $curPage->SetContent($curPage_row);
                  $curRow++;
                }
                else
                {
                  //Intestazione
                  if($curRow==0) $curPage_row="<div style='width:100%;text-align: center; font-size: 18px; font-weight: bold; border-bottom: 1px solid gray; margin-bottom: .5em; margin-top: .3em;'>Indice</div>";

                  if($curRow%2) $bgColor="background-color: #f5f5f5;";
                  else $bgColor="";
                  $curPage_row.="<div style='display:flex; ".$rowContentWidth." align-items: center; justify-content: space-between; text-align: center; padding: .3mm; min-height: 9mm;".$bgColor."'>";
                  $dati=explode("|",$data);
                  $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'><a style='text-decoration:none' href='#".$id."'>".$dati['1']."</a></div><div style='width:9%;text-align: right;padding-right: 10mm'><a style='text-decoration:none' href='#".$id."'>pag. ".$dati[0]."</a></div>";

                  //ultima voce
                  if($vociCount == (sizeof($indice)-1))
                  {
                    $curPage_row.="<div style='width:40%;text-align: left;padding-left: 10mm'>&nbsp; </div><div style='width:9%;text-align: right;padding-left: 10mm'>&nbsp; </div></div>";
                    $curPage->SetContent($curPage_row);
                  } 
                }
              }

              $vociCount++;
            }            
        }

        if($bToBrowser) $doc->Render();
        else
        {
            $doc->Render(false);
            return $doc->GetFilePath();
        }
    }
}

//Template logView dlg
Class AA_SinesLogDlg extends AA_GenericWindowTemplate
{       
    public function __construct($id = "", $title = "Logs", $user=null)
    {
        parent::__construct($id, $title);
                
        $this->SetWidth("720");
        $this->SetHeight("576");

        //Id oggetto non impostato
        if($_REQUEST['id']=="")
        {
            $this->body->AddRow(new AA_JSON_Template_Template($this->id."_Log_Box",array("type"=>"clean","template"=>"<div style='text-align: center;'id='pdf_preview_box' style='width: 100%; height: 100%'>Identificativo oggetto non impostato.</div>")));
            return;
        }

        //Verifica utente
        if($user instanceof AA_User)
        {
            if(!$user->isCurrentUser() || $user->IsGuest())
            {
                $user=AA_User::GetCurrentUser();
            }
        }
        else $user=AA_User::GetCurrentUser();
        
        if($user->IsGuest())
        {
            $this->body->AddRow(new AA_JSON_Template_Template($this->id."_Log_Box",array("type"=>"clean","template"=>"<div style='text-align: center;'id='pdf_preview_box' style='width: 100%; height: 100%'>Utente non valido o sessione scaduta.</div>")));
            return;
        }

        $object = AA_Organismi::Load($_REQUEST['id'],$user);
        
        //Invalid object
        if(!$object->IsValid())
        {
            $this->body->AddRow(new AA_JSON_Template_Template($this->id."_Log_Box",array("type"=>"clean","template"=>"<div style='text-align: center;'id='pdf_preview_box' style='width: 100%; height: 100%'>Oggetto non valido o permessi insufficienti.</div>")));
            return;
        }
        
        //permessi insufficienti
        if(($object->GetUserCaps($user)&AA_Const::AA_PERMS_WRITE) == 0)
        {
            $this->body->AddRow(new AA_JSON_Template_Template($this->id."_Log_Box",array("type"=>"clean","template"=>"<div style='text-align: center;'id='pdf_preview_box' style='width: 100%; height: 100%'>L'utente corrente non ha i permessi per visualizzare i logs dell'oggetto.</div>")));
            return;
        }

        $logs=$object->GetLog();

        $table=new AA_JSON_Template_Generic($id."_Table", array(
            "view"=>"datatable",
            "scrollX"=>false,
            "select"=>false,
            "columns"=>array(
                array("id"=>"data","header"=>array("Data",array("content"=>"textFilter")),"width"=>150, "css"=>array("text-align"=>"left")),
                array("id"=>"user","header"=>array("<div style='text-align: center'>Utente</div>",array("content"=>"selectFilter")),"width"=>120, "css"=>array("text-align"=>"center")),
                array("id"=>"msg","header"=>array("Operazione",array("content"=>"selectFilter")),"fillspace"=>true, "css"=>array("text-align"=>"left"))
            ),
            "data"=>$logs->GetLog()
        ));

        //riquadro di visualizzazione preview pdf
        $this->body->AddRow($table);
        $this->body->AddRow(new AA_JSON_Template_Generic("",array("view"=>"spacer","height"=>38)));
    }
    
    protected function Update()
    {
        parent::Update();
    }
}
