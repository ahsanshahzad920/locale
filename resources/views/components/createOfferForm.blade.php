<div class="modal fade" id="createOffer" tabindex="-1" role="dialog" aria-labelledby="createOfferLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOfferLabel">Create Offer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('api/clientOffer/store/' . $project->id) }}"
                    onsubmit="event.preventDefault(); submitOfferForm()" id="offerForm" method="post">

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Price</label>
                            <input type="number" name="price" id="price" class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Currency</label>
                            <select name="currency" id="currency" class="form-control">
                                <option value="USD">USD</option>
                                <option value="PKR">PKR</option>
                                <option value="GBP">GBP</option>
                                <option value="EU">EU</option>
                            </select>
                        </div>


                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Time</label>
                            <input type="number" name="time" id="time" class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label for="">Duration</label>
                            <select name="time_unit" id="time_unit" class="form-control">
                                <option value="days">days</option>
                                <option value="hours">hours</option>
                            </select>
                        </div>


                    </div>

                    <div class="col-lg-6">
                        <button class="btn btn-primary btn-block">
                            Submit Offer
                        </button>
                    </div>



                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<script>

    
function sendOfferMessage(message) {
        if (message != '') {
            $.post("{{ url('api/message/send') }}", {
                    'project_id': '{{ $project->id }}',
                    'message': message,
                    'sender': '{{ Auth::id() }}',
                    'message_type': 'offer'
                },
                function(result) {   
                    console.log(result);
                    recieveMessage()


                })
        }
    }


    function submitOfferForm() {
        var data = $('#offerForm').serialize();
        $.post("{{ url('api/clientOffer/store/' . $project->id) }}", data, function(response) {
            console.log(response);
            var clientOfferData = response['clientOfferData'];

            var message =
                "<br><div class='bg-primary text-white p-1'><b>Acelocale has created an offer </b>" +
                "<br>" +
                "<table class='table' style='color:white !important'>" +
                "<tbody>" +
                "<tr>" +
                "<td>Price</td><td>" + clientOfferData['price'] + " " + clientOfferData['currency'] + "</td>" +
                "</tr>" +
                "<tr>" +
                "<td>Time required</td><td>" + clientOfferData['time'] + " " + clientOfferData['time_unit'] +
                "</td>" +
                "</tr>" +
                "</tbody>" +
                "</table>" +
                "</div>" 
              

            console.log(message);

            sendOfferMessage(message);
            alert("Offer is created and has been sent to the client")
            $("#createOffer").modal('hide');


        })

    }




</script>
