<?php

/**
 * use句をソースコードに自動配置する
 * @param $sourceCode
 * @param $useClass
 * @return string
 */
function auto_use($sourceCode, $useClass)
{
	$skipTokens = array(T_OPEN_TAG, T_DOC_COMMENT, T_COMMENT, T_WHITESPACE);
	$code = '';
	$tokens = token_get_all($sourceCode);
	$isUsed = false;
	$skippingToEOL = false;
	$foundUse = false;

	foreach ( $tokens as $index => $token ) {

		// 行末まで移動中ステートで行末に到達したら、フラグを倒す
		if ( $skippingToEOL and $token === ';' ) {
			$skippingToEOL = false;
		}

		if ( is_array($token) ) {
			// namespace に出くわしたら、行末まで一気に進む
			if ( $token[0] === T_NAMESPACE ) {
				$skippingToEOL = true;
			}

			// use に出くわしたら、行末まで一気に進む
			if ( $token[0] === T_USE ) {
				$skippingToEOL = true;
				$foundUse = true;
			}

			// 最初の関数などに出くわしたら
			if ( in_array($token[0], $skipTokens) === false ) {
				if ( $isUsed === false and $skippingToEOL === false ) {
					if ( $foundUse ){
						$code = rtrim($code, "\r\n")."\n";
					}

					$code .= sprintf("use %s;\n\n", $useClass);
					$isUsed = true;
				}
			}
		}

		$code .= is_array($token) ? $token[1] : $token;
	}

	return $code;
}
