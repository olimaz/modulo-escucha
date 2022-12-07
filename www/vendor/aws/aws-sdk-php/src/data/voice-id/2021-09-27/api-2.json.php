<?php
// This file was auto-generated from sdk-root/src/data/voice-id/2021-09-27/api-2.json
return [ 'version' => '2.0', 'metadata' => [ 'apiVersion' => '2021-09-27', 'endpointPrefix' => 'voiceid', 'jsonVersion' => '1.0', 'protocol' => 'json', 'serviceFullName' => 'Amazon Voice ID', 'serviceId' => 'Voice ID', 'signatureVersion' => 'v4', 'signingName' => 'voiceid', 'targetPrefix' => 'VoiceID', 'uid' => 'voice-id-2021-09-27', ], 'operations' => [ 'CreateDomain' => [ 'name' => 'CreateDomain', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreateDomainRequest', ], 'output' => [ 'shape' => 'CreateDomainResponse', ], 'errors' => [ [ 'shape' => 'ServiceQuotaExceededException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], 'idempotent' => true, ], 'DeleteDomain' => [ 'name' => 'DeleteDomain', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteDomainRequest', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'DeleteFraudster' => [ 'name' => 'DeleteFraudster', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteFraudsterRequest', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'DeleteSpeaker' => [ 'name' => 'DeleteSpeaker', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteSpeakerRequest', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'DescribeDomain' => [ 'name' => 'DescribeDomain', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeDomainRequest', ], 'output' => [ 'shape' => 'DescribeDomainResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'DescribeFraudster' => [ 'name' => 'DescribeFraudster', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeFraudsterRequest', ], 'output' => [ 'shape' => 'DescribeFraudsterResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'DescribeFraudsterRegistrationJob' => [ 'name' => 'DescribeFraudsterRegistrationJob', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeFraudsterRegistrationJobRequest', ], 'output' => [ 'shape' => 'DescribeFraudsterRegistrationJobResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'DescribeSpeaker' => [ 'name' => 'DescribeSpeaker', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeSpeakerRequest', ], 'output' => [ 'shape' => 'DescribeSpeakerResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'DescribeSpeakerEnrollmentJob' => [ 'name' => 'DescribeSpeakerEnrollmentJob', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeSpeakerEnrollmentJobRequest', ], 'output' => [ 'shape' => 'DescribeSpeakerEnrollmentJobResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'EvaluateSession' => [ 'name' => 'EvaluateSession', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'EvaluateSessionRequest', ], 'output' => [ 'shape' => 'EvaluateSessionResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'ListDomains' => [ 'name' => 'ListDomains', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListDomainsRequest', ], 'output' => [ 'shape' => 'ListDomainsResponse', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'ListFraudsterRegistrationJobs' => [ 'name' => 'ListFraudsterRegistrationJobs', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListFraudsterRegistrationJobsRequest', ], 'output' => [ 'shape' => 'ListFraudsterRegistrationJobsResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'ListSpeakerEnrollmentJobs' => [ 'name' => 'ListSpeakerEnrollmentJobs', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListSpeakerEnrollmentJobsRequest', ], 'output' => [ 'shape' => 'ListSpeakerEnrollmentJobsResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'ListSpeakers' => [ 'name' => 'ListSpeakers', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListSpeakersRequest', ], 'output' => [ 'shape' => 'ListSpeakersResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'ListTagsForResource' => [ 'name' => 'ListTagsForResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ListTagsForResourceRequest', ], 'output' => [ 'shape' => 'ListTagsForResourceResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'OptOutSpeaker' => [ 'name' => 'OptOutSpeaker', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'OptOutSpeakerRequest', ], 'output' => [ 'shape' => 'OptOutSpeakerResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'StartFraudsterRegistrationJob' => [ 'name' => 'StartFraudsterRegistrationJob', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'StartFraudsterRegistrationJobRequest', ], 'output' => [ 'shape' => 'StartFraudsterRegistrationJobResponse', ], 'errors' => [ [ 'shape' => 'ServiceQuotaExceededException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], 'idempotent' => true, ], 'StartSpeakerEnrollmentJob' => [ 'name' => 'StartSpeakerEnrollmentJob', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'StartSpeakerEnrollmentJobRequest', ], 'output' => [ 'shape' => 'StartSpeakerEnrollmentJobResponse', ], 'errors' => [ [ 'shape' => 'ServiceQuotaExceededException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], 'idempotent' => true, ], 'TagResource' => [ 'name' => 'TagResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'TagResourceRequest', ], 'output' => [ 'shape' => 'TagResourceResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'UntagResource' => [ 'name' => 'UntagResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'UntagResourceRequest', ], 'output' => [ 'shape' => 'UntagResourceResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], 'UpdateDomain' => [ 'name' => 'UpdateDomain', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'UpdateDomainRequest', ], 'output' => [ 'shape' => 'UpdateDomainResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'ConflictException', ], [ 'shape' => 'InternalServerException', ], [ 'shape' => 'ThrottlingException', ], [ 'shape' => 'AccessDeniedException', ], ], ], ], 'shapes' => [ 'AccessDeniedException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'exception' => true, ], 'AmazonResourceName' => [ 'type' => 'string', 'max' => 1011, 'min' => 1, 'pattern' => '^arn:aws(-[^:]+)?:voiceid.+:[0-9]{12}:domain/[a-zA-Z0-9]{22}$', ], 'Arn' => [ 'type' => 'string', 'pattern' => '^arn:aws(-[^:]+)?:voiceid.+:[0-9]{12}:domain/[a-zA-Z0-9]{22}$', ], 'AuthenticationConfiguration' => [ 'type' => 'structure', 'required' => [ 'AcceptanceThreshold', ], 'members' => [ 'AcceptanceThreshold' => [ 'shape' => 'Score', ], ], ], 'AuthenticationDecision' => [ 'type' => 'string', 'enum' => [ 'ACCEPT', 'REJECT', 'NOT_ENOUGH_SPEECH', 'SPEAKER_NOT_ENROLLED', 'SPEAKER_OPTED_OUT', 'SPEAKER_ID_NOT_PROVIDED', 'SPEAKER_EXPIRED', ], ], 'AuthenticationResult' => [ 'type' => 'structure', 'members' => [ 'AudioAggregationEndedAt' => [ 'shape' => 'Timestamp', ], 'AudioAggregationStartedAt' => [ 'shape' => 'Timestamp', ], 'AuthenticationResultId' => [ 'shape' => 'UniqueIdLarge', ], 'Configuration' => [ 'shape' => 'AuthenticationConfiguration', ], 'CustomerSpeakerId' => [ 'shape' => 'CustomerSpeakerId', ], 'Decision' => [ 'shape' => 'AuthenticationDecision', ], 'GeneratedSpeakerId' => [ 'shape' => 'GeneratedSpeakerId', ], 'Score' => [ 'shape' => 'Score', ], ], ], 'ClientTokenString' => [ 'type' => 'string', 'max' => 64, 'min' => 1, 'pattern' => '^[a-zA-Z0-9-_]+$', ], 'ConflictException' => [ 'type' => 'structure', 'members' => [ 'ConflictType' => [ 'shape' => 'ConflictType', ], 'Message' => [ 'shape' => 'String', ], ], 'exception' => true, ], 'ConflictType' => [ 'type' => 'string', 'enum' => [ 'ANOTHER_ACTIVE_STREAM', 'DOMAIN_NOT_ACTIVE', 'CANNOT_CHANGE_SPEAKER_AFTER_ENROLLMENT', 'ENROLLMENT_ALREADY_EXISTS', 'SPEAKER_NOT_SET', 'SPEAKER_OPTED_OUT', 'CONCURRENT_CHANGES', 'DOMAIN_LOCKED_FROM_ENCRYPTION_UPDATES', ], ], 'CreateDomainRequest' => [ 'type' => 'structure', 'required' => [ 'Name', 'ServerSideEncryptionConfiguration', ], 'members' => [ 'ClientToken' => [ 'shape' => 'ClientTokenString', 'idempotencyToken' => true, ], 'Description' => [ 'shape' => 'Description', ], 'Name' => [ 'shape' => 'DomainName', ], 'ServerSideEncryptionConfiguration' => [ 'shape' => 'ServerSideEncryptionConfiguration', ], 'Tags' => [ 'shape' => 'TagList', ], ], ], 'CreateDomainResponse' => [ 'type' => 'structure', 'members' => [ 'Domain' => [ 'shape' => 'Domain', ], ], ], 'CustomerSpeakerId' => [ 'type' => 'string', 'max' => 256, 'min' => 1, 'pattern' => '^[a-zA-Z0-9][a-zA-Z0-9_-]*$', 'sensitive' => true, ], 'DeleteDomainRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], ], ], 'DeleteFraudsterRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'FraudsterId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'FraudsterId' => [ 'shape' => 'FraudsterId', ], ], ], 'DeleteSpeakerRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'SpeakerId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'SpeakerId' => [ 'shape' => 'SpeakerId', ], ], ], 'DescribeDomainRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], ], ], 'DescribeDomainResponse' => [ 'type' => 'structure', 'members' => [ 'Domain' => [ 'shape' => 'Domain', ], ], ], 'DescribeFraudsterRegistrationJobRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'JobId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'JobId' => [ 'shape' => 'JobId', ], ], ], 'DescribeFraudsterRegistrationJobResponse' => [ 'type' => 'structure', 'members' => [ 'Job' => [ 'shape' => 'FraudsterRegistrationJob', ], ], ], 'DescribeFraudsterRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'FraudsterId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'FraudsterId' => [ 'shape' => 'FraudsterId', ], ], ], 'DescribeFraudsterResponse' => [ 'type' => 'structure', 'members' => [ 'Fraudster' => [ 'shape' => 'Fraudster', ], ], ], 'DescribeSpeakerEnrollmentJobRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'JobId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'JobId' => [ 'shape' => 'JobId', ], ], ], 'DescribeSpeakerEnrollmentJobResponse' => [ 'type' => 'structure', 'members' => [ 'Job' => [ 'shape' => 'SpeakerEnrollmentJob', ], ], ], 'DescribeSpeakerRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'SpeakerId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'SpeakerId' => [ 'shape' => 'SpeakerId', ], ], ], 'DescribeSpeakerResponse' => [ 'type' => 'structure', 'members' => [ 'Speaker' => [ 'shape' => 'Speaker', ], ], ], 'Description' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, 'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-%@]*)$', 'sensitive' => true, ], 'Domain' => [ 'type' => 'structure', 'members' => [ 'Arn' => [ 'shape' => 'Arn', ], 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'Description' => [ 'shape' => 'Description', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'DomainStatus' => [ 'shape' => 'DomainStatus', ], 'Name' => [ 'shape' => 'DomainName', ], 'ServerSideEncryptionConfiguration' => [ 'shape' => 'ServerSideEncryptionConfiguration', ], 'ServerSideEncryptionUpdateDetails' => [ 'shape' => 'ServerSideEncryptionUpdateDetails', ], 'UpdatedAt' => [ 'shape' => 'Timestamp', ], ], ], 'DomainId' => [ 'type' => 'string', 'max' => 22, 'min' => 22, 'pattern' => '^[a-zA-Z0-9]{22}$', ], 'DomainName' => [ 'type' => 'string', 'max' => 256, 'min' => 1, 'pattern' => '^[a-zA-Z0-9][a-zA-Z0-9_-]*$', 'sensitive' => true, ], 'DomainStatus' => [ 'type' => 'string', 'enum' => [ 'ACTIVE', 'PENDING', 'SUSPENDED', ], ], 'DomainSummaries' => [ 'type' => 'list', 'member' => [ 'shape' => 'DomainSummary', ], ], 'DomainSummary' => [ 'type' => 'structure', 'members' => [ 'Arn' => [ 'shape' => 'Arn', ], 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'Description' => [ 'shape' => 'Description', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'DomainStatus' => [ 'shape' => 'DomainStatus', ], 'Name' => [ 'shape' => 'DomainName', ], 'ServerSideEncryptionConfiguration' => [ 'shape' => 'ServerSideEncryptionConfiguration', ], 'ServerSideEncryptionUpdateDetails' => [ 'shape' => 'ServerSideEncryptionUpdateDetails', ], 'UpdatedAt' => [ 'shape' => 'Timestamp', ], ], ], 'DuplicateRegistrationAction' => [ 'type' => 'string', 'enum' => [ 'SKIP', 'REGISTER_AS_NEW', ], ], 'EnrollmentConfig' => [ 'type' => 'structure', 'members' => [ 'ExistingEnrollmentAction' => [ 'shape' => 'ExistingEnrollmentAction', ], 'FraudDetectionConfig' => [ 'shape' => 'EnrollmentJobFraudDetectionConfig', ], ], ], 'EnrollmentJobFraudDetectionConfig' => [ 'type' => 'structure', 'members' => [ 'FraudDetectionAction' => [ 'shape' => 'FraudDetectionAction', ], 'RiskThreshold' => [ 'shape' => 'Score', ], ], ], 'EvaluateSessionRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'SessionNameOrId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'SessionNameOrId' => [ 'shape' => 'SessionNameOrId', ], ], ], 'EvaluateSessionResponse' => [ 'type' => 'structure', 'members' => [ 'AuthenticationResult' => [ 'shape' => 'AuthenticationResult', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'FraudDetectionResult' => [ 'shape' => 'FraudDetectionResult', ], 'SessionId' => [ 'shape' => 'SessionId', ], 'SessionName' => [ 'shape' => 'SessionName', ], 'StreamingStatus' => [ 'shape' => 'StreamingStatus', ], ], ], 'ExistingEnrollmentAction' => [ 'type' => 'string', 'enum' => [ 'SKIP', 'OVERWRITE', ], ], 'FailureDetails' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], 'StatusCode' => [ 'shape' => 'Integer', ], ], ], 'FraudDetectionAction' => [ 'type' => 'string', 'enum' => [ 'IGNORE', 'FAIL', ], ], 'FraudDetectionConfiguration' => [ 'type' => 'structure', 'required' => [ 'RiskThreshold', ], 'members' => [ 'RiskThreshold' => [ 'shape' => 'Score', ], ], ], 'FraudDetectionDecision' => [ 'type' => 'string', 'enum' => [ 'HIGH_RISK', 'LOW_RISK', 'NOT_ENOUGH_SPEECH', ], ], 'FraudDetectionReason' => [ 'type' => 'string', 'enum' => [ 'KNOWN_FRAUDSTER', ], ], 'FraudDetectionReasons' => [ 'type' => 'list', 'member' => [ 'shape' => 'FraudDetectionReason', ], 'max' => 3, 'min' => 0, ], 'FraudDetectionResult' => [ 'type' => 'structure', 'members' => [ 'AudioAggregationEndedAt' => [ 'shape' => 'Timestamp', ], 'AudioAggregationStartedAt' => [ 'shape' => 'Timestamp', ], 'Configuration' => [ 'shape' => 'FraudDetectionConfiguration', ], 'Decision' => [ 'shape' => 'FraudDetectionDecision', ], 'FraudDetectionResultId' => [ 'shape' => 'UniqueIdLarge', ], 'Reasons' => [ 'shape' => 'FraudDetectionReasons', ], 'RiskDetails' => [ 'shape' => 'FraudRiskDetails', ], ], ], 'FraudRiskDetails' => [ 'type' => 'structure', 'required' => [ 'KnownFraudsterRisk', ], 'members' => [ 'KnownFraudsterRisk' => [ 'shape' => 'KnownFraudsterRisk', ], ], ], 'Fraudster' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'GeneratedFraudsterId' => [ 'shape' => 'GeneratedFraudsterId', ], ], ], 'FraudsterId' => [ 'type' => 'string', 'max' => 25, 'min' => 25, 'pattern' => '^id#[a-zA-Z0-9]{22}$', 'sensitive' => true, ], 'FraudsterRegistrationJob' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'DataAccessRoleArn' => [ 'shape' => 'IamRoleArn', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'EndedAt' => [ 'shape' => 'Timestamp', ], 'FailureDetails' => [ 'shape' => 'FailureDetails', ], 'InputDataConfig' => [ 'shape' => 'InputDataConfig', ], 'JobId' => [ 'shape' => 'JobId', ], 'JobName' => [ 'shape' => 'JobName', ], 'JobProgress' => [ 'shape' => 'JobProgress', ], 'JobStatus' => [ 'shape' => 'FraudsterRegistrationJobStatus', ], 'OutputDataConfig' => [ 'shape' => 'OutputDataConfig', ], 'RegistrationConfig' => [ 'shape' => 'RegistrationConfig', ], ], ], 'FraudsterRegistrationJobStatus' => [ 'type' => 'string', 'enum' => [ 'SUBMITTED', 'IN_PROGRESS', 'COMPLETED', 'COMPLETED_WITH_ERRORS', 'FAILED', ], ], 'FraudsterRegistrationJobSummaries' => [ 'type' => 'list', 'member' => [ 'shape' => 'FraudsterRegistrationJobSummary', ], ], 'FraudsterRegistrationJobSummary' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'EndedAt' => [ 'shape' => 'Timestamp', ], 'FailureDetails' => [ 'shape' => 'FailureDetails', ], 'JobId' => [ 'shape' => 'JobId', ], 'JobName' => [ 'shape' => 'JobName', ], 'JobProgress' => [ 'shape' => 'JobProgress', ], 'JobStatus' => [ 'shape' => 'FraudsterRegistrationJobStatus', ], ], ], 'GeneratedFraudsterId' => [ 'type' => 'string', 'max' => 25, 'min' => 25, 'pattern' => '^id#[a-zA-Z0-9]{22}$', ], 'GeneratedSpeakerId' => [ 'type' => 'string', 'max' => 25, 'min' => 25, 'pattern' => '^id#[a-zA-Z0-9]{22}$', ], 'IamRoleArn' => [ 'type' => 'string', 'max' => 2048, 'min' => 20, 'pattern' => '^arn:aws(-[^:]+)?:iam::[0-9]{12}:role/.+$', ], 'InputDataConfig' => [ 'type' => 'structure', 'required' => [ 'S3Uri', ], 'members' => [ 'S3Uri' => [ 'shape' => 'S3Uri', ], ], ], 'Integer' => [ 'type' => 'integer', 'box' => true, ], 'InternalServerException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'exception' => true, 'fault' => true, ], 'JobId' => [ 'type' => 'string', 'max' => 22, 'min' => 22, 'pattern' => '^[a-zA-Z0-9]{22}$', ], 'JobName' => [ 'type' => 'string', 'max' => 256, 'min' => 1, 'pattern' => '^[a-zA-Z0-9][a-zA-Z0-9_-]*$', 'sensitive' => true, ], 'JobProgress' => [ 'type' => 'structure', 'members' => [ 'PercentComplete' => [ 'shape' => 'Score', ], ], ], 'KmsKeyId' => [ 'type' => 'string', 'max' => 2048, 'min' => 1, ], 'KnownFraudsterRisk' => [ 'type' => 'structure', 'required' => [ 'RiskScore', ], 'members' => [ 'GeneratedFraudsterId' => [ 'shape' => 'GeneratedFraudsterId', ], 'RiskScore' => [ 'shape' => 'Score', ], ], ], 'ListDomainsRequest' => [ 'type' => 'structure', 'members' => [ 'MaxResults' => [ 'shape' => 'MaxResultsForListDomainFe', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListDomainsResponse' => [ 'type' => 'structure', 'members' => [ 'DomainSummaries' => [ 'shape' => 'DomainSummaries', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListFraudsterRegistrationJobsRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'JobStatus' => [ 'shape' => 'FraudsterRegistrationJobStatus', ], 'MaxResults' => [ 'shape' => 'MaxResultsForList', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListFraudsterRegistrationJobsResponse' => [ 'type' => 'structure', 'members' => [ 'JobSummaries' => [ 'shape' => 'FraudsterRegistrationJobSummaries', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListSpeakerEnrollmentJobsRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'JobStatus' => [ 'shape' => 'SpeakerEnrollmentJobStatus', ], 'MaxResults' => [ 'shape' => 'MaxResultsForList', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListSpeakerEnrollmentJobsResponse' => [ 'type' => 'structure', 'members' => [ 'JobSummaries' => [ 'shape' => 'SpeakerEnrollmentJobSummaries', ], 'NextToken' => [ 'shape' => 'String', ], ], ], 'ListSpeakersRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'MaxResults' => [ 'shape' => 'MaxResultsForList', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListSpeakersResponse' => [ 'type' => 'structure', 'members' => [ 'NextToken' => [ 'shape' => 'String', ], 'SpeakerSummaries' => [ 'shape' => 'SpeakerSummaries', ], ], ], 'ListTagsForResourceRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'AmazonResourceName', ], ], ], 'ListTagsForResourceResponse' => [ 'type' => 'structure', 'members' => [ 'Tags' => [ 'shape' => 'TagList', ], ], ], 'MaxResultsForList' => [ 'type' => 'integer', 'box' => true, 'max' => 100, 'min' => 1, ], 'MaxResultsForListDomainFe' => [ 'type' => 'integer', 'box' => true, 'max' => 10, 'min' => 1, ], 'NextToken' => [ 'type' => 'string', 'max' => 8192, 'min' => 0, 'pattern' => '^\\p{ASCII}{0,8192}$', ], 'OptOutSpeakerRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'SpeakerId', ], 'members' => [ 'DomainId' => [ 'shape' => 'DomainId', ], 'SpeakerId' => [ 'shape' => 'SpeakerId', ], ], ], 'OptOutSpeakerResponse' => [ 'type' => 'structure', 'members' => [ 'Speaker' => [ 'shape' => 'Speaker', ], ], ], 'OutputDataConfig' => [ 'type' => 'structure', 'required' => [ 'S3Uri', ], 'members' => [ 'KmsKeyId' => [ 'shape' => 'KmsKeyId', ], 'S3Uri' => [ 'shape' => 'S3Uri', ], ], ], 'RegistrationConfig' => [ 'type' => 'structure', 'members' => [ 'DuplicateRegistrationAction' => [ 'shape' => 'DuplicateRegistrationAction', ], 'FraudsterSimilarityThreshold' => [ 'shape' => 'Score', ], ], ], 'ResourceNotFoundException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], 'ResourceType' => [ 'shape' => 'ResourceType', ], ], 'exception' => true, ], 'ResourceType' => [ 'type' => 'string', 'enum' => [ 'BATCH_JOB', 'COMPLIANCE_CONSENT', 'DOMAIN', 'FRAUDSTER', 'SESSION', 'SPEAKER', ], ], 'S3Uri' => [ 'type' => 'string', 'max' => 1024, 'min' => 0, 'pattern' => '^s3://[a-z0-9][\\.\\-a-z0-9]{1,61}[a-z0-9](/.*)?$', ], 'Score' => [ 'type' => 'integer', 'box' => true, 'max' => 100, 'min' => 0, ], 'ServerSideEncryptionConfiguration' => [ 'type' => 'structure', 'required' => [ 'KmsKeyId', ], 'members' => [ 'KmsKeyId' => [ 'shape' => 'KmsKeyId', ], ], ], 'ServerSideEncryptionUpdateDetails' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], 'OldKmsKeyId' => [ 'shape' => 'KmsKeyId', ], 'UpdateStatus' => [ 'shape' => 'ServerSideEncryptionUpdateStatus', ], ], ], 'ServerSideEncryptionUpdateStatus' => [ 'type' => 'string', 'enum' => [ 'IN_PROGRESS', 'COMPLETED', 'FAILED', ], ], 'ServiceQuotaExceededException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'exception' => true, ], 'SessionId' => [ 'type' => 'string', 'max' => 25, 'min' => 25, 'pattern' => '^id#[a-zA-Z0-9]{22}$', ], 'SessionName' => [ 'type' => 'string', 'max' => 36, 'min' => 1, 'pattern' => '^[a-zA-Z0-9][a-zA-Z0-9_-]*$', ], 'SessionNameOrId' => [ 'type' => 'string', 'max' => 36, 'min' => 1, 'pattern' => '^(id#[a-zA-Z0-9]{22}|[a-zA-Z0-9][a-zA-Z0-9_-]*)$', ], 'Speaker' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'CustomerSpeakerId' => [ 'shape' => 'CustomerSpeakerId', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'GeneratedSpeakerId' => [ 'shape' => 'GeneratedSpeakerId', ], 'LastAccessedAt' => [ 'shape' => 'Timestamp', ], 'Status' => [ 'shape' => 'SpeakerStatus', ], 'UpdatedAt' => [ 'shape' => 'Timestamp', ], ], ], 'SpeakerEnrollmentJob' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'DataAccessRoleArn' => [ 'shape' => 'IamRoleArn', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'EndedAt' => [ 'shape' => 'Timestamp', ], 'EnrollmentConfig' => [ 'shape' => 'EnrollmentConfig', ], 'FailureDetails' => [ 'shape' => 'FailureDetails', ], 'InputDataConfig' => [ 'shape' => 'InputDataConfig', ], 'JobId' => [ 'shape' => 'JobId', ], 'JobName' => [ 'shape' => 'JobName', ], 'JobProgress' => [ 'shape' => 'JobProgress', ], 'JobStatus' => [ 'shape' => 'SpeakerEnrollmentJobStatus', ], 'OutputDataConfig' => [ 'shape' => 'OutputDataConfig', ], ], ], 'SpeakerEnrollmentJobStatus' => [ 'type' => 'string', 'enum' => [ 'SUBMITTED', 'IN_PROGRESS', 'COMPLETED', 'COMPLETED_WITH_ERRORS', 'FAILED', ], ], 'SpeakerEnrollmentJobSummaries' => [ 'type' => 'list', 'member' => [ 'shape' => 'SpeakerEnrollmentJobSummary', ], ], 'SpeakerEnrollmentJobSummary' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'EndedAt' => [ 'shape' => 'Timestamp', ], 'FailureDetails' => [ 'shape' => 'FailureDetails', ], 'JobId' => [ 'shape' => 'JobId', ], 'JobName' => [ 'shape' => 'JobName', ], 'JobProgress' => [ 'shape' => 'JobProgress', ], 'JobStatus' => [ 'shape' => 'SpeakerEnrollmentJobStatus', ], ], ], 'SpeakerId' => [ 'type' => 'string', 'max' => 256, 'min' => 1, 'pattern' => '^(id#[a-zA-Z0-9]{22}|[a-zA-Z0-9][a-zA-Z0-9_-]*)$', 'sensitive' => true, ], 'SpeakerStatus' => [ 'type' => 'string', 'enum' => [ 'ENROLLED', 'EXPIRED', 'OPTED_OUT', 'PENDING', ], ], 'SpeakerSummaries' => [ 'type' => 'list', 'member' => [ 'shape' => 'SpeakerSummary', ], ], 'SpeakerSummary' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'Timestamp', ], 'CustomerSpeakerId' => [ 'shape' => 'CustomerSpeakerId', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'GeneratedSpeakerId' => [ 'shape' => 'GeneratedSpeakerId', ], 'LastAccessedAt' => [ 'shape' => 'Timestamp', ], 'Status' => [ 'shape' => 'SpeakerStatus', ], 'UpdatedAt' => [ 'shape' => 'Timestamp', ], ], ], 'StartFraudsterRegistrationJobRequest' => [ 'type' => 'structure', 'required' => [ 'DataAccessRoleArn', 'DomainId', 'InputDataConfig', 'OutputDataConfig', ], 'members' => [ 'ClientToken' => [ 'shape' => 'ClientTokenString', 'idempotencyToken' => true, ], 'DataAccessRoleArn' => [ 'shape' => 'IamRoleArn', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'InputDataConfig' => [ 'shape' => 'InputDataConfig', ], 'JobName' => [ 'shape' => 'JobName', ], 'OutputDataConfig' => [ 'shape' => 'OutputDataConfig', ], 'RegistrationConfig' => [ 'shape' => 'RegistrationConfig', ], ], ], 'StartFraudsterRegistrationJobResponse' => [ 'type' => 'structure', 'members' => [ 'Job' => [ 'shape' => 'FraudsterRegistrationJob', ], ], ], 'StartSpeakerEnrollmentJobRequest' => [ 'type' => 'structure', 'required' => [ 'DataAccessRoleArn', 'DomainId', 'InputDataConfig', 'OutputDataConfig', ], 'members' => [ 'ClientToken' => [ 'shape' => 'ClientTokenString', 'idempotencyToken' => true, ], 'DataAccessRoleArn' => [ 'shape' => 'IamRoleArn', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'EnrollmentConfig' => [ 'shape' => 'EnrollmentConfig', ], 'InputDataConfig' => [ 'shape' => 'InputDataConfig', ], 'JobName' => [ 'shape' => 'JobName', ], 'OutputDataConfig' => [ 'shape' => 'OutputDataConfig', ], ], ], 'StartSpeakerEnrollmentJobResponse' => [ 'type' => 'structure', 'members' => [ 'Job' => [ 'shape' => 'SpeakerEnrollmentJob', ], ], ], 'StreamingStatus' => [ 'type' => 'string', 'enum' => [ 'PENDING_CONFIGURATION', 'ONGOING', 'ENDED', ], ], 'String' => [ 'type' => 'string', 'min' => 1, ], 'Tag' => [ 'type' => 'structure', 'required' => [ 'Key', 'Value', ], 'members' => [ 'Key' => [ 'shape' => 'TagKey', ], 'Value' => [ 'shape' => 'TagValue', ], ], ], 'TagKey' => [ 'type' => 'string', 'max' => 128, 'min' => 1, 'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$', 'sensitive' => true, ], 'TagKeyList' => [ 'type' => 'list', 'member' => [ 'shape' => 'TagKey', ], 'max' => 200, 'min' => 0, ], 'TagList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Tag', ], 'max' => 200, 'min' => 0, ], 'TagResourceRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', 'Tags', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'AmazonResourceName', ], 'Tags' => [ 'shape' => 'TagList', ], ], ], 'TagResourceResponse' => [ 'type' => 'structure', 'members' => [], ], 'TagValue' => [ 'type' => 'string', 'max' => 256, 'min' => 0, 'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$', 'sensitive' => true, ], 'ThrottlingException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'exception' => true, ], 'Timestamp' => [ 'type' => 'timestamp', ], 'UniqueIdLarge' => [ 'type' => 'string', 'max' => 22, 'min' => 22, 'pattern' => '^[a-zA-Z0-9]{22}$', ], 'UntagResourceRequest' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', 'TagKeys', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'AmazonResourceName', ], 'TagKeys' => [ 'shape' => 'TagKeyList', ], ], ], 'UntagResourceResponse' => [ 'type' => 'structure', 'members' => [], ], 'UpdateDomainRequest' => [ 'type' => 'structure', 'required' => [ 'DomainId', 'Name', 'ServerSideEncryptionConfiguration', ], 'members' => [ 'Description' => [ 'shape' => 'Description', ], 'DomainId' => [ 'shape' => 'DomainId', ], 'Name' => [ 'shape' => 'DomainName', ], 'ServerSideEncryptionConfiguration' => [ 'shape' => 'ServerSideEncryptionConfiguration', ], ], ], 'UpdateDomainResponse' => [ 'type' => 'structure', 'members' => [ 'Domain' => [ 'shape' => 'Domain', ], ], ], 'ValidationException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'exception' => true, ], ],];
