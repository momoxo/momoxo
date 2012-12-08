<?php

/**
 * use句をソースコードに自動配置する
 * @param $sourceCode
 * @param $oldClass
 * @param $useClass
 * @return string
 */
function auto_use($sourceCode, $oldClass, $useClass)
{
	$skipTokens = array(T_OPEN_TAG, T_DOC_COMMENT, T_COMMENT, T_WHITESPACE);
	$code = '';
	$tokens = token_get_all($sourceCode);

	$className = null;

	// 変えようとしているクラスのクラス名を調べる
	foreach ( $tokens as $index => $token ) {
		if ( is_array($token) and $token[0] === T_CLASS ) {
			while ( isset($tokens[$index]) ) {
				if ( $tokens[$index][0] === T_STRING ) {
					$className = $tokens[$index][1];
					break;
				}
				$index += 1;
			}
		}
	}

	// 自分自身の場合は use しない
	if ( $className == $oldClass ) {
		return $sourceCode;
	}

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
				$skipTokens = array_diff($skipTokens, array(T_COMMENT, T_DOC_COMMENT)); // ドックコメントなどの前で use するため。
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
