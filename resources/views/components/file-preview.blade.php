<div class="modal fade" id="filePrev" tabindex="-1" role="dialog" aria-labelledby="filePrevLabel"
    data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filePrevLabel">Preview Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="filePrevBody">
                <form id="fileUploadForm" onsubmit="event.preventDefault();uploadFilesInChat(event)"
                    enctype="multipart/form-data" method="post">
                    <div id="filesAppendedPreview" class="row p-1"></div>

                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="sender" value="{{ Auth::id() }}">

                    @if(Auth::user()->role == "teamlead")
                    <label class="form-group form-check-inline" for="isSubmit">
                        <input type="checkbox" name="isSubmit" id="isSubmit">
                       <span class="ml-2"> Submit this file as project delivery?</span>
                    </label>
                    @endif
                    <div class="modal-footer col-12">
                        <button type="button" id="filePrevModalClose" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" id="fileUpload" class="btn btn-primary">Upload</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function chooseAndAppendFile(element) {
        console.log("file selected");
        filesPreview(element, '#filesAppendedPreview');
    }

    // Multiple images preview in browser
    function filesPreview(input, placeToInsertFilePreview) {
        $(placeToInsertFilePreview).html('');
        if (input.files) {

            var filesAmount = input.files.length;
            for (var f = 0; f < filesAmount; f++) {
                var reader = new FileReader();
                // reader.onload = function(event) {

                    $(placeToInsertFilePreview).append(
                        "<div class='col-3 card' id='filePrevDiv_" + f + "'>" +
                        "<div class='d-inline'>" +
                        "<span class='text-danger' style='cursor:pointer' onclick='event.currentTarget.parentNode.remove()'><i class='fa fa-times'></i></span>" +
                        "File #" + f + "</div>"

                        +
                        "<object style='width:100%' data='" + URL.createObjectURL(input.files[f]) +
                        "'></object>" +
                        "<input  id='fileElement_" + f + "' type='file' name='file" + f +
                        "'   class='d-none fileInput'></div> "
                    )

                    let list = new DataTransfer();
                    let file = input.files[f];
                    list.items.add(file);

                    let myFileList = list.files;

                    document.getElementById("fileElement_" + f).files = myFileList;

                    console.log("file index "+f)
                // }

                reader.readAsDataURL(input.files[f]);

            }
            $('#filePrev').modal('toggle');

        }

    };

    $('#selectedFiles').on('change', chooseAndAppendFile(this));




    //form Submit
    // $("#fileUploadForm").on('submit', uploadFilesInChat(e));
    function uploadFilesInChat(evt) {
        evt.preventDefault();
        console.log("file uploading ..... ");
        var fileInput = document.getElementsByClassName("fileInput");
        console.log("File count ",fileInput.length);
        for(var i=0;  i<fileInput.length; i++){
          console.log("File # ",i);

        var formData = new FormData();
        formData.append("project_id", "{{$project->id}}");
        formData.append("sender", "{{Auth::id()}}");
        if(document.getElementById("isSubmit").checked == true){
            formData.append("isSubmit", "true");

        }

        formData.append("file", fileInput[i].files[0]);

       $.ajax({
            url: '{{ url('message/uploadFiles/' . $project->id . '/' . Auth::id()) }}',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(response) {
                console.log(response);
                recieveMessage();
            }
        });
      }
      $('#filePrev').modal('toggle');
      $("#filesAppendedPreview").html('');

        return false;
    }
</script>
