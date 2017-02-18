<form id="login" name="login" action="" method="post" width="100%">
    <table cellpadding="0" cellspacing="0" style="margin-top:50px;">
        <tr>
            <td>
                <label for="_username_login">{tr}Username{/tr}:</label>
            </td>
            <td width="150px;">
                <input type="text" id="_username_login" name="_username" id="user" class="input_text"
                       value="{$p.state._username|default:$p.state._username|escape}"
                       style="width:150px;"/>
                <script>jQuery("#_username_login").focus();</script>
            </td>
            {validator form="login" field="_username" rule="required" message="Completati utilizatorul!"}
            {validator form="login" field="_username" rule="username" message="Completati utilizatorul!"}
        </tr>
        <td>
            <label for="_password_login">{tr}Password{/tr}:</label>
        </td>
        <td>
            <input type="password" hint="{tr}help_parola{/tr}" id="_password_login" name="_password"
                   class="input_text value="{$p.state._password|default:$p.state._password|escape}"
            style="width:150px;"/>
        </td>
        {validator form="login" field="_password" rule="required" message="Completati parola!"}
        </tr>
        <tr>
            <td colspan="2">
                <input type="checkbox" name="_remmember" id="_remmember"/> <label
                        for="_remmember">{tr}keep me loged in{/tr}</label>
            </td>
        </tr>
    </table>
    </center>
    <input type="hidden" name="a" value="login"/>
    <input type="hidden" name="_type" value="user"/>
</form>
