[{$smarty.block.parent}]

<tr>
    <td class="edittext">
        [{oxmultilang ident="FP_OXIDVIDEOS_ACTIONS_MAIN_VIDEO"}]
    </td>
    <td class="edittext">
        <input id="oxthumb" type="text" class="editinput" size="42" maxlength="[{$edit->oxactions__fpoxidvideos_video->fldmax_length}]" name="editval[oxactions__fpoxidvideos_video]" value="[{$edit->oxactions__fpoxidvideos_video->value}]">
        [{oxinputhelp ident="FP_OXIDVIDEOS_HELP_ACTIONS_MAIN_VIDEO"}]
        [{if (!($edit->oxactions__fpoxidvideos_video->value=="nopic.jpg" || $edit->oxactions__fpoxidvideos_video->value=="" || $edit->oxactions__fpoxidvideos_video->value=="nopic_ico.jpg"))}]
    </td>
    <td class="edittext">
        <a href="Javascript:DeletePic('fpoxidvideos_video');" class="delete left" [{include file="help.tpl" helpid=item_delete}]></a>
        [{/if}]
    </td>
</tr>

<tr>
    <td class="edittext">
        [{oxmultilang ident="FP_OXIDVIDEOS_ACTIONS_MAIN_VIDEOUPLOAD"}] ([{oxmultilang ident="GENERAL_MAX_FILE_UPLOAD"}] [{$sMaxFormattedFileSize}])
    </td>
    <td class="edittext" colspan="2">
        <input class="editinput" name="myfile[FPOXIDVIDEOS@oxactions__fpoxidvideos_video]" type="file"  size="26" [{$readonly}]>
    </td>
</tr>