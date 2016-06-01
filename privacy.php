<?
session_start();
include "inc/dbconnect.php";
include("inc/header_inc.php");
/*
if(!session_is_registered("ownerid"))
{
header("Location: index.htm");
exit;
}
*/
/* ============ end submit ============ */
/* Any queries that need to be performed
$sql="SELECT  FROM  ";

$result = pg_exec($db,$sql);
if(pg_ErrorMessage($db))
        {
        DisplayErrMsg(sprintf("Error in executing %s statement", $sql)) ;
        DisplayErrMsg(sprintf("Error: %s", pg_ErrorMessage($db))) ;
        };

$rownum = 0;
*/

?>
<FORM NAME="mainform" METHOD="post" ACTION="<?php $PHP_SELF ?>">

            <td width="10%">&nbsp;</td>
            <td width="76%" align="left" valign="top">
              <h1>Privacy Policy</h1>
              <p><strong>What This Privacy Policy Covers</strong> </p>
              <ul>
                <li>This policy covers how <?php echo (ucfirst($app_locality)) ?> treats personal information
                  that <?php echo (ucfirst($app_locality)) ?> collects and receives, including information related
                  to your past use of <?php echo (ucfirst($app_locality)) ?> products and services. Personal information
                  is information about you that is personally identifiable like
                  your name, address, email address, or phone number, and that
                  is not otherwise publicly available. <br>
                </li>
                <li>This policy does not apply to the practices of companies that
                  <?php echo (ucfirst($app_locality)) ?> does not own, control or to people that <?php echo (ucfirst($app_locality)) ?> does not
                  employ or manage. </li>
              </ul>
              <p><strong>Information Collection and Use</strong></p>
              <ul>
                <li><?php echo (ucfirst($app_locality)) ?> collects personal information when you register with
                  <?php echo (ucfirst($app_locality)) ?> when you use <?php echo (ucfirst($app_locality)) ?>&#8217;s products and services, when
                  you visit <?php echo (ucfirst($app_locality)) ?> pages or the pages of certain <?php echo (ucfirst($app_locality)) ?> partners.
                  <?php echo (ucfirst($app_locality)) ?> may combine information about you that we have with information
                  we obtain from business partners or other companies. </li>
                <li>When you register we ask for information such as your name,
                  email address, zip code, occupation, and industry. Once you
                  register with <?php echo (ucfirst($app_locality)) ?> and sign in to our services, you are not
                  anonymous to us. </li>
                <li><?php echo (ucfirst($app_locality)) ?> collects information about your transactions with us
                  and with some of our business partners. </li>
                <li><?php echo (ucfirst($app_locality)) ?> Collects information on your behavior on the site and
                  the use of the utilities <?php echo (ucfirst($app_locality)) ?> provides.</li>
                <li> <?php echo (ucfirst($app_locality)) ?> automatically receives and records information on
                  our server logs from your browser, including your IP Address,
                  <?php echo (ucfirst($app_locality)) ?> cookie information, and the page you request. </li>
              </ul>
              <p><strong>Children</strong></p>
              <ul>
                <li> Children under 13 years of age are not allowed to register
                  at <?php echo (ucfirst($app_locality)) ?></li>
                <li> <?php echo (ucfirst($app_locality)) ?> is not Liable for information falsely provided by
                  children less than 13 years of age. </li>
              </ul>
              <p><strong>Information Sharing and Disclosure </strong></p>
              <ul>
                <li> <?php echo (ucfirst($app_locality)) ?> does not rent, sell, or share personal information
                  about you with other people or nonaffiliated companies except
                  to provide products or services you've requested, when we have
                  your permission, or under the following circumstances: </li>
              </ul>
              <p><strong>Cookies</strong></p>
              <ul>
                <li><?php echo (ucfirst($app_locality)) ?> may set and access <?php echo (ucfirst($app_locality)) ?> cookies on your computer.</li>
                  <li>Other organizations, advertisers or other companies do not have access
                  to <?php echo (ucfirst($app_locality)) ?>&#8217;s cookies. </li>
              </ul>
              <p><strong>Your Ability to Edit and Delete Your Account Information
                and Preferences</strong> </p>
              <ul>
                <li>You can edit your <?php echo (ucfirst($app_locality)) ?> Account Information at any time.</li>
                <li>We reserve the right to send you certain communications relating
                  to the <?php echo (ucfirst($app_locality)) ?> service, such as service announcements or administrative
                  messages, that are considered part
                  of your <?php echo (ucfirst($app_locality)) ?> account, without offering you the opportunity
                  to opt-out of receiving them.</li>
                <li>You can delete your <?php echo (ucfirst($app_locality)) ?> account by visiting our Account
                  Deletion page. Some information might possibly remain in our
                  archived records after your account has been deleted. <br>
                </li>
              </ul>
              <p><strong>Confidentiality and Security </strong></p>
              <ul>
                <li>We limit access to personal information about you to employees
                  who we believe reasonably need to come into contact with that
                  information to provide services to you or in order
                  to do their jobs.</li>
                <li>We have physical, electronic, and procedural safeguards that
                  comply with federal regulations to protect personal information
                  about you. </li>
              </ul>
              <p><strong>Changes to this Privacy Policy</strong></p>
              <ul>
                <li> <?php echo (ucfirst($app_locality)) ?> may update this policy. We will notify you about significant
                  changes in the way we treat personal information by sending
                  a notice to the primary email address specified in your <?php echo (ucfirst($app_locality)) ?>
                  account or by placing a prominent notice on our site. </li>
              </ul></td>
            <td width="14%">&nbsp; </td>

<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>

<?
/*

echo "<tr><td>Whatever the stuff is going to be</td>";
echo "</tr>";

?>


<tr>
<td>
<INPUT TYPE=SUBMIT NAME=SUBMIT VALUE=SUBMIT></td><td>
<INPUT TYPE=RESET></td>
</tr></table>

<?
*/
echo "</tr>";
/* =========================== */
echo "<p>";
/*  include "inc/nav.inc"; */ 
include "inc/footer_inc.php";

?>
</table>
</form>
</body>
</HTML>


