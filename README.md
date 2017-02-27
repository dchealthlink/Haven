# Haven

This is the developer repository for HAVEN, an PHP-based web
application that does eligibility determination for Medicaid. When [DC
Health Link](https://dchealthlink.com/) (running [Enroll
App](https://github.com/dchbx/enroll)) has a question about an
individual's [eligibility for
Medicaid](https://dchealthlink.com/individuals/medicaid), it calls to
HAVEN, which checks the [Medicaid Eligibility Engine in the Cloud
(MITC)](https://github.com/dchealthlink/MITC) and asks other federal
services about the individual, statefully awaiting their responses and
notifying the individual of the result.

HAVEN will replace the DC Health Benefit Exchange's usage of Cúram.