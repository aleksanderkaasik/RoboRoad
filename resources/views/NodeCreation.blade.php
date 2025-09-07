<div>
   <label for="nodeName">Node name:</label>
   <input type="text" id="nodeName" placeholder="Type node name">
</div>

<div>
   <label for="nodeAddress">Node address:</label>
   <input type="text" id="nodeAddress" placeholder="Type node address">
</div>

</div>

<div>
   <p>git clone https://github.com/aleksanderkaasik/RoboRoad-Node.git</p>
   <p>sudo bash ./RoboRoad-Node/installation.sh {{ env('APP_Domain') }}  <span id="nodeNamePreview">NodeName</span> <span id="nodeAddressPreview">NodeAddress</span></p>
</div>

<script>
   const nodeName = document.getElementById('nodeName');
   const nodeAddress = document.getElementById('nodeAddress');
   const nodeNamePreview = document.getElementById('nodeNamePreview');
   const nodeAddressPreview = document.getElementById('nodeAddressPreview');

   function updatePreview() {
      nodeNamePreview.textContent = nodeName.value;
      nodeAddressPreview.textContent = nodeAddress.value;
   }

   nodeName.addEventListener('input', updatePreview);
   nodeAddress.addEventListener('input', updatePreview);
</script>