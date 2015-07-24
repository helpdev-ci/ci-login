function login($username, $password) {
	$sql = "SELECT
		users.user_id,
		users.common_name,
		users.department,
		users.username,
		users.add_time,
		users.flag
	FROM
		users
	WHERE
		users.username = '".$username."' 
		AND users.`password` = '".$password."'
		AND flag IN(0,1)";
}

function user_grant($user_id) {
	$sql = "SELECT
		user_policy.policy_id,
		user_policy.policy_name,
		user_policy.creation_time,
		user_policy.edited_time,
		user_policy.flag
	FROM
		user_grant
		INNER JOIN user_policy ON user_grant.policy_id = user_policy.policy_id
	WHERE
		user_grant.user_id = " . $user_id;
}

function grant_access($user_id, $policy_name) {
	$sql = "SELECT
		user_policy.policy_id,
		user_policy.policy_name,
		user_policy.creation_time,
		user_policy.edited_time,
		user_policy.flag
	FROM
		user_grant
		INNER JOIN user_policy ON user_grant.policy_id = user_policy.policy_id
	WHERE
		user_grant.user_id = " . $user_id ."
		AND user_policy.policy_name = 'AdministratorAccess' ";
}
