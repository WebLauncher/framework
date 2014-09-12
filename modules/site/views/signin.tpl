        <div class="panel">
			<div class="top clearfix">
				<div class="left floatleft"></div>
			    <div class="title floatleft">{tr}DE CE ANGAJATORUL?{/tr}</div>
				<div class="right floatright"></div>
		    </div>
			<div class="content">
                <p>
                    {tr}companii Iti poti posta CV-ul pentru a putea fi gasit cu usurinta de companii<br/>
                    Poti aplica online la orice job<br/>
                    Companiile te vor contacta daca ai CV-ul public{/tr}
                </p>
		    </div>
			<div class="bottom">
				<div class="left floatleft"></div>
            	<div class="right floatright"></div>
		    </div>
        </div>
        <div class="margin_t_1 clearfix margin_b_1" style="width:100%;">
            <div class="panel floatleft" style="width:440px;">
    			<div class="top clearfix">
    				<div class="left floatleft"></div>
    			    <div class="title floatleft">{tr}Sunteti membru?{/tr}</div>
    				<div class="right floatright"></div>
    		    </div>
    			<div class="content clearfix" style="height:216px;">
                    <form id="login" name="login" action="" method="post" width="100%">
                    	<center>
            		    <table cellpadding="0" cellspacing="0" style="margin-top:50px;">
            			    <tr>
            					<td>
                                    <label for="_username_login">{tr}Utilizator{/tr}:</label>
								</td>
								<td width="150px;">
            						<input type="text" id="_username_login" hint="{tr}help_utilizator{/tr}" name="_username" id="user" class="input_text" value="{$p.state._username|default:$p.state._username|escape}" style="width:150px;" />
									<script>jQueryjQuery("#_username_login").focus();</script>
            					</td>
                           		{validator form="login" field="_username" rule="required" message="Completati utilizatorul!"}
								{validator form="login" field="_username" rule="username" message="Completati utilizatorul!"}
            				</tr>
            					<td>
            						<label for="_password_login">{tr}Parola{/tr}:</label>
								</td>
								<td>
                            		<input type="password"  hint="{tr}help_parola{/tr}" id="_password_login" name="_password" class="input_text value="{$p.state._password|default:$p.state._password|escape}"  style="width:150px;"/>
            					</td>	     
								{validator form="login" field="_password" rule="required" message="Completati parola!"}                       
            				</tr>
            				<tr>
            					<td colspan="2">
            						<input type="checkbox" name="_remmember" hint="{tr}signin_remmember{/tr}" id="_remmember"/> <label for="_remmember">{tr}pastreaza-ma logat{/tr}</label>
            					</td>
            				 </tr>
							 <tr>
							 	<td>
							 		<a href="{$root_module}recover">{tr}Ai uitat parola?{/tr}</a>
							 	</td>
								<td><button class="btn_grey floatright" type="submit"><span>{tr}Login{/tr}</span></button></td>
							 </tr>
                        </table>
						</center>
            				<input type="hidden" name="a" value="login" />
                            <input type="hidden" name="_type" value="companie" />
                            
            						
                           
                    </form>                   
    		    </div>
    			<div class="bottom">
    				<div class="left floatleft"></div>
                	<div class="right floatright"></div>
    		    </div>
            </div>
            <div class="panel floatleft margin_l_1" style="width:440px;">
    			<div class="top clearfix">
    				<div class="left floatleft"></div>
    			    <div class="title floatleft">{tr}Membru nou?{/tr}</div>
    				<div class="right floatright"></div>
    		    </div>
    			<div class="content clearfix"> 
                	<form id="add_user" name="add" action="{$root_module}cont" method="post">
                		<input type="hidden" name="a" value="register"/>
						<center>
        				<table cellpadding="4px" cellspacing="0">
            				<tr>
            					<td>
            					    <label for="email_add">{tr}Email:{/tr}*</label>
								</td>
								<td width="150px">
                                    <input type="text" id="email_add" hint="{tr}help_register_email{/tr}" name="email" value="{$p.state.email}" class="input_text" style="width:150px"/>
									{validator form="add_user" field="email" rule="required" message="Completati o adresa de e-mail!"}
									{validator form="add_user" field="email" rule="email" message="Completati o adresa de e-mail valida!"}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="user_add">{tr}Utilizator:{/tr}*</label>
								</td>
								<td>
                                    <input type="text" class="input_text" hint="{tr}help_utilizator{/tr}" id="user_add" name="user" value="{$p.state.user}" style="width:150px"/>
									{validator form="add_user" field="user" rule="required" message="Completati utilizatorul!"}
									{validator form="add_user" field="user" rule="username" message="Completati un utilizator valid!"}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password_add">{tr}Parola:{/tr}*</label>
								</td>
								<td>
                                    <input type="password" class="input_text" id="password_add" hint="{tr}help_parola{/tr}" name="password" value="{$p.state.password}" style="width:150px"/>
									{validator form="add_user" field="password" rule="required" message="Completati parola!"}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password2_add">{tr}Reintroduceti parola:{/tr}*</label>
								</td>
								<td>
                                    <input type="password" id="password2_add" hint="{tr}help_confirmare_parola{/tr}" name="password2" value="{$p.state.password2}" class="input_text" style="width:150px"/>
									{validator form="add_user" field="password2" rule="required" message="Confirmati parola!"}
									{validator form="add_user" field="password2" rule="compare|=|password" message="Confirmarea parolei nu este corecta!"}
                                </td>
                            </tr>
							<tr>
                                <td>
                                    <label for="signature"><img src="{$root_module}?a=signature"/></label>
								</td>
								<td>
                                    <input type="text" style="width:50px;" id="signature" hint="{tr}help_semnatura{/tr}" maxlength="5" name="signature" value="{$p.state.signature}" class="input_text"/>
									{validator form="add_user" field="signature" show="yes" rule="required" message="Completati textul de verificare!"}
                                </td>
                            </tr>
                            <tr>
                                <td>                                	
                                    <label for="agree">{tr}Sunt de acord cu {/tr}</label><a href="{$root_module}articles/conditii" target="_blank"> {tr}termenii si conditiile{/tr}</a>
                                </td>
								<td>
									<input type="checkbox" name="agree" hint="{tr}help_register_agree{/tr}" id="agree" {if $p.state.agree} checked="checked"{/if}/> 
									{validator form="add_user" field="agree" rule="required" message="Trebuie sa fi de acord cu termenii si conditiile Angajatorul.com!"}
								</td>
                            </tr>
							<tr>
								<td colspan="2">
									<button type="submit" class="btn_grey floatright"><span>{tr}Cont Nou{/tr}</span></button>
								</td>
							</tr>
        				</table>
						</center>
						
        			</form>                   
    		    </div>
    			<div class="bottom">
    				<div class="left floatleft"></div>
                	<div class="right floatright"></div>
    		    </div>
            </div>            
        </div>