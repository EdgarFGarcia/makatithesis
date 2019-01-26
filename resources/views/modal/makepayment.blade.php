<div class="modal" id="userpayment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Payment Information</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <label for="pid">ID</label>
        <input type="text" id="pid" class="form-control" disabled="disabled">

        <label for="amount">Amount</label>
        <input type="text" id="amount" class="form-control" disabled="disabled">

        <label for="modeofpayment">Mode Of Payment</label>
        <input type="text" id="modeofpayment" class="form-control">

        <label for="settled">Is Paid</label>
        <input type="text" id="settled" class="form-control" disabled="disabled">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="payment">Make Payment</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>