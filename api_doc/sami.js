
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">[Global Namespace]</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:CreateUploadResourcesTable" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="CreateUploadResourcesTable.html">CreateUploadResourcesTable</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:ymlluo" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="ymlluo.html">ymlluo</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:ymlluo_Ueditor" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="ymlluo/Ueditor.html">Ueditor</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:ymlluo_Ueditor_Events" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="ymlluo/Ueditor/Events.html">Events</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:ymlluo_Ueditor_Events_FileUploaded" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="ymlluo/Ueditor/Events/FileUploaded.html">FileUploaded</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:ymlluo_Ueditor_Facades" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="ymlluo/Ueditor/Facades.html">Facades</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:ymlluo_Ueditor_Facades_Ueditor" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="ymlluo/Ueditor/Facades/Ueditor.html">Ueditor</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:ymlluo_Ueditor_Listeners" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="ymlluo/Ueditor/Listeners.html">Listeners</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:ymlluo_Ueditor_Listeners_UploadResourceSave" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="ymlluo/Ueditor/Listeners/UploadResourceSave.html">UploadResourceSave</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:ymlluo_Ueditor_Middleware" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="ymlluo/Ueditor/Middleware.html">Middleware</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:ymlluo_Ueditor_Middleware_EditorCrossRequest" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="ymlluo/Ueditor/Middleware/EditorCrossRequest.html">EditorCrossRequest</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:ymlluo_Ueditor_Models" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="ymlluo/Ueditor/Models.html">Models</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:ymlluo_Ueditor_Models_UploadResource" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="ymlluo/Ueditor/Models/UploadResource.html">UploadResource</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:ymlluo_Ueditor_ServiceController" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="ymlluo/Ueditor/ServiceController.html">ServiceController</a>                    </div>                </li>                            <li data-name="class:ymlluo_Ueditor_Ueditor" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="ymlluo/Ueditor/Ueditor.html">Ueditor</a>                    </div>                </li>                            <li data-name="class:ymlluo_Ueditor_UeditorServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="ymlluo/Ueditor/UeditorServiceProvider.html">UeditorServiceProvider</a>                    </div>                </li>                            <li data-name="class:ymlluo_Ueditor_UploaderTrait" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="ymlluo/Ueditor/UploaderTrait.html">UploaderTrait</a>                    </div>                </li>                            <li data-name="class:ymlluo_Ueditor_UrlGenerateTrait" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="ymlluo/Ueditor/UrlGenerateTrait.html">UrlGenerateTrait</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": ".html", "name": "", "doc": "Namespace "},{"type": "Namespace", "link": "ymlluo.html", "name": "ymlluo", "doc": "Namespace ymlluo"},{"type": "Namespace", "link": "ymlluo/Ueditor.html", "name": "ymlluo\\Ueditor", "doc": "Namespace ymlluo\\Ueditor"},{"type": "Namespace", "link": "ymlluo/Ueditor/Events.html", "name": "ymlluo\\Ueditor\\Events", "doc": "Namespace ymlluo\\Ueditor\\Events"},{"type": "Namespace", "link": "ymlluo/Ueditor/Facades.html", "name": "ymlluo\\Ueditor\\Facades", "doc": "Namespace ymlluo\\Ueditor\\Facades"},{"type": "Namespace", "link": "ymlluo/Ueditor/Listeners.html", "name": "ymlluo\\Ueditor\\Listeners", "doc": "Namespace ymlluo\\Ueditor\\Listeners"},{"type": "Namespace", "link": "ymlluo/Ueditor/Middleware.html", "name": "ymlluo\\Ueditor\\Middleware", "doc": "Namespace ymlluo\\Ueditor\\Middleware"},{"type": "Namespace", "link": "ymlluo/Ueditor/Models.html", "name": "ymlluo\\Ueditor\\Models", "doc": "Namespace ymlluo\\Ueditor\\Models"},
            
            {"type": "Class",  "link": "CreateUploadResourcesTable.html", "name": "CreateUploadResourcesTable", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "CreateUploadResourcesTable", "fromLink": "CreateUploadResourcesTable.html", "link": "CreateUploadResourcesTable.html#method_up", "name": "CreateUploadResourcesTable::up", "doc": "&quot;Run the migrations.&quot;"},
                    {"type": "Method", "fromName": "CreateUploadResourcesTable", "fromLink": "CreateUploadResourcesTable.html", "link": "CreateUploadResourcesTable.html#method_down", "name": "CreateUploadResourcesTable::down", "doc": "&quot;Reverse the migrations.&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor\\Events", "fromLink": "ymlluo/Ueditor/Events.html", "link": "ymlluo/Ueditor/Events/FileUploaded.html", "name": "ymlluo\\Ueditor\\Events\\FileUploaded", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\Events\\FileUploaded", "fromLink": "ymlluo/Ueditor/Events/FileUploaded.html", "link": "ymlluo/Ueditor/Events/FileUploaded.html#method___construct", "name": "ymlluo\\Ueditor\\Events\\FileUploaded::__construct", "doc": "&quot;Create a new event instance.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Events\\FileUploaded", "fromLink": "ymlluo/Ueditor/Events/FileUploaded.html", "link": "ymlluo/Ueditor/Events/FileUploaded.html#method_broadcastOn", "name": "ymlluo\\Ueditor\\Events\\FileUploaded::broadcastOn", "doc": "&quot;Get the channels the event should broadcast on.&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor\\Facades", "fromLink": "ymlluo/Ueditor/Facades.html", "link": "ymlluo/Ueditor/Facades/Ueditor.html", "name": "ymlluo\\Ueditor\\Facades\\Ueditor", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\Facades\\Ueditor", "fromLink": "ymlluo/Ueditor/Facades/Ueditor.html", "link": "ymlluo/Ueditor/Facades/Ueditor.html#method_getFacadeAccessor", "name": "ymlluo\\Ueditor\\Facades\\Ueditor::getFacadeAccessor", "doc": "&quot;Get the registered name of the component.&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor\\Listeners", "fromLink": "ymlluo/Ueditor/Listeners.html", "link": "ymlluo/Ueditor/Listeners/UploadResourceSave.html", "name": "ymlluo\\Ueditor\\Listeners\\UploadResourceSave", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\Listeners\\UploadResourceSave", "fromLink": "ymlluo/Ueditor/Listeners/UploadResourceSave.html", "link": "ymlluo/Ueditor/Listeners/UploadResourceSave.html#method___construct", "name": "ymlluo\\Ueditor\\Listeners\\UploadResourceSave::__construct", "doc": "&quot;Create the event listener.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Listeners\\UploadResourceSave", "fromLink": "ymlluo/Ueditor/Listeners/UploadResourceSave.html", "link": "ymlluo/Ueditor/Listeners/UploadResourceSave.html#method_handle", "name": "ymlluo\\Ueditor\\Listeners\\UploadResourceSave::handle", "doc": "&quot;Handle the event.&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor\\Middleware", "fromLink": "ymlluo/Ueditor/Middleware.html", "link": "ymlluo/Ueditor/Middleware/EditorCrossRequest.html", "name": "ymlluo\\Ueditor\\Middleware\\EditorCrossRequest", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\Middleware\\EditorCrossRequest", "fromLink": "ymlluo/Ueditor/Middleware/EditorCrossRequest.html", "link": "ymlluo/Ueditor/Middleware/EditorCrossRequest.html#method_handle", "name": "ymlluo\\Ueditor\\Middleware\\EditorCrossRequest::handle", "doc": "&quot;Handle an incoming request.&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor\\Models", "fromLink": "ymlluo/Ueditor/Models.html", "link": "ymlluo/Ueditor/Models/UploadResource.html", "name": "ymlluo\\Ueditor\\Models\\UploadResource", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method___construct", "name": "ymlluo\\Ueditor\\Models\\UploadResource::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method_store", "name": "ymlluo\\Ueditor\\Models\\UploadResource::store", "doc": "&quot;\u4fdd\u5b58\u6587\u4ef6\u4fe1\u606f&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method_getTypeByMimeType", "name": "ymlluo\\Ueditor\\Models\\UploadResource::getTypeByMimeType", "doc": "&quot;get type by mime type&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method_getHistory", "name": "ymlluo\\Ueditor\\Models\\UploadResource::getHistory", "doc": "&quot;get history record by file sha1&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method_getImages", "name": "ymlluo\\Ueditor\\Models\\UploadResource::getImages", "doc": "&quot;get images list&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method_getFiles", "name": "ymlluo\\Ueditor\\Models\\UploadResource::getFiles", "doc": "&quot;get all files list&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method_deleteRecords", "name": "ymlluo\\Ueditor\\Models\\UploadResource::deleteRecords", "doc": "&quot;delete record by path&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Models\\UploadResource", "fromLink": "ymlluo/Ueditor/Models/UploadResource.html", "link": "ymlluo/Ueditor/Models/UploadResource.html#method_updateUrl", "name": "ymlluo\\Ueditor\\Models\\UploadResource::updateUrl", "doc": "&quot;update resource url by file full path&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor", "fromLink": "ymlluo/Ueditor.html", "link": "ymlluo/Ueditor/ServiceController.html", "name": "ymlluo\\Ueditor\\ServiceController", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\ServiceController", "fromLink": "ymlluo/Ueditor/ServiceController.html", "link": "ymlluo/Ueditor/ServiceController.html#method_serve", "name": "ymlluo\\Ueditor\\ServiceController::serve", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor", "fromLink": "ymlluo/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html", "name": "ymlluo\\Ueditor\\Ueditor", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method___construct", "name": "ymlluo\\Ueditor\\Ueditor::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_upload", "name": "ymlluo\\Ueditor\\Ueditor::upload", "doc": "&quot;file upload&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_listImages", "name": "ymlluo\\Ueditor\\Ueditor::listImages", "doc": "&quot;show images list&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_listFiles", "name": "ymlluo\\Ueditor\\Ueditor::listFiles", "doc": "&quot;show files list&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_getNameByAction", "name": "ymlluo\\Ueditor\\Ueditor::getNameByAction", "doc": "&quot;get config ActionName&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_deleteFile", "name": "ymlluo\\Ueditor\\Ueditor::deleteFile", "doc": "&quot;delete file by path&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_setVisibilityUrl", "name": "ymlluo\\Ueditor\\Ueditor::setVisibilityUrl", "doc": "&quot;set file visibility url&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_isResourceEnable", "name": "ymlluo\\Ueditor\\Ueditor::isResourceEnable", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_filePaginate", "name": "ymlluo\\Ueditor\\Ueditor::filePaginate", "doc": "&quot;get files pagination&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_getFiles", "name": "ymlluo\\Ueditor\\Ueditor::getFiles", "doc": "&quot;get files from storage&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_fail", "name": "ymlluo\\Ueditor\\Ueditor::fail", "doc": "&quot;fail response&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_isSignUrl", "name": "ymlluo\\Ueditor\\Ueditor::isSignUrl", "doc": "&quot;Check if the url requires a signature&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_getDiskConfig", "name": "ymlluo\\Ueditor\\Ueditor::getDiskConfig", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_getExpire", "name": "ymlluo\\Ueditor\\Ueditor::getExpire", "doc": "&quot;get sign url expire seconds ,if set to 0  that means it&#039;s forever (100 yeas)&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_getConfigByActionName", "name": "ymlluo\\Ueditor\\Ueditor::getConfigByActionName", "doc": "&quot;get config by actionName&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_formatConfigByPrefix", "name": "ymlluo\\Ueditor\\Ueditor::formatConfigByPrefix", "doc": "&quot;get config by request prefix&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_formatPath", "name": "ymlluo\\Ueditor\\Ueditor::formatPath", "doc": "&quot;generate real path&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_formatFilename", "name": "ymlluo\\Ueditor\\Ueditor::formatFilename", "doc": "&quot;generate format filename from config&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\Ueditor", "fromLink": "ymlluo/Ueditor/Ueditor.html", "link": "ymlluo/Ueditor/Ueditor.html#method_createPng", "name": "ymlluo\\Ueditor\\Ueditor::createPng", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "ymlluo\\Ueditor", "fromLink": "ymlluo/Ueditor.html", "link": "ymlluo/Ueditor/UeditorServiceProvider.html", "name": "ymlluo\\Ueditor\\UeditorServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\UeditorServiceProvider", "fromLink": "ymlluo/Ueditor/UeditorServiceProvider.html", "link": "ymlluo/Ueditor/UeditorServiceProvider.html#method_boot", "name": "ymlluo\\Ueditor\\UeditorServiceProvider::boot", "doc": "&quot;Perform post-registration booting of services.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UeditorServiceProvider", "fromLink": "ymlluo/Ueditor/UeditorServiceProvider.html", "link": "ymlluo/Ueditor/UeditorServiceProvider.html#method_register", "name": "ymlluo\\Ueditor\\UeditorServiceProvider::register", "doc": "&quot;Register any package services.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UeditorServiceProvider", "fromLink": "ymlluo/Ueditor/UeditorServiceProvider.html", "link": "ymlluo/Ueditor/UeditorServiceProvider.html#method_provides", "name": "ymlluo\\Ueditor\\UeditorServiceProvider::provides", "doc": "&quot;Get the services provided by the provider.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UeditorServiceProvider", "fromLink": "ymlluo/Ueditor/UeditorServiceProvider.html", "link": "ymlluo/Ueditor/UeditorServiceProvider.html#method_bootForConsole", "name": "ymlluo\\Ueditor\\UeditorServiceProvider::bootForConsole", "doc": "&quot;Console-specific booting.&quot;"},
            
            {"type": "Trait", "fromName": "ymlluo\\Ueditor", "fromLink": "ymlluo/Ueditor.html", "link": "ymlluo/Ueditor/UploaderTrait.html", "name": "ymlluo\\Ueditor\\UploaderTrait", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\UploaderTrait", "fromLink": "ymlluo/Ueditor/UploaderTrait.html", "link": "ymlluo/Ueditor/UploaderTrait.html#method_uploader", "name": "ymlluo\\Ueditor\\UploaderTrait::uploader", "doc": "&quot;upload file&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UploaderTrait", "fromLink": "ymlluo/Ueditor/UploaderTrait.html", "link": "ymlluo/Ueditor/UploaderTrait.html#method_uploadMultiAws", "name": "ymlluo\\Ueditor\\UploaderTrait::uploadMultiAws", "doc": "&quot;upload file to AWS S3 use multipart&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UploaderTrait", "fromLink": "ymlluo/Ueditor/UploaderTrait.html", "link": "ymlluo/Ueditor/UploaderTrait.html#method_uploadMultiOss", "name": "ymlluo\\Ueditor\\UploaderTrait::uploadMultiOss", "doc": "&quot;upload file to Aliyun OSS use multipart&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UploaderTrait", "fromLink": "ymlluo/Ueditor/UploaderTrait.html", "link": "ymlluo/Ueditor/UploaderTrait.html#method_uploadMultiCos", "name": "ymlluo\\Ueditor\\UploaderTrait::uploadMultiCos", "doc": "&quot;upload file to Tencent COS use multipart&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UploaderTrait", "fromLink": "ymlluo/Ueditor/UploaderTrait.html", "link": "ymlluo/Ueditor/UploaderTrait.html#method_getAcl", "name": "ymlluo\\Ueditor\\UploaderTrait::getAcl", "doc": "&quot;&quot;"},
            
            {"type": "Trait", "fromName": "ymlluo\\Ueditor", "fromLink": "ymlluo/Ueditor.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html", "name": "ymlluo\\Ueditor\\UrlGenerateTrait", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_url", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::url", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_publicUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::publicUrl", "doc": "&quot;Get the URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_temporaryUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::temporaryUrl", "doc": "&quot;Get a temporary URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_getAwsTemporaryUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::getAwsTemporaryUrl", "doc": "&quot;Get a temporary URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_getOssTemporaryUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::getOssTemporaryUrl", "doc": "&quot;Get a Aliyun OSS temporary URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_getCosTemporaryUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::getCosTemporaryUrl", "doc": "&quot;Get a Tencent Cloud COS temporary URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_getQiNiuTemporaryUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::getQiNiuTemporaryUrl", "doc": "&quot;Get a QiNiu KODO temporary URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_getLocalUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::getLocalUrl", "doc": "&quot;Get the URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_getAwsUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::getAwsUrl", "doc": "&quot;Get the URL for the file at the given path.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_concatPathToUrl", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::concatPathToUrl", "doc": "&quot;Concatenate a path to a URL.&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_replaceOrigin", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::replaceOrigin", "doc": "&quot;replace url by origin&quot;"},
                    {"type": "Method", "fromName": "ymlluo\\Ueditor\\UrlGenerateTrait", "fromLink": "ymlluo/Ueditor/UrlGenerateTrait.html", "link": "ymlluo/Ueditor/UrlGenerateTrait.html#method_expireSeconds", "name": "ymlluo\\Ueditor\\UrlGenerateTrait::expireSeconds", "doc": "&quot;get expire second&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


