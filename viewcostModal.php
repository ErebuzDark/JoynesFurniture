<style type="text/css">
    .navbar-expand-lg {
        margin-bottom: 70px;
    }

    .errors {
        background: #F2DEDE;
        color: #A94442;
        padding: 10px;
        border-radius: 5px;
    }

    .btns {
        background-color: #e47011;
        color: white;
        font-weight: 700;
        margin: 2px;
    }

    .btns:hover {
        opacity: 0.8;
        border: 1px solid;
        background-color: white;
        color: black;

    }

    .link:hover {
        color: blue !important;

    }
</style>


<div class="modal fade" id="costModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content rounded-0 border-0">

            <div class="container modal-body">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <button type="button" class="btn-close position-absolute" style="top: 10px; right: 10px;"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="d-none">
                                <p>Selected fID: <?php echo $id; ?></p>
                                <p>Selected pID: <span id="selectedPID"></span></p>
                                <p>Selected ID: <span id="selectedID"></span></p>
                                <!-- <p>Width: <span id="selectedWidth"></span></p> -->
                                <!-- <p>Length: <span id="selectedLength"></span></p> -->
                            </div>
                            <h4 class="text-center"><?php echo $row['fName']; ?></h4>
                            <div class="d-flex justify-content-center">
                                <img src="./up/<?php echo $row['image']; ?>" class="img-fluid rounded w-50 border"
                                    alt="Image">
                            </div>
                            <h6>Total Cost</h6>
                            <div class="d-flex justify-content-between px-5">
                                <p>Quantity: </p>
                                <p id="selectedQuantity"></p>
                            </div>
                            <div class="d-flex justify-content-between px-5">
                                <p>Length:</p>
                                <p><span id="selectedLength"></span>ft X ₱450</p> 
                            </div>
                            <div class="d-flex justify-content-between px-5">
                                <p>Width:</p>
                                <p><span id="selectedWidth"></span>ft X ₱450</p> 
                            </div>
                            <div class="d-flex justify-content-between px-5">
                                <p>Height:</p>
                                <p><span id="selectedHeight"></span>ft X ₱450</p> 
                            </div>
                            <div class="d-flex justify-content-between px-5">
                                <p>Wood: <span id="woodName"></span></p>
                                <p>₱<span id="woodCost"></span></p> 
                            </div>
                            <div class="d-flex justify-content-between px-5">
                                <p>Varnish: <span id="vName"></span></p>
                                <p> ₱<span id="varnishCost"></span></p>
                            </div>
                            <div class="d-flex justify-content-between px-5">
                                <p>Labor Fee:</p>
                                <p>₱<span id="laborFee">0</span></p>
                            </div>
                            <div class="d-flex justify-content-between px-5 fw-bold border-top">
                                <p class="fs-5">Total:</p>
                                <p class="fs-5">&#8369; <span id="totalCost"></span></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>