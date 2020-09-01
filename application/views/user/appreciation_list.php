<section class="latest mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12"><br>
                <h3 style="margin-bottom:0;background:none;color:black;font-size: 24px;">Appreciation List</h3><br>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                          <tr class="thead-dark">
                            <th>S.No.</th>
                            <th>Appreciation</th>
                              <th>Rating</th>
                               <th>Action</th>
                          
                          </tr>
                        </thead>
                        <tbody>
            <?php if(count($ap)>0){$i=1;
                  foreach($ap as $r){?>
                          <tr>
                            <td><?=$i;?></td>
                            <td><?=$r->feedback;?></td>
                              <td><?=$r->rating;?>&nbsp; Star</td>
                           <td>
                            <form method="post" action="<?=base_url();?>edit-appreciation" style="display:inline">
                              <input type="hidden" name="id" value="<?=$r->id;?>" />
                            <button type="submit" class="btn btn-info btn-sm" >Edit</button>
                          </form >
                          <form id="del" method="post" action="<?=base_url();?>delete-appreciation" style="display:inline;margin:5px;">
                              <input type="hidden" name="id" value="<?=$r->id;?>" />
            <button onclick="if(confirm('Are u sure want to delete?'))return true;" type="submit" class="btn btn-danger btn-sm" >Delete</button>
                          </form>




                           </td>
                           
                          </tr>
                      <?php $i++; } } else{?>
                         <tr>
                            <td colspan='3' >List is empty</td>
                        </tr>
                    <?php }?>
                        </tbody>
                </table>
                </div>
            </div>
            
        </div>
    </div>
</section>