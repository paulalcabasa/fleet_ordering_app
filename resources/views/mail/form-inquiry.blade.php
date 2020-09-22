<!DOCTYPE html>
<html lang="en">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  	<body>
        
        <div class=" col-lg-6 offset-lg-3" style="margin-top:2em;">
            <div class="card ">
                <h5 class="card-header  bg-primary text-center text-light text-bold">Fleet Registration (FPC) - Inquiry</h5>
                <div class="card-body">
                    <form method="POST" action="<?php echo $inquiry_api; ?>">
                        <input type="hidden" name="approval_id" value="<?php echo $approval_id;?>" />
                        <div class="form-group">
                            <label>What would you like to know ?</label>
                            <textarea name="remarks" required  cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   
    </body>
</html>

