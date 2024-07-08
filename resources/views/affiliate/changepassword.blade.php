
@foreach($loginData as $Data)

<div id="changePasswordAffiliate{{$Data->login_id}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel3">Change Password</h3>
           </div>
           <div class="modal-body">
           <form action="{{route('Affiliate.changePassword',$Data->login_id)}}" method='POST' class="form-horizontal">
                                
                                @csrf
                           
                            <div class="control-group">
                               <label class="control-label">Email ID</label>
                               <div class="controls">
                                   <input type='hidden' name='login_id' value="{{$Data->login_id}}">
                                   <input type="text" disabled='disabled' value="{{$Data->login_email}}" placeholder="Email" class="input-large" />
                                   <span class="help-inline"></span>
                               </div>
                           </div>
                           <div class="control-group">
                               <label class="control-label">New Password</label>
                               <div class="controls">
                                   <input type="password" name='password' placeholder="New Password" class="input-large" required/>
                                   <span class="help-inline"></span>
                               </div>
                           </div>
                           <div class="control-group">
                               <label class="control-label">Confirm Password</label>
                               <div class="controls">
                                   <input type="password" name='password_confirmation' placeholder="Confirm Password" class="input-large" required />
                                   <span class="help-inline"></span>
                               </div>
                           </div>           
           </div>
           <div class="modal-footer">
          
              
               <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
               <button type='submit'  class="btn btn-success">Change</button>
            </form>
           </div>
   </div>
@endforeach
