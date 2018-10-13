---------

# ELASTIC EMAIL MOD v1.7

[**By Dougiefresh**](http://www.simplemachines.org/community/index.php?action=profile;u=253913) -> [Link to Mod](http://custom.simplemachines.org/mods/index.php?mod=4153)

---------

## Introduction
Some webhost providers, such as GoDaddy, limit the number of emails that a website can send to some dreadfully low number, like 250 per day.  This is fine for extremely small forums, but can quickly be exhausted with even a small amount of email sending by the forum.

This mod adds code to allow the SMF forum to send email via the [ElasticEMail.com](http://www.elasticemail.com) REST API, which can support up to 150,000 (150 thousand) emails per month for free (roughly 5,000 per day, if the emails are spread evenly over a month).

If sending the email through the Elastic EMail server fails for some reason, then the email will take it's usual route through the SMF code to be sent.

## Mod Requirements
It should go without saying that you need to sign up for a [ElasticEMail.com](http://www.elasticemail.com) account.  There you will be able to get the username and API key that this mod requires.

You also must be able to modify your domain's DNS records in order to maximize the number of emails your forum can send.  If you fail to do so, you will be limited to 500 emails per day.  Further instructions can be found at the Elastic EMail's [Settings: Using Your Domain](https://elasticemail.com/support/user-interface/settings/your-domain/) page.

BE FOREWARNED: **I WILL NOT ASSIST WITH DOMAIN DNS RECORD CHANGES!!!**  You have been warned!  If you are (1) uncomfortable with, or (2) unable to make these changes, this mod is **NOT FOR YOU!**

## Admin Settings
There is a new section under **Admin** -> **Maintenance** -> **Mail** -> **Elastic EMail**.

## Translators

- Spanish: [Juan Carlos](https://www.simplemachines.org/community/index.php?action=profile;u=2767)
- Spanish Latin: [Rock Lee](https://www.simplemachines.org/community/index.php?action=profile;u=322597)

## Compatibility Notes
This mod was tested on SMF 2.0.13 and SMF 2.1 Beta 3, but should work on SMF 2.0 and up.  SMF 1.x is not and will not be supported.  

## Related Discussions

- [Add REST API](http://www.simplemachines.org/community/index.php?topic=512386)
- [Add REST API](http://www.simplemachines.org/community/index.php?topic=551178.0) (split from first topic)

## Changelog
The changelog can be viewed at [XPtsp.com](http://www.xptsp.com/board/free-modifications/elasticemail-for-smf/).

## License
Copyright (c) 2017 - 2018, Douglas Orend

All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
