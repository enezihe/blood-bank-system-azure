<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Bank Ticker</title>
  <style>
    @media screen and (max-width: 80px) {
      .news {
        position: relative;
        margin: 400px auto 0;
      }

      .text1 {
        box-shadow: none !important;
        position: relative;
        margin: 0 auto;
      }
    }

    .blue {
      background: #347fd0;
    }

    .news {
      box-shadow: inset 0 -15px 30px rgba(10, 4, 60, 0.4), 0 5px 10px rgba(10, 20, 100, 0.5);
      width: 100%;
      height: 50px;
      margin-top: 0;
      overflow: hidden;
      border-radius: 4px;
      padding: 1px;
      user-select: none;
    }

    .news span {
      float: left;
      color: #fff;
      padding: 9px;
      position: relative;
      top: 1%;
      box-shadow: inset 0 -15px 30px rgba(0, 0, 0, 0.4);
      font: 16px 'Raleway', Helvetica, Arial, sans-serif;
      cursor: pointer;
    }

    .text1 {
      box-shadow: none !important;
      position: relative;
      width: 90%;
    }
  </style>
</head>
<body>

  <div class="news blue">
    <span style="background-color:#F60F0F; width:125px; height:50px;">Latest Updates</span>
    <span class="text1">
      <marquee>
        First blood donation camp to be organised in Hisar by Varun in collaboration with Blood Bank & Donor Management System on
        <b>01/09/2020 at Community Centre PLA.</b> Come and be a part of this noble cause :)
      </marquee>
    </span>
  </div>

</body>
</html>
