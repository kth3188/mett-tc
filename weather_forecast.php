<?php
// 단기예보 조회를 위한 기본 변수 설정
$serviceKey = "cPdGKAsUpOaVmBWNujf8zCL0q%2BXyzMSMGebwv4%2FLt%2BMJZCz8lOidIVcww3rhbqJ%2FyO8OLyRi0QJY%2FimdYx7zSg%3D%3D"; // Encoding 키 사용
$dataType = "JSON"; // 응답 데이터 타입(JSON 또는 XML)
$numOfRows = 10; // 결과 수 (최대 10개)
$pageNo = 1;
$base_date = date("Ymd"); // 현재 날짜로 설정
$base_time = "0500"; // 예보 기준 시간 설정 (예: 05시 정각)
$nx = 55; // 예보 지점의 X 좌표 (예: 서울)
$ny = 127; // 예보 지점의 Y 좌표 (예: 서울)

// API URL 생성
$url = "http://apis.data.go.kr/1360000/VilageFcstInfoService_2.0/getVilageFcst";
$url .= "?serviceKey={$serviceKey}";
$url .= "&numOfRows={$numOfRows}";
$url .= "&pageNo={$pageNo}";
$url .= "&dataType={$dataType}";
$url .= "&base_date={$base_date}";
$url .= "&base_time={$base_time}";
$url .= "&nx={$nx}";
$url .= "&ny={$ny}";

// cURL을 사용하여 API 요청 보내기
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// 응답 처리
if ($response) {
    $data = json_decode($response, true);
    if ($data['response']['header']['resultCode'] == "00") {
        $items = $data['response']['body']['items']['item'];
        foreach ($items as $item) {
            echo "예보 날짜: " . $item['fcstDate'] . "<br>";
            echo "예보 시간: " . $item['fcstTime'] . "<br>";
            echo "자료 구분: " . $item['category'] . "<br>";
            echo "예보 값: " . $item['fcstValue'] . "<br><br>";
        }
    } else {
        echo "API 오류: " . $data['response']['header']['resultMsg'];
    }
} else {
    echo "API 요청 실패";
}
?>
