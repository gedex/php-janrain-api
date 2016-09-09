<?php

namespace Janrain\Api;

class Errors
{
    /**
     * The supplied access_token has expired.
     */
    const ACCESS_TOKEN_EXPIRED = 414;

    /**
     * The API call was temporarily disabled for maintenance, and will be
     * available again shortly.
     */
    const API_FEATURE_DISABLED = 480;

    /**
     * The limit on total number of simultaneous API calls has been reached.
     */
    const API_LIMIT_ERROR = 510;

    /**
     * No application exists on this domain.
     */
    const APPLICATION_NOT_FOUND = 224;

    /**
     * Attempted to create an attribute that already exists.
     */
    const ATTRIBUTE_EXISTS = 233;

    /**
     * The supplied authorization_code has expired.
     */
    const AUTHORIZATION_CODE_EXPIRED = 415;

    /**
     * The client does not have permission to perform the action (that is, it
     * needs a feature).
     */
    const CLIENT_PERMISSION_ERROR = 403;

    /**
     * A constraint was violated.
     */
    const CONSTRAINT_VALIDATION = 360;

    /**
     * The supplied creation_token has expired.
     */
    const CREATION_TOKEN_EXPIRED = 417;

    /**
     * Two or more supplied arguments may not have been included in the same
     * call. For example, both id and uuid in entity.update.
     */
    const DUPLICATE_ARGUMENT = 201;

    /**
     * You are attempting to register a new user, but a user already exists with
     * that email address. Typically the next step when receiving this error is
     * to merge accounts.
     */
    const EMAIL_ADDRESS_IN_USE = 380;

    /**
     * Attempted to create an entity type that already exists.
     */
    const ENTITY_TYPE_EXISTS = 232;

    /**
     * There was an error while creating a new record.
     */
    const ERROR_CREATING_RECORD = 300;

    /**
     * The flow is misconfigured and needs to be updated.
     */
    const FLOW_ERROR = 226;

    /**
     * Attempted to specify a record ID in a new entity or plural element.
     */
    const ID_IN_NEW_RECORD = 320;

    /**
     * The argument was malformed, or its value was invalid for some other
     * reason.
     */
    const INVALID_ARGUMENT = 200;

    /**
     * The request used an http auth method other than Basic or OAuth.
     */
    const INVALID_AUTH_METHOD = 205;

    /**
     * The client ID does not exist or the client secret is wrong.
     */
    const INVALID_CLIENT_CREDENTIALS = 402;

    /**
     * The username/password combination supplied was incorrect.
     */
    const INVALID_CREDENTIALS = 210;

    /**
     * A JSON value was not formatted correctly according to the attribute type
     * in the schema.
     */
    const INVALID_DATA_FORMAT = 340;

    /**
     * A date or dateTime value was not valid, for example if it was not
     * formatted correctly or was out of range.
     */
    const INVALID_DATE_TIME = 342;

    /**
     * The data you submitted did not pass form validation. For example, an
     * invalid email address.
     */
    const INVALID_FORM_FIELDS = 390;

    /**
     * A value did not match the expected JSON type according to the schema.
     */
    const INVALID_JSON_TYPE = 341;

    /**
     * A string value violated an attribute’s length constraint.
     */
    const LENTH_VIOLATION = 363;

    /**
     * A required argument was not supplied.
     */
    const MISSING_ARGUMENT = 100;

    /**
     * An attribute with the required constraint was either missing or set to
     * null.
     */
    const MISSING_REQUIRED_ATTRIBUTE = 362;

    /**
     * The supplied authorization_code is not valid because the user’s access
     * grant has been deleted.
     */
    const NO_ACCESS_GRANT = 413;

    /**
     * An email/password combination was supplied, but the account is
     * Social Sign-in only.
     */
    const NO_PASSWORD = 211;

    /**
     * An email/password combination was supplied, but the email address
     * doesn’t exist.
     */
    const NO_SUCH_ACCOUNT = 212;

    /**
     * An email/password combination was supplied, and the email is valid, but
     * the password is wrong.
     */
    const PASSWORD_INCORRECT = 213;

    /**
     * Referred to an entity or plural element that does not exist.
     */
    const RECORD_NOT_FOUND = 310;

    /**
     * The redirectUri did not match. Occurs in the oauth/token API call with
     * the authorization_code grant type.
     */
    const REDIRECT_URI_MISMATCH = 420;

    /**
     * Attempted to modify a reserved attribute. This can occur if you try to
     * delete, rename, or write to a reserved attribute.
     */
    const RESERVED_ATTRIBUTE = 234;

    /**
     * The created or lastUpdated value does not match the supplied argument.
     */
    const TIMESTAMP_MISMATCH = 330;

    /**
     * An error was triggered in the flow.
     */
    const TRIGGERED_ERROR = 540;

    /**
     * An unexpected internal error.
     */
    const UNEXPECTED_ERROR = 500;

    /**
     * A unique or locally-unique constraint was violated.
     */
    const UNIQUE_VIOLATION = 361;

    /**
     * The application ID does not exist.
     */
    const UNKNOWN_APPLICATION = 221;

    /**
     * An attribute does not exist. This can occur when trying to create or
     * update a record, or when modifying an attribute.
     */
    const UNKNOWN_ATTRIBUTE = 223;

    /**
     * The entity type does not exist.
     */
    const UNKNOWN_ENTITY_TYPE = 222;

    /**
     * The supplied verification_code has expired.
     */
    const VERIFICATION_CODE_EXPIRED = 416;

    /**
     * Error message translation table.
     *
     * The list of codes is complete according to
     * https://docs.janrain.com/api/registration/error-codes#error-codes
     * (last updated 2016-09-08).
     *
     * @var array
     *
     * @see https://docs.janrain.com/api/registration/error-codes#error-codes
     */
    public static $messages = [
        100 => 'missing_argument',
        200 => 'invalid_argument',
        201 => 'duplicate_argument',
        205 => 'invalid_auth_method',
        210 => 'invalid_credentials',
        211 => 'no_password',
        212 => 'no_such_account',
        213 => 'password_incorrect',
        221 => 'unknown_application',
        222 => 'unknown_entity_type',
        223 => 'unknown_attribute',
        224 => 'application_not_found',
        226 => 'flow_error',
        232 => 'entity_type_exists',
        233 => 'attribute_exists',
        234 => 'reserved_attribute',
        300 => 'error_creating_record',
        310 => 'record_not_found',
        320 => 'id_in_new_record',
        330 => 'timestamp_mismatch',
        340 => 'invalid_data_format',
        341 => 'invalid_json_type',
        342 => 'invalid_date_time',
        360 => 'constraint_violation',
        361 => 'unique_violation',
        362 => 'missing_required_attribute',
        363 => 'length_violation',
        380 => 'email_address_in_use',
        390 => 'invalid_form_fields',
        402 => 'invalid_client_credentials',
        403 => 'client_permission_error',
        413 => 'no_access_grant',
        414 => 'access_token_expired',
        415 => 'authorization_code_expired',
        416 => 'verification_code_expired',
        417 => 'creation_token_expired',
        420 => 'redirect_uri_mismatch',
        480 => 'api_feature_disabled',
        500 => 'unexpected_error',
        510 => 'api_limit_error',
        540 => 'triggered_error'
    ];
}

