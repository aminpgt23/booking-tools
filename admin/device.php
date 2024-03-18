
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        tr, th{
            /* border: 1px solid #ddd; */
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #483D8B;
            color: white;
            overflow:hidden;
            
        }
        tr{
          border: 1px solid #ddd;
          border-collapse: collapse;
        }
    </style>

<div class="row mt-5">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="float-right" >
                      <form>
                        <div class="input-group" id="linkContainer">
                            <a href="template.php?page=tambah" class="btn btn-outline-warning"><img src="./template2/dist/img/plus.png" alt="logo" style="width:30px; height:30px; border-radius:10px;"></a>
                        </div>
                      </form>
                    </div>
                    <h4>Data Device</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-acara">
                        <thead>
                          <th class="text-center">NO</th>
                          <th>Type Device</th>
                          <th>Type Brand</th>
                          <th>Nama Device</th>
                          <th>Jumlah Device</th>
                          <th>Action</th>                      
                        </thead>
                        <tbody id="tableDevice"></tbody>                 
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>