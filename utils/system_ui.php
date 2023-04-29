<?php
//Template generico JSON webix
class AA_JSON_Template_Generic
{
    //Restituisce la reppresentazione dell'oggetto come una una stringa
    public function __toString()
    {
        //Restituisce l'oggetto come stringa
        return json_encode($this->toArray());
    }

    public function toString()
    {
        return $this->__toString();
    }

    public function toBase64()
    {
        return base64_encode($this->__toString());
    }

    public function toArray()
    {
        $result = array();

        //Infopopup
        if((isset($this->props['label']) || isset($this->props['bottomLabel']))&& isset($this->props['infoPopup']) && is_array($this->props['infoPopup']))
        {
            $script="AA_MainApp.utils.callHandler(\"dlg\", {task:\"infoPopup\", params: [{id: \"".$this->props['infoPopup']['id']."\"}]},\"".$this->props['infoPopup']['id_module']."\")";
            if(isset($this->props['bottomLabel'])) $this->props['bottomLabel'].="<a href='#' onclick='".$script."'><span class='mdi mdi-help-circle'></span></a>";
            else $this->props['label'].="&nbsp;<a href='#' onclick='".$script."' title='fai click per ricevere ulteriori informazioni.'><span class='mdi mdi-help-circle'></span></a>";
        }

        //Proprietà
        foreach ($this->props as $key => $prop) {
            if ($prop instanceof AA_JSON_Template_Generic) $result[$key] = $prop->toArray();
            else $result[$key] = $prop;
        }

        //rows
        if (is_array($this->rows)) {
            $result['rows'] = array();
            foreach ($this->rows as $curRow) {
                $result['rows'][] = $curRow->toArray();
            }
        }

        //cols
        if (is_array($this->cols)) {
            $result['cols'] = array();
            foreach ($this->cols as $curCol) {
                $result['cols'][] = $curCol->toArray();
            }
        }
        if (isset($result['view']) && $result['view'] == "layout" && isset($result['rows']) && !is_array($result['rows']) && isset($result['cols']) && !is_array($result['cols'])) $result['rows'] = array(array("view" => "spacer"));

        //cells
        if (is_array($this->cells)) {
            $result['cells'] = array();
            foreach ($this->cells as $curCell) {
                $result['cells'][] = $curCell->toArray();
            }
        }
        if (isset ($result['view']) && $result['view'] == "multiview" && isset($result['cells']) && !is_array($result['cells'])) $result['cells'] = array(array("view" => "spacer"));

        //elements
        if (is_array($this->elements)) {
            $result['elements'] = array();
            foreach ($this->elements as $curCell) {
                $result['elements'][] = $curCell->toArray();
            }
        }
        if (isset($result['view']) && $result['view'] == "toolbar" && isset($result['elements']) && !is_array($result['elements'])) $result['elements'] = array(array("view" => "spacer"));

        //bodyRows
        if (is_array($this->bodyRows) || is_array($this->bodyCols)) {
            $result['body'] = array();
            if (is_array($this->bodyRows)) {
                foreach ($this->bodyRows as $curBodyRow) {
                    if (!is_array($result['body']['rows'])) $result['body']['rows'] = array();
                    $result['body']['rows'][] = $curBodyRow->toArray();
                }
            }

            if (is_array($this->bodyCols)) {
                foreach ($this->bodyCols as $curBodyCol) {
                    if (!is_array($result['body']['cols'])) $result['body']['cols'] = array();
                    $result['body']['cols'][] = $curBodyCol->toArray();
                }
            }
        }

        //Restituisce l'oggetto come array
        return $result;
    }

    protected $props = array();
    public function SetProp($prop = "", $value = "")
    {
        $this->props[$prop] = $value;
    }
    public function GetProp($prop)
    {
        if(isset($this->props[$prop])) return $this->props[$prop];
        else return "";
    }

    //Aggiunta righe
    protected $rows = null;
    public function addRow($row = null)
    {
        if ($row instanceof AA_JSON_Template_Generic) {
            //AA_Log::Log(__METHOD__." ".$row->toString(),100);

            if (!is_array($this->rows)) $this->rows = array();
            $this->rows[] = $row;
        }
    }

    //Aggiunta row al body
    protected $bodyRows = null;
    public function addRowToBody($row = null)
    {
        if ($row instanceof AA_JSON_Template_Generic) {
            //AA_Log::Log(__METHOD__." ".$row->toString(),100);

            if (!is_array($this->bodyRows)) $this->bodyRows = array();
            $this->bodyRows[] = $row;
        }
    }

    //Aggiunta col al body
    protected $bodyCols = null;
    public function addColToBody($col = null)
    {
        if ($col instanceof AA_JSON_Template_Generic) {
            //AA_Log::Log(__METHOD__." ".$row->toString(),100);

            if (!is_array($this->bodyCols)) $this->bodyCols = array();
            $this->bodyCols[] = $col;
        }
    }

    //Aggiunta colonne
    protected $cols = null;
    public function addCol($col = null)
    {
        if ($col instanceof AA_JSON_Template_Generic) {
            if (!is_array($this->cols)) $this->cols = array();
            $this->cols[] = $col;
        }
    }

    //Aggiunta celle
    protected $cells = null;
    public function addCell($cell = null, $bFromHead = false)
    {
        if ($cell instanceof AA_JSON_Template_Generic) {
            if (!is_array($this->cells)) $this->cells = array();
            if (!$bFromHead) $this->cells[] = $cell;
            else array_unshift($this->cells, $cell);
        }
    }

    //Aggiunta elementi
    protected $elements = null;
    public function addElement($obj = null)
    {
        if ($obj instanceof AA_JSON_Template_Generic) {
            if (!is_array($this->elements)) $this->elements = array();
            $this->elements[] = $obj;
        }
    }
    public function __construct($id = "", $props = null)
    {
        if ($id != "") $this->props["id"] = $id;
        else $this->props["id"]="AA_JSON_TEMPLATE_GENERIC_".uniqid(time());
        
        if (is_array($props)) {
            foreach ($props as $key => $value) {
                $this->props[$key] = $value;
            }
        }
    }

    public function GetId()
    {
        return $this->props['id'];
    }
}

//Classe per la gestione delle multiviste
class AA_JSON_Template_Multiview extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "multiview";
        if ($id == "") $id = "AA_JSON_TEMPLATE_MULTIVIEW".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei layout
class AA_JSON_Template_Layout extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "layout";
        if ($id == "") $id = "AA_JSON_TEMPLATE_LAYOUT".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dell'upload dei file nei form
class AA_JSON_Template_Fileupload extends AA_JSON_Template_Layout
{
    public function __construct($id = "", $props = null, $sessionFileName="AA_SessionFileUploader")
    {
        if ($id == "") $id = "AA_JSON_TEMPLATE_FILEUPLOAD".uniqid(time());
        $props['name'] = "AA_FileUploader";

        if (!isset($props['value'])) $props['value'] = "Sfoglia...";
        $props['autosend'] = false;
        if ($props['multiple'] == "") $props['multiple'] = false;
        $props['view'] = "uploader";
        $props['link'] = $id . "_FileUpload_List";
        $props['layout_id'] = $id . "_FileUpload_Layout";
        $props['formData'] = array("file_id" => $sessionFileName);

        parent::__construct($id . "_FileUpload_Layout", array("type" => "clean", "borderless" => true,"autoheight"=>true));

        $this->AddRow(new AA_JSON_Template_Generic($id . "_FileUpload_Field", $props));
        $this->AddRow(new AA_JSON_Template_Generic($id . "_FileUpload_List", array(
            "view" => "list",
            "scroll" => false,
            "autoheight"=>true,
            "minHeight"=>32,
            "type" => "uploader",
            "css" => array("background" => "transparent")
        )));

        if ($props['bottomLabel']) {
            $this->AddRow(new AA_JSON_Template_Template($id . "_FileUpload_BottomLabel", array(
                "autoheight"=>true,
                "template" => "<span style='font-size: smaller; font-style:italic'>" . $props['bottomLabel'] . "</span>",
                "css" => array("background" => "transparent")
            )));
        }
    }
}

//Classe per la gestione dei caroselli
class AA_JSON_Template_Carousel extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["navigation"]=array();
        $this->props["view"] = "carousel";
        $this->props["navigation"]["type"] = "side";
        $this->props["navigation"]["items"]=true;
        $this->props["scrollSpeed"]="800ms";

        if ($id == "") $id = "AA_JSON_TEMPLATE_CAROUSEL".uniqid(time());

        parent::__construct($id, $props);
    }

    protected $slides=array();
    public function AddSlide($slide=null)
    {
        if($slide instanceof AA_JSON_Template_Generic)
        {
            $this->slides[]=$slide;
        }
    }

    protected $autoScroll=false;
    protected $autoScrollSlideTime=5000;
    public function EnableAutoScroll($bVal=true)
    {
        $this->autoScroll=$bVal;
    }
    public function SetAutoScrollSlideTime($val=5000)
    {
        if($val > 1000)
        {
            $this->autoScrollSlideTime=$val;
        }
    }

    public function ShowNavigationButtons($bVal=true)
    {
        $this->props['navigation']['buttons']=$bVal;
    }

    public function SetScrollSpeed($speed=500)
    {
        if($speed > 0) $this->props["scrollSpeed"]=$speed."ms";
    }

    public function GetSlides()
    {
        return $this->slides;
    }

    public function SetTipe($newType="side")
    {
        $this->props["navigation"]["type"]=$newType;
    }

    public function ShowItems($show=true)
    {
        $this->props["navigation"]["items"]=$show;
    }

    public function toArray()
    {
        foreach ($this->slides as $curSlide)
        {
            $this->AddCol($curSlide);
        }

        $this->props['autoScroll']=$this->autoScroll;
        $this->props['autoScrollSlideTime']=$this->autoScrollSlideTime;
        $this->props['slidesCount']=sizeof($this->slides);

        return parent::toArray();
    }
}

//Classe per la gestione delle toolbar
class AA_JSON_Template_Toolbar extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "toolbar";
        if ($id == "") $id = "AA_JSON_TEMPLATE_TOOLBAR".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione delle tree view
class AA_JSON_Template_Search extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "search";
        if ($id == "") $id = "AA_JSON_TEMPLATE_SEARCH".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione delle date
class AA_JSON_Template_Datepicker extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "datepicker";
        if ($id == "") $id = "AA_JSON_TEMPLATE_DATEPICKER".uniqid(time());
        if(!isset($props['clear'])) $props['clear']=true;

        parent::__construct($id, $props);
    }
}

//Classe per la gestione delle tree view
class AA_JSON_Template_Tree extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "tree";
        if ($id == "") $id = "AA_JSON_TEMPLATE_TREE".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei template
class AA_JSON_Template_Template extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "template";
        if ($id == "") $id = "AA_JSON_TEMPLATE_TEMPLATE".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei checkbox
class AA_JSON_Template_Checkbox extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "checkbox";
        if ($id == "") $id = "AA_JSON_TEMPLATE_CHECKBOX".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei switch
class AA_JSON_Template_Switch extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "switch";
        if ($id == "") $id = "AA_JSON_TEMPLATE_SWITCH".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei campi di testo
class AA_JSON_Template_Text extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "text";
        if ($id == "") $id = "AA_JSON_TEMPLATE_TEMPLATE".uniqid(time());
        if(!isset($props['clear'])) $props['clear']=true;

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei campi di testo
class AA_JSON_Template_Richtext extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "richtext";
        if ($id == "") $id = "AA_JSON_TEMPLATE_RICHTEXT_".uniqid(time());
        if(!isset($props['clear'])) $props['clear']=true;

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei campi di testo
class AA_JSON_Template_Select extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "richselect";
        if ($id == "") $id = "AA_JSON_TEMPLATE_RICHSELECT".uniqid(time());

        parent::__construct($id, $props);
    }
}



//Classe per la gestione dei campi radio
class AA_JSON_Template_Radio extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "radio";
        if ($id == "") $id = "AA_JSON_TEMPLATE_RADIO".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione del textarea
class AA_JSON_Template_Textarea extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "textarea";
        if ($id == "") $id = "AA_JSON_TEMPLATE_TEMPLATE".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione dei form
class AA_JSON_Template_Form extends AA_JSON_Template_Generic
{
    public function __construct($id = "", $props = null)
    {
        $this->props["view"] = "form";
        if ($id == "") $id = "AA_JSON_TEMPLATE_FORM".uniqid(time());

        parent::__construct($id, $props);
    }
}

//Classe per la gestione del layout delle finestre
class AA_GenericWindowTemplate
{
    protected $id = "AA_TemplateGenericWnd";
    public function SetId($id = "")
    {
        if ($id != "") $this->id = $id;
    }

    public function GetId()
    {
        return $this->id;
    }

    public function GetWndId()
    {
        return $this->id."_Wnd";
    }

    protected $body = "";
    protected $head = "";
    protected $wnd = "";

    protected $modal = true;
    public function EnableModal()
    {
        $this->modal = true;
    }
    public function DisableModal()
    {
        $this->modal = false;
    }

    protected $module = "";
    public function SetModule($idModule)
    {
        $this->module = $idModule;
    }
    public function GetModule()
    {
        return $this->module;
    }

    private $title = "finestra di dialogo";
    public function __construct($id = "", $title = "", $module = "")
    {
        if ($id != "") $this->id = $id;
        if ($title != "") $this->title = $title;

        //AA_Log::Log(__METHOD__." - ".$module,100);

        $this->module = $module;

        $script = 'try{if($$(\'' . $this->id . '_Wnd\').config.fullscreen){webix.fullscreen.exit();$$(\'' . $this->id . '_btn_resize\').define({icon:"mdi mdi-fullscreen", tooltip:"Mostra la finestra a schermo intero"});$$(\'' . $this->id . '_btn_resize\').refresh();}else{webix.fullscreen.set($$(\'' . $this->id . '_Wnd\'));$$(\'' . $this->id . '_btn_resize\').define({icon:"mdi mdi-fullscreen-exit", tooltip:"Torna alla visualizzazione normale"});$$(\'' . $this->id . '_btn_resize\').refresh();}}catch(msg){console.error(msg);}';

        $this->body = new AA_JSON_Template_Layout($this->id . "_Content_Box", array("type" => "clean"));
        $this->head = new AA_JSON_Template_Generic($this->id . "_head", array("css" => "AA_Wnd_header_box", "view" => "toolbar", "height" => "38", "elements" => array(
            array("id" => $this->id . "_Title", "css" => "AA_Wnd_title", "template" => $this->title),
            array("id" => $this->id . "_btn_resize", "view" => "icon", "icon" => "mdi mdi-fullscreen", "css" => "AA_Wnd_btn_fullscreen", "width" => 24, "height" => 24, "tooltip" => "Mostra la finestra a schermo intero", "click" => $script),
            array("id" => $this->id . "_btn_close", "view" => "icon", "icon" => "mdi mdi-close", "css" => "AA_Wnd_btn_close", "width" => 24, "height" => 24, "tooltip" => "Chiudi la finestra", "click" => "try{if($$('" . $this->id . "_Wnd').config.fullscreen){webix.fullscreen.exit();};$$('" . $this->id . "_Wnd').close();}catch(msg){console.error(msg)}")
        )));

        $this->wnd = new AA_JSON_Template_Generic($this->id . "_Wnd", array(
            "view" => "window",
            "height" => $this->height,
            "width" => $this->width,
            "position" => "center",
            "modal" => $this->modal,
            "move" => true,
            "resize" => true,
            "css" => "AA_Wnd"
        ));

        $this->wnd->SetProp("head", $this->head);
        $this->wnd->SetProp("body", $this->body);
    }

    protected function Update()
    {
        $this->wnd->setProp("height", $this->height);
        $this->wnd->setProp("width", $this->width);
        $this->wnd->setProp("modal", $this->modal);
    }

    protected $width = "1280";
    public function SetWidth($width = "1280")
    {
        if ($width > 0) $this->width = $width;
    }
    public function GetWidth()
    {
        return $this->width;
    }

    protected $height = "720";
    public function SetHeight($height = "720")
    {
        if ($height > 0) $this->height = $height;
    }
    public function GetHeight()
    {
        return $this->height;
    }

    //Gestione del contenuto
    public function AddView($view)
    {
        if (is_array($view) && $view['id'] != "") {
            $this->body->AddRow(new AA_JSON_Template_Generic($view['id'], $view));
        }

        if ($view instanceof AA_JSON_Template_Generic) $this->body->AddRow($view);
    }

    public function __toString()
    {
        $this->Update();
        return json_encode($this->wnd->toArray());
    }

    public function toString()
    {
        return $this->__toString();
    }

    public function GetObject()
    {
        $this->Update();
        return $this->wnd;
    }

    public function toBase64()
    {
        $this->Update();

        return $this->wnd->toBase64();
    }
}

//Template generic filter box
class AA_GenericFormDlg extends AA_GenericWindowTemplate
{
    protected $form = "";
    public function GetForm()
    {
        return $this->form;
    }
    public function GetFormId()
    {
        if ($this->form instanceof AA_JSON_Template_Form) return $this->form->GetId();
    }

    protected $layout = "";
    public function GetLayout()
    {
        return $this->layout;
    }
    public function GetLayoutId()
    {
        if ($this->layout instanceof AA_JSON_Template_Generic) return $this->layout->GetId();
    }

    protected $curRow = null;
    public function GetCurRow()
    {
        return $this->curRow;
    }

    protected $bottomPadding = 18;
    public function SetBottomPadding($val = 18)
    {
        $this->bottomPadding = $val;
    }

    protected $validation = false;
    public function EnableValidation($bVal = true)
    {
        $this->validation = $bVal;
    }

    protected $bEnableApplyHotkey = true;
    public function EnableApplyHotkey($bVal = true)
    {
        $this->bEnableApplyHotkey = $bVal;
    }

    protected $sApplyHotkey = "enter";
    public function SetApplyHotkey($val = "enter")
    {
        $this->sApplyHotkey = $val;
    }

    protected $applyActions = "";
    public function SetApplyActions($actions = "")
    {
        $this->applyActions = $actions;
    }

    protected $saveFormDataId = "";
    public function SetSaveformDataId($id = "")
    {
        $this->saveFormDataId = $id;
    }
    public function GetSaveFormDataId()
    {
        return $this->saveFormDataId;
    }

    protected $labelWidth = 120;
    public function SetLabelWidth($val = 120)
    {
        $this->labelWidth = $val;
    }

    protected $labelAlign = "left";
    public function SetLabelAlign($val = "left")
    {
        $this->labelAlign = $val;
    }

    protected $labelPosition="left";
    public function SetLabelPosition($val = "left")
    {
        $this->labelPosition = $val;
    }

    //Gestione pulsanti
    protected $applyButton = null;
    protected $applyButtonName = "Salva";
    public function SetApplyButtonName($val = "Salva")
    {
        $this->applyButtonName = $val;
    }
    protected $resetButtonName = "Reset";
    public function SetResetButtonName($val = "Reset")
    {
        $this->resetButtonName = $val;
    }
    protected $enableReset = true;
    public function EnableResetButton($bVal = true)
    {
        $this->enableReset = $bVal;
    }
    protected $applyButtonStyle="";
    public function SetApplybuttonStyle($sStyle="")
    {
        $this->applyButtonStyle = $sStyle;
    }
    protected $applyButtonPosition="right";
    public function SetApplybuttonPosition($sVal="right")
    {
        $this->applyButtonPosition = $sVal;
    }
    #----------------------------------------------------

    //Valori form
    protected $formData = array();
    protected $resetData = array();

    public function __construct($id = "", $title = "", $module = "", $formData = array(), $resetData = array(), $applyActions = "", $save_formdata_id = "")
    {
        parent::__construct($id, $title, $module);

        //AA_Log::Log(__METHOD__." - ".$module,100);

        $this->SetWidth("700");
        $this->SetHeight("400");

        $this->applyActions = $applyActions;
        $this->saveFormDataId = $save_formdata_id;
        $this->formData = $formData;
        if (sizeof($resetData) == 0) $resetData = $formData;
        $this->resetData = $resetData;

        $this->form = new AA_JSON_Template_Form($this->id . "_Form", array(
            "data" => $formData,
        ));

        $this->body->AddRow($this->form);
        $this->layout = new AA_JSON_Template_Layout($id . "_Form_Layout", array("type" => "clean"));
        $this->form->AddRow($this->layout);

        $this->body->AddRow(new AA_JSON_Template_Generic("", array("view" => "spacer", "height" => 10, "css" => array("border-top" => "1px solid #e6f2ff !important;"))));
    }

    //File upload id
    protected $fileUploader_id = "";
    public function SetFileUploaderId($id="")
    {
        $this->fileUploader_id=$id;
    }

    #Gestione salvataggio dati
    protected $refresh = true; //Rinfresca la view in caso di salvataggio 
    public function enableRefreshOnSuccessfulSave($bVal = true)
    {
        $this->refresh = $bVal;
    }
    protected $refresh_obj_id = "";
    public function SetRefreshObjId($id = "")
    {
        $this->refresh_obj_id = $id;
    }
    protected $closeWnd = true;
    public function EnableCloseWndOnSuccessfulSave($bVal = true)
    {
        $this->closeWnd = $bVal;
    }
    protected $saveTask = "";
    public function SetSaveTask($task = "")
    {
        $this->saveTask = $task;
    }
    protected $saveTaskParams = array();
    public function SetSaveTaskParams($params = array())
    {
        if (is_array($params)) $this->saveTaskParams = $params;
    }
    #-----------------------------------------------------    
    protected function Update()
    {
        $elementsConfig = array("labelWidth" => $this->labelWidth, "labelAlign" => $this->labelAlign, "bottomPadding" => $this->bottomPadding,"labelPosition"=>$this->labelPosition);
        if ($this->validation) {
            $this->form->SetProp("validation", "validateForm");
        }

        $this->form->SetProp("elementsConfig", $elementsConfig);

        if ($this->applyActions == "") {
            if ($this->saveTask != "") {
                $params = "{task: '$this->saveTask'";
                if (sizeof($this->saveTaskParams) > 0) $params .= ", taskParams: " . json_encode(array($this->saveTaskParams));
                if ($this->closeWnd) $params .= ", wnd_id: '" . $this->id . "_Wnd'";
                if ($this->refresh) $params .= ", refresh: true";
                if ($this->refresh_obj_id) $params .= ", refresh_obj_id: '$this->refresh_obj_id'";
                if ($this->fileUploader_id != "") $params .= ", fileUploader_id: '$this->fileUploader_id'";
                $params .= ", data: $$('" . $this->id . "_Form').getValues()}";
                if ($this->validation) $validate = "if($$('" . $this->id . "_Form').validate())";
                else $validate = "";
                $this->applyActions = $validate . "AA_MainApp.utils.callHandler('saveData',$params,'$this->module')";
            }
        }

        //Apply button
        if($this->bEnableApplyHotkey) $this->applyButton = new AA_JSON_Template_Generic($this->id . "_Button_Bar_Apply", array("view" => "button", "width" => 80, "css"=>"webix_primary ".$this->applyButtonStyle,"hotkey"=>$this->sApplyHotkey,"label" => $this->applyButtonName));
        else $this->applyButton = new AA_JSON_Template_Generic($this->id . "_Button_Bar_Apply", array("view" => "button", "width" => 80, "css"=>"webix_primary".$this->applyButtonStyle,"label" => $this->applyButtonName));

        //Toolbar
        $toolbar = new AA_JSON_Template_Layout($this->id . "_Button_Bar", array("height" => 38));
        $toolbar->addCol(new AA_JSON_Template_Generic("", array("view" => "spacer", "width" => 15)));

        //reset form button
        if ($this->enableReset && is_array($this->resetData)) {
            $resetAction = "if($$('" . $this->id . "_Form')) $$('" . $this->id . "_Form').setValues(" . json_encode($this->resetData) . ")";
            $toolbar->addCol(new AA_JSON_Template_Generic($this->id . "_Button_Bar_Reset", array("view" => "button", "width" => 80, "label" => $this->resetButtonName, "tooltip" => "Reimposta i valori di default", "click" => $resetAction)));
        }

        if($this->applyButtonPosition != "left") $toolbar->addCol(new AA_JSON_Template_Generic());
        $toolbar->addCol($this->applyButton);
        if($this->applyButtonPosition != "right") $toolbar->addCol(new AA_JSON_Template_Generic());
        
        $toolbar->addCol(new AA_JSON_Template_Generic("", array("view" => "spacer", "width" => 15)));
        $this->body->AddRow($toolbar);
        $this->body->AddRow(new AA_JSON_Template_Generic("", array("view" => "spacer", "height" => 10)));
        $this->applyButton->SetProp("click", $this->applyActions);

        parent::Update();
    }

    //Aggiungi un campo al form
    public function AddField($name = "", $label = "", $type = "text", $props = array(), $newRow = true)
    {
        if ($name != "" && $label != "") {
            $props['name'] = $name;
            $props['label'] = $label;

            if ($newRow || !($this->curRow instanceof AA_JSON_Template_Layout)) {
                $this->curRow = new AA_JSON_Template_Layout($this->id . "_Layout_Row_".uniqid(time()));
                $this->layout->AddRow($this->curRow);
            }
            if ($type == "text") $this->curRow->AddCol(new AA_JSON_Template_Text($this->id . "_Field_" . $name, $props));
            if ($type == "richtext") $this->curRow->AddCol(new AA_JSON_Template_Richtext($this->id . "_Field_" . $name, $props));
            if ($type == "textarea") $this->curRow->AddCol(new AA_JSON_Template_Textarea($this->id . "_Field_" . $name, $props));
            if ($type == "checkbox") $this->curRow->AddCol(new AA_JSON_Template_Checkbox($this->id . "_Field_" . $name, $props));
            if ($type == "select") $this->curRow->AddCol(new AA_JSON_Template_Select($this->id . "_Field_" . $name, $props));
            if ($type == "switch") $this->curRow->AddCol(new AA_JSON_Template_Switch($this->id . "_Field_" . $name, $props));
            if ($type == "datepicker") $this->curRow->AddCol(new AA_JSON_Template_Datepicker($this->id . "_Field_" . $name, $props));
            if ($type == "radio") $this->curRow->AddCol(new AA_JSON_Template_Radio($this->id . "_Field_" . $name, $props));

            //Se il campo è invisibile aggiunge uno spacer
            if (isset($props['hidden']) && $props['hidden'] == true) {
                $this->curRow->AddCol(new AA_JSON_Template_Generic($this->id . "_Spacer_" . $name, array("view" => "spacer", "minHeight" => "0", "minWidth" => "0", "height" => 1)));
            }
        }
    }

    //Aggiungi una nuova sezione
    public function AddSection($name = "New Section", $newRow = true)
    {
        if ($newRow || !($this->curRow instanceof AA_JSON_Template_Layout)) {
            $this->curRow = new AA_JSON_Template_Layout($this->id . "_Layout_Row_".uniqid(time()));
            $this->layout->AddRow($this->curRow);
            $this->curRow->AddCol(new AA_JSON_Template_Generic($this->id . "_Section_", array("type" => "section", "template" => $name)));
        } else {
            $this->curRow->AddCol(new AA_JSON_Template_Generic($this->id . "_Section_" . $name, array("type" => "section", "template" => $name)));
        }
    }

    //Aggiungi uno spazio
    public function AddSpacer($newRow = true)
    {
        if ($newRow) {
            $this->curRow = new AA_JSON_Template_Layout($this->id . "_Layout_Row_".uniqid(time()));
            $this->layout->AddRow($this->curRow);
        }

        $this->curRow->AddCol(new AA_JSON_Template_Generic($this->id . "_Field_Spacer_".uniqid(time()), array("view" => "spacer")));
    }

    //Aggiungi un campo di testo
    public function AddTextField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "text", $props, $newRow);
    }

    //Aggiungi un campo di area di testo
    public function AddTextareaField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "textarea", $props, $newRow);
    }

    //Aggiungi un campo richtext
    public function AddRichtextField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "richtext", $props, $newRow);
    }

    //Aggiungi un checkbox
    public function AddCheckBoxField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "checkbox", $props, $newRow);
    }

    //Aggiungi un switchbox
    public function AddSwitchBoxField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "switch", $props, $newRow);
    }

    //Aggiungi una select
    public function AddSelectField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "select", $props, $newRow);
    }

    //Aggiungi un radio control
    public function AddRadioField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "radio", $props, $newRow);
    }

    //Aggiungi un campo per la scelta delle strutture
    public function AddStructField($taskParams = array(), $params = array(), $fieldParams = array(), $newRow = true)
    {
        $onSearchScript = "try{ if($$('" . $this->id . "_Form').getValues().id_struct_tree_select) AA_MainApp.ui.MainUI.structDlg.lastSelectedItem={id: $$('" . $this->id . "_Form').getValues().id_struct_tree_select}; AA_MainApp.ui.MainUI.structDlg.show(" . json_encode($taskParams) . "," . json_encode($params) . ");}catch(msg){console.error(msg)}";

        if ($newRow) {
            $this->curRow = new AA_JSON_Template_Layout($this->id . "_Layout_Row_".uniqid(time()));
            $this->layout->AddRow($this->curRow);
        }

        if (!isset($fieldParams['name']) || $fieldParams['name'] == "") $fieldParams['name'] = "struct_desc";
        if (!isset($fieldParams['label']) || $fieldParams['label'] == "") $fieldParams['label'] = "Struttura";
        if (!isset($fieldParams['readonly']) || $fieldParams['readonly'] == "") $fieldParams['readonly'] = true;
        if (!isset($fieldParams['click']) || $fieldParams['click'] == "") $fieldParams['click'] = $onSearchScript;

        $this->curRow->AddCol(new AA_JSON_Template_Search($this->id . "_Field_Struct_Search", $fieldParams));
    }

    //Aggiungi un campo per l'upload di file
    public function AddFileUploadField($name = "AA_FileUploader", $label = "Sfoglia...", $props = array(), $newRow = true)
    {
        if ($newRow) {
            $this->curRow = new AA_JSON_Template_Layout($this->id . "_Layout_Row_".uniqid(time()));
            $this->layout->AddRow($this->curRow);
        }

        $props['name'] = "AA_FileUploader";
        if ($label == "") $props['value'] = "Sfoglia...";
        else $props['value'] = $label;
        $props['autosend'] = false;
        if (!isset($props['multiple']) || $props['multiple'] == "") $props['multiple'] = false;
        $props['view'] = "uploader";
        $props['link'] = $this->id . "_FileUpload_List";
        $props['layout_id'] = $this->id . "_FileUpload_Layout";
        $props['formData'] = array("file_id" => $name);

        $this->fileUploader_id = $this->id . "_FileUpload_Field";

        $template = new AA_JSON_Template_Layout($this->id . "_FileUpload_Layout", array("type" => "clean", "borderless" => true,"autoheight"=>true,));
        $template->AddRow(new AA_JSON_Template_Generic($this->id . "_FileUpload_Field", $props));
        $template->AddRow(new AA_JSON_Template_Generic($this->id . "_FileUpload_List", array(
            "view" => "list",
            "scroll" => false,
            "autoheight"=>true,
            "autoHeight"=>32,
            "type" => "uploader",
            "css" => array("background" => "transparent")
        )));

        if ($props['bottomLabel']) {
            $template->AddRow(new AA_JSON_Template_Template($this->id . "_FileUpload_BottomLabel", array(
                "autoheight"=>true,
                "template" => "<span style='font-size: smaller; font-style:italic'>" . $props['bottomLabel'] . "</span>",
                "css" => array("background" => "transparent")
            )));
        }

        $this->curRow->AddCol($template);
    }

    //Aggiungi un campo data
    public function AddDateField($name = "", $label = "", $props = array(), $newRow = true)
    {
        $props['timepick'] = false;
        if (!isset($props['format']) || $props['format'] == "") $props['format'] = "%Y-%m-%d";
        $props['stringResult'] = true;
        return $this->AddField($name, $label, "datepicker", $props, $newRow);
    }

    //Aggiungi un generico oggetto
    public function AddGenericObject($obj, $newRow = true)
    {
        if ($obj instanceof AA_JSON_Template_Generic) {
            if ($newRow) {
                $this->curRow = new AA_JSON_Template_Layout($this->id . "_Layout_Row_".uniqid(time()));
                $this->layout->AddRow($this->curRow);
            }

            $this->curRow->AddCol($obj);
        }
    }
}

//Template generic filter box
class AA_GenericFilterDlg extends AA_GenericFormDlg
{
    protected $saveFilterId = "";
    public function SetSaveFilterId($id = "")
    {
        $this->saveFilterId = $id;
    }
    public function GetSaveFilterId()
    {
        return $this->saveFilterId;
    }

    protected $enableSessionSave = false;
    public function EnableSessionSave($bVal = true)
    {
        $this->enableSessionSave = $bVal;
    }

    public function __construct($id = "", $title = "", $module = "", $formData = array(), $resetData = array(), $applyActions = "", $save_filter_id = "")
    {
        parent::__construct($id, $title, $module, $formData, $resetData, $applyActions, $save_filter_id);

        $this->SetWidth("700");
        $this->SetHeight("400");

        $this->applyActions = $applyActions;
        $this->saveFilterId = $save_filter_id;

        /*$this->form=new AA_JSON_Template_Form($this->id."_Form",array(
            "data"=>$formData,
            "elementsConfig"=>array("labelWidth"=>180)
        ));
        
        $this->body->AddRow($this->form);
        
        $this->body->AddRow(new AA_JSON_Template_Generic("", array("view"=>"spacer", "height"=>10, "css"=>array("border-top"=>"1px solid #e6f2ff !important;"))));
        
        //Apply button
        $this->applyButton = new AA_JSON_Template_Generic($this->id."_Button_Bar_Apply",array("view"=>"button","width"=>80, "label"=>"Applica"));
        
        //Toolbar
        $toolbar=new AA_JSON_Template_Layout($this->id."_Button_Bar",array("height"=>38));
        $toolbar->addCol(new AA_JSON_Template_Generic("spacer",array("view"=>"spacer","width"=>15)));
        
        //reset form button
        if(is_array($resetData))$resetAction="if($$('".$this->id."_Form')) $$('".$this->id."_Form').setValues(".json_encode($resetData).")";
        else $resetAction="";
        $toolbar->addCol(new AA_JSON_Template_Generic($this->id."_Button_Bar_Reset",array("view"=>"button","width"=>80,"label"=>"Reset", "tooltip"=>"Reimposta i valori di default", "click"=>$resetAction)));
        
        $toolbar->addCol(new AA_JSON_Template_Generic());
        
        $toolbar->addCol($this->applyButton);
        $toolbar->addCol(new AA_JSON_Template_Generic("spacer",array("view"=>"spacer","width"=>15)));
        $this->body->AddRow($toolbar);
        $this->body->AddRow(new AA_JSON_Template_Generic("spacer",array("view"=>"spacer","height"=>10)));*/
    }

    protected function Update()
    {
        parent::Update();

        if ($this->module == "") $module = "module=AA_MainApp.curModule";
        else $module = "module=AA_MainApp.getModule('" . $this->module . "')";

        if ($this->saveFilterId == "") $filter_id = "module.getActiveView()";
        else $filter_id = "'" . $this->saveFilterId . "'";

        if ($this->enableSessionSave) {
            $sessionSave = "AA_MainApp.setSessionVar(" . $filter_id . ", $$('" . $this->id . "_Form').getValues());";
        }
        else $sessionSave="";

        $this->applyButton->SetProp("click", "try{" . $module . "; if(module.isValid()) {" . $sessionSave . "module.setRuntimeValue(" . $filter_id . ",'filter_data',$$('" . $this->id . "_Form').getValues());" . $this->applyActions . ";}$$('" . $this->id . "_Wnd').close()}catch(msg){console.error(msg)}");
    }

    /*
    //Aggiungi un campo al form
    public function AddField($name="", $label="", $type="text", $props=array())
    {
        if($name !="" && $label !="")
        {
            $props['name']=$name;
            $props['label']=$label;
            
            if($type=="text") $this->form->AddElement(new AA_JSON_Template_Text($this->id."_Field_".$name,$props));
            if($type=="textarea") $this->form->AddElement(new AA_JSON_Template_Textarea($this->id."_Field_".$name,$props));
            if($type=="checkbox") $this->form->AddElement(new AA_JSON_Template_Checkbox($this->id."_Field_".$name,$props));
            if($type=="select") $this->form->AddElement(new AA_JSON_Template_Select($this->id."_Field_".$name,$props));
            if($type=="switch") $this->form->AddElement(new AA_JSON_Template_Switch($this->id."_Field_".$name,$props));
        }
    }
    
    //Aggiungi un campo di testo
    public function AddTextField($name="", $label="", $props=array())
    {
        return $this->AddField($name,$label,"text",$props);
    }
    
    //Aggiungi un campo di area di testo
    public function AddTextareaField($name="", $label="", $props=array())
    {
        return $this->AddField($name,$label,"textarea",$props);
    }
    
    //Aggiungi un checkbox
    public function AddCheckBoxField($name="", $label="", $props=array())
    {
        return $this->AddField($name,$label,"checkbox",$props);
    }
    
    //Aggiungi un switchbox
    public function AddSwitchBoxField($name="", $label="", $props=array())
    {
        return $this->AddField($name,$label,"switch",$props);
    }
    
    //Aggiungi una select
    public function AddSelectField($name="", $label="", $props=array())
    {
        return $this->AddField($name,$label,"select",$props);
    }
    
    //Aggiungi un campo per la scelta delle strutture
    public function AddStructField($taskParams=array(),$params=array(), $fieldParams=array())
    {
        $onSearchScript="try{ if($$('".$this->id."_Form').getValues().id_struct_tree_select) AA_MainApp.ui.MainUI.structDlg.lastSelectedItem={id: $$('".$this->id."_Form').getValues().id_struct_tree_select}; AA_MainApp.ui.MainUI.structDlg.show(". json_encode($taskParams).",".json_encode($params).");}catch(msg){console.error(msg)}";
        
        if($fieldParams['name']== "") $fieldParams['name']="struct_desc";
        if($fieldParams['label']== "") $fieldParams['label']="Struttura";
        if($fieldParams['readonly']== "") $fieldParams['readonly']=true;
        if($fieldParams['click']== "") $fieldParams['click']=$onSearchScript;
        
        $this->form->AddElement(new AA_JSON_Template_Search($this->id."_Field_Struct_Search",$fieldParams));
    }*/
}

//Classe gestione set di campi 
class AA_FieldSet extends AA_JSON_Template_Generic
{
    public function __construct($id = "field_set", $label = "Generic field set")
    {
        $this->props['view'] = "fieldset";
        $this->props['label'] = $label;
        $this->props['id']=$id;
        $this->layout = new AA_JSON_Template_Layout($id . "_FieldSet_Layout", array("type" => "clean"));
        $this->addRowToBody($this->layout);
    }

    protected $layout = null;
    public function GetLayout()
    {
        return $this->layout;
    }
    public function GetLayoutId()
    {
        if ($this->layout instanceof AA_JSON_Template_Generic) return $this->layout->GetId();
    }

    protected $curRow = null;
    public function GetCurRow()
    {
        return $this->curRow;
    }

    //Aggiungi un campo al field set
    public function AddField($name = "", $label = "", $type = "text", $props = array(), $newRow = true)
    {
        if ($name != "" && $label != "") {
            $props['name'] = $name;
            $props['label'] = $label;

            if ($newRow || !($this->curRow instanceof AA_JSON_Template_Layout)) {
                $unique=uniqid(time());
                $this->curRow = new AA_JSON_Template_Layout($this->GetId() . "_Layout_Row_".$unique);
                $this->layout->AddRow($this->curRow);
            }

            if ($type == "text") $this->curRow->AddCol(new AA_JSON_Template_Text($this->GetId() . "_Field_" . $name, $props));
            if ($type == "textarea") $this->curRow->AddCol(new AA_JSON_Template_Textarea($this->GetId() . "_Field_" . $name, $props));
            if ($type == "checkbox") $this->curRow->AddCol(new AA_JSON_Template_Checkbox($this->GetId() . "_Field_" . $name, $props));
            if ($type == "select") $this->curRow->AddCol(new AA_JSON_Template_Select($this->GetId() . "_Field_" . $name, $props));
            if ($type == "switch") $this->curRow->AddCol(new AA_JSON_Template_Switch($this->GetId() . "_Field_" . $name, $props));
            if ($type == "datepicker") $this->curRow->AddCol(new AA_JSON_Template_Datepicker($this->GetId() . "_Field_" . $name, $props));
            if ($type == "radio") $this->curRow->AddCol(new AA_JSON_Template_Radio($this->GetId() . "_Field_" . $name, $props));
        }
    }

    //Aggiungi una nuova sezione
    public function AddSection($name = "New Section", $newRow = true)
    {
        if ($newRow) {
            $unique=uniqid(time());
            $this->curRow = new AA_JSON_Template_Layout($this->GetId() . "_Layout_Row_".$unique);
            $this->layout->AddRow($this->curRow);
            $this->curRow->AddCol(new AA_JSON_Template_Generic($this->GetId() . "_Section_", array("type" => "section", "template" => $name)));
        } else {
            $this->curRow->AddCol(new AA_JSON_Template_Generic($this->GetId() . "_Section_" . $name, array("type" => "section", "template" => $name)));
        }
    }

    //Aggiungi uno spazio
    public function AddSpacer($newRow = true)
    {
        $unique=uniqid(time());
        if ($newRow || !($this->curRow instanceof AA_JSON_Template_Layout)) {
            
            $this->curRow = new AA_JSON_Template_Layout($this->GetId() . "_Layout_Row_".$unique);
            $this->layout->AddRow($this->curRow);
        }
        $this->curRow->AddCol(new AA_JSON_Template_Generic($this->GetId() . "_Field_Spacer_".$unique, array("view" => "spacer")));
    }

    //Aggiungi un campo di testo
    public function AddTextField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "text", $props, $newRow);
    }

    //Aggiungi un campo di area di testo
    public function AddTextareaField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "textarea", $props, $newRow);
    }

    //Aggiungi un checkbox
    public function AddCheckBoxField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "checkbox", $props, $newRow);
    }

    //Aggiungi un switchbox
    public function AddSwitchBoxField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "switch", $props, $newRow);
    }

    //Aggiungi una select
    public function AddSelectField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "select", $props, $newRow);
    }

    //Aggiungi un radio control
    public function AddRadioField($name = "", $label = "", $props = array(), $newRow = true)
    {
        return $this->AddField($name, $label, "radio", $props, $newRow);
    }

    //Aggiungi un campo per la scelta delle strutture
    public function AddStructField($taskParams = array(), $params = array(), $fieldParams = array(), $newRow = true)
    {
        $onSearchScript = "try{ if($$('" . $this->GetId() . "_Form').getValues().id_struct_tree_select) AA_MainApp.ui.MainUI.structDlg.lastSelectedItem={id: $$('" . $this->GetId() . "_Form').getValues().id_struct_tree_select}; AA_MainApp.ui.MainUI.structDlg.show(" . json_encode($taskParams) . "," . json_encode($params) . ");}catch(msg){console.error(msg)}";

        if ($newRow) {
            $this->curRow = new AA_JSON_Template_Layout($this->GetId() . "_Layout_Row_".uniqid(time()));
            $this->layout->AddRow($this->curRow);
        }

        if ($fieldParams['name'] == "") $fieldParams['name'] = "struct_desc";
        if ($fieldParams['label'] == "") $fieldParams['label'] = "Struttura";
        if ($fieldParams['readonly'] == "") $fieldParams['readonly'] = true;
        if ($fieldParams['click'] == "") $fieldParams['click'] = $onSearchScript;

        $this->curRow->AddCol(new AA_JSON_Template_Search($this->GetId() . "_Field_Struct_Search", $fieldParams));
    }

    protected $fileUploader_id="";

    //Aggiungi un campo per l'upload di file
    public function AddFileUploadField($name = "AA_FileUploader", $label = "Sfoglia...", $props = array(), $newRow = true)
    {
        if ($newRow) {
            $this->curRow = new AA_JSON_Template_Layout($this->GetId() . "_Layout_Row_".uniqid(time()));
            $this->layout->AddRow($this->curRow);
        }

        $props['name'] = "AA_FileUploader";
        if ($label == "") $props['value'] = "Sfoglia...";
        else $props['value'] = $label;
        $props['autosend'] = false;
        if ($props['multiple'] == "") $props['multiple'] = false;
        $props['view'] = "uploader";
        $props['link'] = $this->GetId() . "_FileUpload_List";
        $props['layout_id'] = $this->GetId() . "_FileUpload_Layout";
        $props['formData'] = array("file_id" => $name);

        $this->fileUploader_id = $this->GetId() . "_FileUpload_Field";

        $template = new AA_JSON_Template_Layout($this->GetId() . "_FileUpload_Layout", array("type" => "clean", "borderless" => true,"autoheight"=>true));
        $template->AddRow(new AA_JSON_Template_Generic($this->GetId() . "_FileUpload_Field", $props));
        $template->AddRow(new AA_JSON_Template_Generic($this->GetId() . "_FileUpload_List", array(
            "view" => "list",
            "scroll" => false,
            "autoheight"=>true,
            "minHeight"=>32,
            "type" => "uploader",
            "css" => array("background" => "transparent")
        )));

        if ($props['bottomLabel']) {
            $template->AddRow(new AA_JSON_Template_Template($this->GetId() . "_FileUpload_BottomLabel", array(
                "autoheight"=>true,
                "template" => "<span style='font-size: smaller; font-style:italic'>" . $props['bottomLabel'] . "</span>",
                "css" => array("background" => "transparent")
            )));
        }

        $this->curRow->AddCol($template);
    }

    //Aggiungi un campo data
    public function AddDateField($name = "", $label = "", $props = array(), $newRow = true)
    {
        $props['timepick'] = false;
        if ($props['format'] == "") $props['format'] = "%Y-%m-%d";
        $props['stringResult'] = true;
        return $this->AddField($name, $label, "datepicker", $props, $newRow);
    }

    //Aggiungi un generico oggetto
    public function AddGenericObject($obj, $newRow = true)
    {
        if ($obj instanceof AA_JSON_Template_Generic) {
            if ($newRow) {
                $unique=uniqid(time());
                $this->curRow = new AA_JSON_Template_Layout($this->GetId() . "_Layout_Row_".$unique);
                $this->layout->AddRow($this->curRow);
            }

            $this->curRow->AddCol($obj);
        }
    }
}
