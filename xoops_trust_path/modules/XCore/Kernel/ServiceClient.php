<?php

namespace XCore\Kernel;

use XCore\Kernel\Root;
use XCore\Kernel\GenericRequest;
use XCore\Kernel\AbstractServiceClient;
use XCore\Kernel\Service;

/**
 * Interface to be used for accessing a Service.
 *
 * The client object for Service(Inner service). This class calls
 * functions directly, but exchanges the request object of the context to
 * enable the service logic to get values by the request object. After calls,
 * restores the original request object.
 */
class ServiceClient extends AbstractServiceClient
{
	/**
	 * @param $operation
	 * @param $params
	 * @return mixed|null|void
	 */
	public function call($operation, $params)
	{
		$this->mClientErrorStr = null;

		if ( !is_object($this->mService) ) {
			$this->mClientErrorStr = "This instance is not connected to service";

			return null;
		}

		$root = Root::getSingleton();
		$request_bak =& $root->mContext->mRequest;
		unset($root->mContext->mRequest);

		$root->mContext->mRequest = new GenericRequest($params);

		if ( isset($this->mService->_mFunctions[$operation]) ) {
			$ret = call_user_func(array($this->mService, $operation));

			unset($root->mContext->mRequest);
			$root->mContext->mRequest =& $request_bak;

			return $ret;
		} else {
			$this->mClientErrorStr = "operation ${operation} not present.";

			return null;
		}
	}
}

