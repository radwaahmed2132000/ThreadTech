<?php

namespace App\Http\Misc\Helpers;

class Errors
{
    // auth errors
    const COMPLETED_PROFILE_BEFORE = 'you have completed your profile before.';
    const COMPLETED_PROFILE_MUST = 'you must complete your profile.';
	const NOT_FOUND_USER  = 'There is no account associated with this email.';
    const WRONG_PASSWORD  = 'Invalid login, wrong email or password.';
    const NOT_VERIFIED_USER = 'Non Verified User.';
    const NO_FOLLOW = 'you cannot unfollow a non followed user.';

    //records errors
    const EXISTS="Record already exists!";
    const NOT_EXISTS="Record not exists!";

	// general errors
	const TESTING  = 'Invalid parameter.';
	const UNAUTHENTICATED  = 'Unauthenticated.';
	const UNAUTHORIZED = 'Unauthorized.';
	const GENERAL = "General error ,try again later!";

    //coupon errors
    const PRODUCT_NOT_EXISTS = "This product is not supported in the coupon offer";
    const COUPON_USED = "You have used this coupon before";

}
