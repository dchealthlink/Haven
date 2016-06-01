<?php

class AddressListType{
var $address;//AddressType
}
class alias_ids{
var $alias_id;//alias_id
}
class alias_id{
var $id;//anyURI
var $is_authoritative;//boolean
}
class approvals{
var $approval;//ApprovalType
}
class comments{
var $comment;//CommentType
}
class contacts{
var $contact;//ContactType
}
class emails{
var $email;//EmailType
}
class phones{
var $phone;//PhoneType
}
class rates{
var $rate;//RateType
}
class AddressType{
var $type;//AddressKindType
var $address_line_1;//string
var $address_line_2;//string
var $address_line_3;//string
var $location_city_name;//string
var $location_state;//UsStateNameType
var $location_state_code;//LocationStateCodeType
var $postal_code;//integer
var $location_postal_extension_code;//integer
var $location_country_name;//string
var $location_country_code;//anyURI
var $address_full_text;//string
var $location;//LocationNameType
}
class ApprovalType{
var $status;//status
var $determined_by;//anyURI
var $determination_date;//dateTime
var $notes;//string
}
class CommentType{
var $content;//string
var $author;//string
var $date;//SimpleDateType
var $is_priority;//boolean
}
class ContactType{
var $id;//IdentifierType
var $person_name;//PersonNameType
var $job_title;//string
var $department;//string
var $addresses;//AddressListType
var $emails;//emails
var $phones;//phones
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class CurrencyAmountPerAnnumType{
var $calendar_year;//CalendarYearType
var $total_amount;//CurrencyType
}
class DateRangeType{
var $begin_date;//SimpleDateType
var $end_date;//SimpleDateType
var $number_of_days;//integer
}
class EmailType{
var $type;//type
var $email_address;//string
}
class IdentifierBaseType{
var $hbx_id;//HbxCmsNameType
var $id;//anyURI
var $is_authoritative;//boolean
var $alias_ids;//alias_ids
}
class IdentifierFullyQualifiedType{
var $hbx_id;//HbxCmsNameType
var $id;//anyURI
var $is_authoritative;//boolean
}
class IdentifierSimpleType{
var $id;//anyURI
}
class IdentifierType{
var $id;//anyURI
var $is_authoritative;//boolean
var $alias_ids;//alias_ids
}
class LocationNameType{
var $rating_area;//rating_area
var $coordinates;//PositionPointType
var $census_tract;//string
var $county;//string
}
class PersonLinkType{
var $id;//IdentifierType
var $person_name;//person_name
}
class person_name{
var $person_surname;//string
var $person_given_name;//string
}
class PersonNameType{
var $person_surname;//string
var $person_given_name;//string
var $person_middle_name;//string
var $person_full_name;//string
var $person_name_prefix_text;//string
var $person_name_suffix_text;//string
var $person_alternate_name;//string
}
class PersonType{
var $id;//IdentifierType
var $person_name;//PersonNameType
var $job_title;//string
var $department;//string
var $addresses;//AddressListType
var $emails;//emails
var $phones;//phones
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class PhoneType{
var $type;//type
var $country_code;//anyType
var $area_code;//anyType
var $phone_number;//TelephoneNumberType
var $full_phone_number;//anyType
var $extension;//string
var $is_preferred;//boolean
}
class PositionPointType{
var $x;//float
var $y;//float
var $z;//float
var $coordinate_system_reference;//anyURI
}
class RateType{
var $age;//anyType
var $effective_date;//SimpleDateType
var $expire_date;//SimpleDateType
var $rate;//CurrencyType
var $rating_area;//anyType
var $tobacco_use;//anyType
}
class ServiceBodyType{
var $any;//<anyXML>
}
class ServiceEndPointType{
var $name;//string
var $version;//string
var $description;//string
var $urn;//anyURI
var $uri;//anyURI
}
class ServiceErrorType{
}
class ServiceEventType{
var $event_name;//anyURI
var $qualifying_reason;//anyType
var $resource_instance_uri;//IdentifierSimpleType
var $extended_resource_instance_uri;//anyURI
var $body;//ServiceBodyType
}
class ServiceHeaderType{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $authorization;//string
var $status;//ServiceStatusType
var $message_id;//string
var $originating_service;//anyURI
var $reply_to;//anyURI
var $fault_to;//anyURI
var $correlation_id;//string
var $application_header_properties;//application_header_properties
}
class application_header_properties{
var $any;//<anyXML>
}
class ServiceMetadataType{
var $result_set;//ServiceResultSetType
var $any;//<anyXML>
}
class ServiceStatusType{
var $return_status;//return_status
var $error_code;//string
var $developer_message;//string
var $user_message;//string
var $more_information;//anyURI
}
class ServiceRequestType{
var $request_name;//anyURI
var $parameters;//anyType
var $metadata;//ServiceMetadataType
var $body;//anyType
}
class ServiceResponseType{
var $header;//ServiceHeaderType
var $metadata;//ServiceMetadataType
var $body;//anyType
}
class ServiceResultSetType{
var $count;//integer
var $limit;//integer
var $offset;//integer
}
class SimpleDateRangeType{
var $start;//SimpleDateType
var $end;//SimpleDateType
}
class TpaType{
var $tpa_name;//string
var $tpa_fein;//FederalTaxIdType
}
class enrollees{
var $enrollee;//IdentifierSimpleType
}
class BrokerLinkType{
var $id;//IdentifierType
var $name;//string
var $dba;//string
var $display_name;//string
var $website;//anyURI
var $tpa;//TpaType
var $is_active;//boolean
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class CarrierLinkType{
var $id;//IdentifierType
var $name;//string
var $display_name;//string
var $is_active;//boolean
}
class EmployerLinkType{
var $id;//IdentifierType
var $name;//string
var $dba;//anyType
}
class EnrolleeBenefitType{
var $premium_amount;//CurrencyType
var $begin_date;//SimpleDateType
var $end_date;//SimpleDateType
var $carrier_assigned_policy_id;//string
var $carrier_assigned_enrollee_id;//string
var $coverage_level;//CoverageLevelNameType
}
class EnrolleeLinkType{
var $individual;//IndividualLinkType
var $employment_status;//EmploymentStatusNameType
var $is_physically_disabled;//boolean
var $benefit;//EnrolleeBenefitType
}
class IndividualLinkType{
var $id;//IdentifierType
var $person;//PersonType
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class PlanLinkType{
var $id;//IdentifierType
var $coverage_type;//QhpBenefitCoverageNameType
var $carrier;//CarrierLinkType
var $plan_year;//plan_year
var $name;//string
var $is_dental_only;//boolean
}
class PolicyLinkType{
var $id;//IdentifierType
var $enrollees;//enrollees
var $plan;//PlanLinkType
var $market;//AcaMarketPlaceNameType
var $coverage_period;//DateRangeType
var $policy_state;//PolicyStateNameType
var $is_active;//boolean
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class coverages{
var $coverage;//CoverageType
}
class deductables{
var $deductables;//DeductableType
}
class maximums{
var $maximum;//MaximumType
}
class plan{
}
class PlanBaseType{
var $id;//IdentifierType
var $name;//string
var $is_dental_only;//boolean
var $carrier;//CarrierLinkType
var $market;//AcaMarketPlaceNameType
var $metal_level;//PlanMetalLevelNameType
var $coverage_type;//QhpBenefitCoverageNameType
var $rates;//rates
var $ehb_percent;//anyType
var $coverages;//coverages
var $cost_structure;//CostStructureType
var $maximums;//maximums
var $deductables;//deductables
var $metadata;//string
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class PlanType{
var $id;//IdentifierType
var $name;//string
var $is_dental_only;//boolean
var $carrier;//CarrierLinkType
var $market;//AcaMarketPlaceNameType
var $metal_level;//PlanMetalLevelNameType
var $coverage_type;//QhpBenefitCoverageNameType
var $rates;//rates
var $ehb_percent;//anyType
var $coverages;//coverages
var $cost_structure;//CostStructureType
var $maximums;//maximums
var $deductables;//deductables
var $metadata;//string
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class CostStructureType{
var $first_tier_utilization;//int
var $issuer_actuarial_value;//float
var $multiple_in_network_tiers;//boolean
var $sbc_scenario;//sbc_scenario
var $custom_scenarios;//custom_scenarios
}
class sbc_scenario{
var $having_diabetes;//anyType
var $having_a_baby;//anyType
}
class custom_scenarios{
var $name;//name
}
class name{
var $networks;//CostByNetworkType
}
class CoverageType{
var $name;//name
}
class name{
var $is_covered;//boolean
var $ehb_variance_reason;//string
var $excluded_from_in_network_moop;//boolean
var $excluded_from_out_of_network_moop;//boolean
var $exclusions;//string
var $quantitative_limit;//boolean
var $subject_to_deductable_t1;//boolean
var $subject_to_deductable_t2;//boolean
var $costs;//CoverageCostType
}
class DeductableType{
var $name;//anyType
var $networks;//CostByNetworkType
}
class MaximumType{
var $name;//string
var $networks;//CostByNetworkType
}
class PlanMetadataType{
var $brochure_url;//anyURI
var $child_only_offering;//string
var $disease_management_program_offered;//string
var $formulary_id;//string
var $hios_plan_id;//string
var $hsa_eligible;//boolean
var $limited_cost_sharing_plan_variation_est_adv_payment;//int
var $metalic_level;//metalic_level
var $national_network;//boolean
var $network_id;//string
var $new_or_existing_plan;//new_or_existing_plan
var $notice_required_for_pregnancy;//boolean
var $out_of_country_coverage;//boolean
var $out_of_service_area_coverage;//boolean
var $out_of_service_area_description;//string
var $plan_effective_date;//SimpleDateType
var $plan_type;//string
var $qhp;//string
var $referral_required_for_specialist;//boolean
var $sbc_url;//anyURI
var $service_area_Id;//string
var $unique_plan_design;//boolean
var $wellness_program_offered;//boolean
}
class CoverageCostType{
var $coinsurance;//CostByNetworkType
var $copay;//CostByNetworkType
}
class CostByNetworkType{
var $in_network_tier;//MaxCostByCoverageCategoryType
var $out_of_network;//MaxCostByCoverageCategoryType
var $in_network_tier_2;//MaxCostByCoverageCategoryType
var $combined_in_out_network;//MaxCostByCoverageCategoryType
}
class ProcedureType{
var $name;//string
var $costs;//CostByNetworkType
}
class MaxCostByCoverageCategoryType{
var $family;//integer
var $individual;//integer
var $default_coinsurance;//integer
}
class Deductables{
}
class OrganizationType{
var $id;//IdentifierType
var $name;//string
var $dba;//string
var $display_name;//string
var $abbreviation;//string
var $fein;//FederalTaxIdType
var $addresses;//AddressListType
var $website;//anyURI
var $phones;//phones
var $emails;//emails
var $contacts;//contacts
var $is_active;//boolean
var $extended_attributes;//anyType
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class CarrierType{
var $id;//IdentifierType
var $name;//string
var $dba;//string
var $display_name;//string
var $abbreviation;//string
var $fein;//FederalTaxIdType
var $website;//anyURI
var $phones;//phones
var $emails;//emails
var $contacts;//contacts
var $is_active;//boolean
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class BrokerType{
var $id;//IdentifierType
var $name;//string
var $dba;//string
var $display_name;//string
var $abbreviation;//string
var $website;//anyURI
var $phones;//phones
var $emails;//emails
var $contacts;//contacts
var $is_active;//boolean
var $extended_attributes;//TpaType
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class HbxType{
var $id;//IdentifierType
var $name;//string
var $dba;//string
var $display_name;//string
var $abbreviation;//string
var $fein;//FederalTaxIdType
var $addresses;//AddressListType
var $website;//anyURI
var $phones;//phones
var $emails;//emails
var $contacts;//contacts
var $is_active;//boolean
var $extended_attributes;//anyType
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class ResponsibleEntityType{
var $entity_identifier;//EntityNameType
var $organization;//OrganizationType
var $policies;//policies
}
class policies{
var $policy;//PolicyLinkType
}
class affected_members{
var $affected_member;//ApplicantLinkType
}
class applicant_links{
var $applicant_link;//ApplicantLinkType
}
class applicants{
var $applicant;//ApplicantType
}
class application_groups{
var $application_group;//ApplicationGroupType
}
class eligibility_determinations{
var $eligibility_determination;//EligibilityDeterminationType
}
class eligibility_determination_applicants{
var $eligibility_determination_applicant;//EligibilityDeterminationApplicantType
}
class emergency_medicaid_enrollments{
var $emergency_medicaid_enrollment;//EmergencyMedicaidEnrollmentType
}
class employee_applicants{
var $employee_applicant;//EmployeeApplicantType
}
class hbx_enrollment_exemptions{
var $hbx_enrollment_exemption;//HbxEnrollmentExemptionType
}
class financial_statements{
var $financial_statement;//FinancialStatementType
}
class hbx_enrollments{
var $hbx_enrollment;//HbxEnrollmentType
}
class hcr_chip_enrollments{
var $hcr_chip_enrollment;//HcrChipEnrollmentType
}
class ia_enrollments{
var $ia_enrollment;//IaEnrollmentType
}
class irs_groups{
var $irs_group;//IrsGroupType
}
class person_relationships{
var $person_relationship;//PersonRelationshipType
}
class responsible_parties{
var $responsible_party;//ResponsiblePartyType
}
class shop_enrollments{
var $shop_enrollment;//ShopEnrollmentType
}
class streamlined_medicaid_enrollments{
var $streamlined_medicaid_enrollment;//StreamlinedMedicaidEnrollmentType
}
class tax_household_members{
var $tax_household_member;//TaxHouseholdMemberType
}
class tax_households{
var $tax_household;//TaxHouseholdType
}
class uqhp_enrollments{
var $uqhp_enrollment;//UQhpEnrollmentType
}
class AlternateBenefitType{
var $type;//AlternateBenefitNameType
var $start_date;//SimpleDateType
var $end_date;//SimpleDateType
var $submitted_date;//dateTime
}
class ApplicationGroupType{
var $id;//IdentifierType
var $application_type;//HbxServiceNameType
var $applicants;//applicants
var $primary_applicant_id;//IdentifierSimpleType
var $renewal_consent_applicant_id;//IdentifierSimpleType
var $irs_groups;//irs_groups
var $tax_households;//tax_households
var $hbx_enrollments;//hbx_enrollments
var $qualifying_life_events;//qualifying_life_events
var $renewal_consent_through_year;//renewal_consent_through_year
var $submitted_at;//dateTime
var $is_active;//boolean
var $comments;//comments
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class qualifying_life_events{
var $qualifying_life_event;//QualifyingLifeEventType
}
class ApplicationGroupRequestType{
var $header;//header
var $request;//request
}
class header{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $authorization;//string
var $message_id;//string
var $originating_service;//anyURI
var $reply_to;//anyURI
var $correlation_id;//string
}
class request{
var $request_name;//ApplicationGroupRequestNameType
var $parameters;//anyType
var $metadata;//ServiceMetadataType
var $body;//body
}
class body{
var $application_group;//ApplicationGroupType
}
class ApplicationGroupEventType{
var $header;//header
var $event;//event
}
class header{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $authorization;//string
var $message_id;//string
var $originating_service;//anyURI
var $correlation_id;//string
}
class event{
var $event_name;//ApplicationGroupEventNameType
var $application_group_uri;//IdentifierSimpleType
var $body;//body
}
class body{
var $application_group;//ApplicationGroupType
}
class ApplicationGroupResponseType{
var $header;//header
var $metadata;//metadata
var $body;//body
}
class header{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $status;//ServiceStatusType
var $message_id;//string
var $correlation_id;//string
}
class metadata{
var $result_set;//ServiceResultSetType
}
class body{
var $application_groups;//application_groups
}
class application_groups{
var $application_group;//ApplicationGroupType
}
class ApplicantLinkType{
var $id;//IdentifierType
var $person;//PersonLinkType
}
class ApplicantType{
var $id;//IdentifierType
var $application_group_id;//IdentifierType
var $tax_household_id;//IdentifierType
var $person;//PersonType
var $person_relationships;//person_relationships
var $person_demographics;//PersonDemographicsType
var $is_primary_applicant;//boolean
var $is_consent_applicant;//boolean
var $is_coverage_applicant;//boolean
var $employee_applicants;//employee_applicants
var $person_health;//IndividualHealthType
var $broker_id;//IdentifierSimpleType
var $hbx_enrollment_exemptions;//hbx_enrollment_exemptions
var $financial_statements;//financial_statements
var $is_active;//boolean
var $comments;//comments
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class EligibilityDeterminationType{
var $id;//IdentifierType
var $household_state;//HouseholdStatusNameType
var $maximum_aptc;//CurrencyType
var $csr_percent;//float
var $benchmark_plan_id;//IdentifierSimpleType
var $determination_date;//SimpleDateType
var $comments;//comments
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class EmergencyMedicaidEnrollmentType{
var $any;//<anyXML>
}
class EmployeeApplicantType{
var $employer_id;//IdentifierSimpleType
var $employment_status;//EmploymentStatusNameType
var $eligibility_date;//date
var $start_date;//date
var $end_date;//date
}
class FinancialStatementType{
var $tax_filing_status;//TaxFilerNameType
var $is_tax_filing_together;//boolean
var $incomes;//incomes
var $deductions;//deductions
var $alternative_benefits;//alternative_benefits
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class incomes{
var $total_income_by_year;//CurrencyAmountPerAnnumType
var $income;//IndividualIncomeType
}
class deductions{
var $total_deductions_by_year;//CurrencyAmountPerAnnumType
var $deduction;//IndividualDeductionType
}
class alternative_benefits{
var $alternative_benefit;//AlternateBenefitType
}
class HbxEnrollmentExemptionType{
var $id;//IdentifierSimpleType
var $type;//HbxEnrollmentExemptionNameType
var $certificate_number;//string
var $start_date;//SimpleDateType
var $end_date;//SimpleDateType
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class HbxEnrollmentType{
var $id;//IdentifierSimpleType
var $type;//HbxServiceNameType
var $uqhp_enrollments;//uqhp_enrollments
var $ia_enrollments;//ia_enrollments
var $shop_enrollments;//shop_enrollments
var $hcr_chip_enrollments;//hcr_chip_enrollments
var $emergency_medicaid_enrollments;//emergency_medicaid_enrollments
var $streamlined_medicaid_enrollments;//streamlined_medicaid_enrollments
var $status;//anyURI
var $comments;//comments
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class HcrChipEnrollmentType{
var $any;//<anyXML>
}
class IaEnrollmentType{
var $policy_id;//IdentifierSimpleType
var $eligibility_determination_id;//IdentifierSimpleType
var $applied_aptc;//CurrencyType
var $elected_aptc;//CurrencyType
var $allocated_aptc;//CurrencyType
var $csr_percent;//float
}
class IndividualDeductionType{
var $amount;//CurrencyType
var $type;//IndividualDeductionNameType
var $frequency;//IncomeFrequencyNameType
var $start_date;//SimpleDateType
var $end_date;//SimpleDateType
var $submitted_date;//dateTime
}
class IndividualEventType{
var $header;//header
var $event;//event
}
class header{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $authorization;//string
var $message_id;//string
var $originating_service;//anyURI
var $correlation_id;//string
}
class event{
var $event_name;//IndividualEventNameType
var $individual_uri;//IdentifierSimpleType
var $body;//body
}
class body{
var $individual;//IndividualType
}
class IndividualHealthType{
var $is_tobacco_user;//TobaccoUseNameType
var $is_disabled;//boolean
}
class IndividualIncomeType{
var $amount;//CurrencyType
var $type;//IndividualIncomeNameType
var $frequency;//IncomeFrequencyNameType
var $start_date;//SimpleDateType
var $end_date;//SimpleDateType
var $submitted_date;//dateTime
}
class IndividualRequestType{
var $header;//header
var $request;//request
}
class header{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $authorization;//string
var $message_id;//string
var $originating_service;//anyURI
var $reply_to;//anyURI
var $correlation_id;//string
}
class request{
var $request_name;//IndividualRequestNameType
var $parameters;//anyType
var $metadata;//ServiceMetadataType
var $body;//body
}
class body{
var $individual;//IndividualType
}
class IndividualResponseType{
var $header;//header
var $metadata;//metadata
var $body;//body
}
class header{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $status;//ServiceStatusType
var $message_id;//string
var $correlation_id;//string
}
class metadata{
var $result_set;//ServiceResultSetType
}
class body{
var $individuals;//individuals
}
class individuals{
var $individual;//IndividualType
}
class IndividualUpdateType{
var $change_type;//IndividualUpdateNameType
var $individual;//IndividualType
var $previous_information;//PreviousIndividualType
}
class IndividualType{
var $id;//IdentifierType
var $application_group_id;//IdentifierType
var $tax_household_id;//IdentifierType
var $person;//PersonType
var $person_relationships;//person_relationships
var $person_demographics;//PersonDemographicsType
var $is_primary_applicant;//boolean
var $is_consent_applicant;//boolean
var $is_subscriber;//boolean
var $is_coverage_applicant;//boolean
var $employee_applicants;//employee_applicants
var $is_without_assistance;//boolean
var $is_enrolled_in_employer_sponsored_coverage;//boolean
var $is_insurance_assistance_eligible;//boolean
var $is_medicaid_chip_eligible;//boolean
var $person_health;//IndividualHealthType
var $broker_id;//IdentifierSimpleType
var $responsible_parties;//responsible_parties
var $hbx_enrollment_exemptions;//hbx_enrollment_exemptions
var $financial_statements;//financial_statements
var $is_active;//boolean
var $comments;//comments
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class IrsGroupType{
var $id;//IdentifierSimpleType
var $tax_households_ids;//tax_households_ids
var $hbx_enrollment_ids;//hbx_enrollment_ids
var $effective_start_date;//SimpleDateType
var $effective_end_date;//SimpleDateType
var $comments;//comments
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class tax_households_ids{
var $tax_household_id;//IdentifierSimpleType
}
class hbx_enrollment_ids{
var $hbx_enrollment_id;//IdentifierSimpleType
}
class MinimumEssentialCoverageType{
var $id;//IdentifierType
var $any;//<anyXML>
}
class PersonDemographicsType{
var $ssn;//FederalTaxIdType
var $sex;//GenderNameType
var $birth_date;//SimpleDateType
var $death_date;//SimpleDateType
var $is_incarcerated;//boolean
var $language_code;//LanguageNameType
var $ethnicity;//ethnicity
var $race;//anyURI
var $birth_location;//string
var $marital_status;//MaritalStatusNameType
var $citizen_status;//UsCitizenStatusNameType
var $is_state_resident;//boolean
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class PersonRelationshipType{
var $subject_individual;//IdentifierSimpleType
var $relationship_uri;//PersonRelationshipNameType
var $inverse_relationship_uri;//PersonRelationshipNameType
var $object_individual;//IdentifierSimpleType
}
class PreviousIndividualType{
var $name_prefix;//string
var $name_first;//string
var $name_middle;//string
var $name_last;//string
var $name_suffix;//string
var $name_full;//string
var $member_change;//PreviousMemberType
}
class PreviousMemberType{
var $identifier;//IdentifierType
var $alias_ids;//alias_ids
var $gender;//GenderNameType
var $dob;//SimpleDateType
var $ssn;//FederalTaxIdType
}
class QualifyingLifeEventType{
var $id;//IdentifierType
var $type;//QualifyingLifeEventNameType
var $affected_members;//affected_members
var $event_date;//SimpleDateType
var $submitted_date;//dateTime
var $special_enrollment_period;//DateRangeType
var $approval;//ApprovalType
var $is_active;//boolean
var $comments;//comments
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class ResponsiblePartyType{
var $id;//IdentifierType
var $person_name;//PersonNameType
var $addresses;//AddressListType
var $emails;//emails
var $phones;//phones
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class TaxHouseholdBaseType{
var $id;//IdentifierType
var $primary_applicant_id;//IdentifierSimpleType
var $tax_household_members;//tax_household_members
var $tax_household_size;//TaxHouseholdSizeType
var $total_incomes_by_year;//TotalIncomesByYearType
var $eligibility_determinations;//eligibility_determinations
var $is_active;//boolean
var $comments;//comments
var $submitted_at;//dateTime
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class TaxHouseholdMemberType{
var $person;//PersonLinkType
var $is_subscriber;//boolean
var $is_without_assistance;//boolean
var $is_enrolled_in_employer_sponsored_coverage;//boolean
var $is_insurance_assistance_eligible;//boolean
var $is_medicaid_chip_eligible;//boolean
var $financial_statements;//financial_statements
}
class TaxHouseholdType{
var $id;//IdentifierType
var $primary_applicant_id;//IdentifierSimpleType
var $tax_household_members;//tax_household_members
var $tax_household_size;//TaxHouseholdSizeType
var $total_incomes_by_year;//TotalIncomesByYearType
var $eligibility_determinations;//eligibility_determinations
var $is_active;//boolean
var $comments;//comments
var $submitted_at;//dateTime
var $created_at;//dateTime
var $modified_at;//dateTime
var $version;//integer
}
class TotalIncomesByYearType{
var $total_income_by_year;//CurrencyAmountPerAnnumType
}
class EligibilityDeterminationApplicantType{
var $person;//PersonLinkType
var $is_without_assistance;//boolean
var $is_enrolled_in_employer_sponsored_coverage;//boolean
var $is_insurance_assistance_eligible;//boolean
var $is_medicaid_chip_eligible;//boolean
}
class TaxHouseholdSizeType{
var $adult_count;//integer
var $child_count;//integer
var $total_count;//integer
}
class ShopEnrollmentType{
var $policy_id;//IdentifierSimpleType
var $employer;//EmployerLinkType
var $employment_status;//EmploymentStatusNameType
var $eligibility_start_date;//SimpleDateType
var $start_date;//SimpleDateType
var $end_date;//SimpleDateType
var $employment_termination_date;//SimpleDateType
var $employer_contribution_amount;//CurrencyType
}
class StreamlinedMedicaidEnrollmentType{
var $any;//<anyXML>
}
class UQhpEnrollmentType{
var $policy_id;//IdentifierSimpleType
var $eligibility_determination_id;//IdentifierSimpleType
}
class residencyVerificationRequestBodyType{
var $individual;//individual
}
class individual{
var $id;//IdentifierType
var $person;//PersonType
var $person_demographics;//PersonDemographicsType
}
class residencyVerificationRequestType{
var $request_name;//request_name
var $body;//body
}
class body{
var $residency_verification_request;//residencyVerificationRequestBodyType
}
class residencyVerificationResponseType{
var $header;//header
var $metadata;//ServiceMetadataType
var $body;//body
}
class header{
var $hbx_id;//string
var $submitted_timestamp;//dateTime
var $status;//ServiceStatusType
}
class body{
var $residency_verification_response;//residencyVerificationResultCodeType
}
class  
 {
 var $soapClient;
 
private static $classmap = array('AddressListType'=>'AddressListType'
,'alias_ids'=>'alias_ids'
,'alias_id'=>'alias_id'
,'approvals'=>'approvals'
,'comments'=>'comments'
,'contacts'=>'contacts'
,'emails'=>'emails'
,'phones'=>'phones'
,'rates'=>'rates'
,'AddressType'=>'AddressType'
,'ApprovalType'=>'ApprovalType'
,'CommentType'=>'CommentType'
,'ContactType'=>'ContactType'
,'CurrencyAmountPerAnnumType'=>'CurrencyAmountPerAnnumType'
,'DateRangeType'=>'DateRangeType'
,'EmailType'=>'EmailType'
,'IdentifierBaseType'=>'IdentifierBaseType'
,'IdentifierFullyQualifiedType'=>'IdentifierFullyQualifiedType'
,'IdentifierSimpleType'=>'IdentifierSimpleType'
,'IdentifierType'=>'IdentifierType'
,'LocationNameType'=>'LocationNameType'
,'PersonLinkType'=>'PersonLinkType'
,'person_name'=>'person_name'
,'PersonNameType'=>'PersonNameType'
,'PersonType'=>'PersonType'
,'PhoneType'=>'PhoneType'
,'PositionPointType'=>'PositionPointType'
,'RateType'=>'RateType'
,'ServiceBodyType'=>'ServiceBodyType'
,'ServiceEndPointType'=>'ServiceEndPointType'
,'ServiceErrorType'=>'ServiceErrorType'
,'ServiceEventType'=>'ServiceEventType'
,'ServiceHeaderType'=>'ServiceHeaderType'
,'application_header_properties'=>'application_header_properties'
,'ServiceMetadataType'=>'ServiceMetadataType'
,'ServiceStatusType'=>'ServiceStatusType'
,'ServiceRequestType'=>'ServiceRequestType'
,'ServiceResponseType'=>'ServiceResponseType'
,'ServiceResultSetType'=>'ServiceResultSetType'
,'SimpleDateRangeType'=>'SimpleDateRangeType'
,'TpaType'=>'TpaType'
,'enrollees'=>'enrollees'
,'BrokerLinkType'=>'BrokerLinkType'
,'CarrierLinkType'=>'CarrierLinkType'
,'EmployerLinkType'=>'EmployerLinkType'
,'EnrolleeBenefitType'=>'EnrolleeBenefitType'
,'EnrolleeLinkType'=>'EnrolleeLinkType'
,'IndividualLinkType'=>'IndividualLinkType'
,'PlanLinkType'=>'PlanLinkType'
,'PolicyLinkType'=>'PolicyLinkType'
,'coverages'=>'coverages'
,'deductables'=>'deductables'
,'maximums'=>'maximums'
,'plan'=>'plan'
,'PlanBaseType'=>'PlanBaseType'
,'PlanType'=>'PlanType'
,'CostStructureType'=>'CostStructureType'
,'sbc_scenario'=>'sbc_scenario'
,'custom_scenarios'=>'custom_scenarios'
,'name'=>'name'
,'CoverageType'=>'CoverageType'
,'name'=>'name'
,'DeductableType'=>'DeductableType'
,'MaximumType'=>'MaximumType'
,'PlanMetadataType'=>'PlanMetadataType'
,'CoverageCostType'=>'CoverageCostType'
,'CostByNetworkType'=>'CostByNetworkType'
,'ProcedureType'=>'ProcedureType'
,'MaxCostByCoverageCategoryType'=>'MaxCostByCoverageCategoryType'
,'Deductables'=>'Deductables'
,'OrganizationType'=>'OrganizationType'
,'CarrierType'=>'CarrierType'
,'BrokerType'=>'BrokerType'
,'HbxType'=>'HbxType'
,'ResponsibleEntityType'=>'ResponsibleEntityType'
,'policies'=>'policies'
,'affected_members'=>'affected_members'
,'applicant_links'=>'applicant_links'
,'applicants'=>'applicants'
,'application_groups'=>'application_groups'
,'eligibility_determinations'=>'eligibility_determinations'
,'eligibility_determination_applicants'=>'eligibility_determination_applicants'
,'emergency_medicaid_enrollments'=>'emergency_medicaid_enrollments'
,'employee_applicants'=>'employee_applicants'
,'hbx_enrollment_exemptions'=>'hbx_enrollment_exemptions'
,'financial_statements'=>'financial_statements'
,'hbx_enrollments'=>'hbx_enrollments'
,'hcr_chip_enrollments'=>'hcr_chip_enrollments'
,'ia_enrollments'=>'ia_enrollments'
,'irs_groups'=>'irs_groups'
,'person_relationships'=>'person_relationships'
,'responsible_parties'=>'responsible_parties'
,'shop_enrollments'=>'shop_enrollments'
,'streamlined_medicaid_enrollments'=>'streamlined_medicaid_enrollments'
,'tax_household_members'=>'tax_household_members'
,'tax_households'=>'tax_households'
,'uqhp_enrollments'=>'uqhp_enrollments'
,'AlternateBenefitType'=>'AlternateBenefitType'
,'ApplicationGroupType'=>'ApplicationGroupType'
,'qualifying_life_events'=>'qualifying_life_events'
,'ApplicationGroupRequestType'=>'ApplicationGroupRequestType'
,'header'=>'header'
,'request'=>'request'
,'body'=>'body'
,'ApplicationGroupEventType'=>'ApplicationGroupEventType'
,'header'=>'header'
,'event'=>'event'
,'body'=>'body'
,'ApplicationGroupResponseType'=>'ApplicationGroupResponseType'
,'header'=>'header'
,'metadata'=>'metadata'
,'body'=>'body'
,'application_groups'=>'application_groups'
,'ApplicantLinkType'=>'ApplicantLinkType'
,'ApplicantType'=>'ApplicantType'
,'EligibilityDeterminationType'=>'EligibilityDeterminationType'
,'EmergencyMedicaidEnrollmentType'=>'EmergencyMedicaidEnrollmentType'
,'EmployeeApplicantType'=>'EmployeeApplicantType'
,'FinancialStatementType'=>'FinancialStatementType'
,'incomes'=>'incomes'
,'deductions'=>'deductions'
,'alternative_benefits'=>'alternative_benefits'
,'HbxEnrollmentExemptionType'=>'HbxEnrollmentExemptionType'
,'HbxEnrollmentType'=>'HbxEnrollmentType'
,'HcrChipEnrollmentType'=>'HcrChipEnrollmentType'
,'IaEnrollmentType'=>'IaEnrollmentType'
,'IndividualDeductionType'=>'IndividualDeductionType'
,'IndividualEventType'=>'IndividualEventType'
,'header'=>'header'
,'event'=>'event'
,'body'=>'body'
,'IndividualHealthType'=>'IndividualHealthType'
,'IndividualIncomeType'=>'IndividualIncomeType'
,'IndividualRequestType'=>'IndividualRequestType'
,'header'=>'header'
,'request'=>'request'
,'body'=>'body'
,'IndividualResponseType'=>'IndividualResponseType'
,'header'=>'header'
,'metadata'=>'metadata'
,'body'=>'body'
,'individuals'=>'individuals'
,'IndividualUpdateType'=>'IndividualUpdateType'
,'IndividualType'=>'IndividualType'
,'IrsGroupType'=>'IrsGroupType'
,'tax_households_ids'=>'tax_households_ids'
,'hbx_enrollment_ids'=>'hbx_enrollment_ids'
,'MinimumEssentialCoverageType'=>'MinimumEssentialCoverageType'
,'PersonDemographicsType'=>'PersonDemographicsType'
,'PersonRelationshipType'=>'PersonRelationshipType'
,'PreviousIndividualType'=>'PreviousIndividualType'
,'PreviousMemberType'=>'PreviousMemberType'
,'QualifyingLifeEventType'=>'QualifyingLifeEventType'
,'ResponsiblePartyType'=>'ResponsiblePartyType'
,'TaxHouseholdBaseType'=>'TaxHouseholdBaseType'
,'TaxHouseholdMemberType'=>'TaxHouseholdMemberType'
,'TaxHouseholdType'=>'TaxHouseholdType'
,'TotalIncomesByYearType'=>'TotalIncomesByYearType'
,'EligibilityDeterminationApplicantType'=>'EligibilityDeterminationApplicantType'
,'TaxHouseholdSizeType'=>'TaxHouseholdSizeType'
,'ShopEnrollmentType'=>'ShopEnrollmentType'
,'StreamlinedMedicaidEnrollmentType'=>'StreamlinedMedicaidEnrollmentType'
,'UQhpEnrollmentType'=>'UQhpEnrollmentType'
,'residencyVerificationRequestBodyType'=>'residencyVerificationRequestBodyType'
,'individual'=>'individual'
,'residencyVerificationRequestType'=>'residencyVerificationRequestType'
,'body'=>'body'
,'residencyVerificationResponseType'=>'residencyVerificationResponseType'
,'header'=>'header'
,'body'=>'body'

);

 function __construct($url='http://dhsdcasesbsoaappuat01.dhs.dc.gov:8001/soa-infra/services/POC/EnrollAppLocalHubVerificationCmpService/enrollapplocalhubverificationbpelprocess_client_ep?WSDL')
 {
  $this->soapClient = new SoapClient($url,array("classmap"=>self::$classmap,"trace" => true,"exceptions" => true));
 }
 
function process($residencyVerificationRequestBodyType)
{

$residencyVerificationResultCodeType = $this->soapClient->process($residencyVerificationRequestBodyType);
return $residencyVerificationResultCodeType;

}}


?>
