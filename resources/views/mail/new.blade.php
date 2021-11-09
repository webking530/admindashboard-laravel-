<!DOCTYPE html>
<html
  lang="en"
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office"
>
  <head>
    <meta charset="utf-8" />
    <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width" />
    <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting" />
    <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title>
    <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link
      href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700"
      rel="stylesheet"
    />

    <!-- CSS Reset : BEGIN -->
    <style>
      /* What it does: Remove spaces around the email design added by some email clients. */
      /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
      html,
      body {
        margin: 0 auto !important;
        padding: 0 !important;
        height: 100% !important;
        width: 100% !important;
        background: #f1f1f1;
      }

      /* What it does: Stops email clients resizing small text. */
      * {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
      }

      /* What it does: Centers email on Android 4.4 */
      div[style*="margin: 16px 0"] {
        margin: 0 !important;
      }

      /* What it does: Fixes webkit padding issue. */
      table {
        border-spacing: 0 !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
        margin: 0 auto !important;
      }

      /* What it does: Uses a better rendering method when resizing images in IE. */
      img {
        -ms-interpolation-mode: bicubic;
      }

      /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
      a {
        text-decoration: none;
      }

      /* What it does: A work-around for email clients meddling in triggered links. */
      *[x-apple-data-detectors],  /* iOS */
			.unstyle-auto-detected-links *,
			.aBn {
        border-bottom: 0 !important;
        cursor: default !important;
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
      }

      /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
      .a6S {
        display: none !important;
        opacity: 0.01 !important;
      }

      /* What it does: Prevents Gmail from changing the text color in conversation threads. */
      .im {
        color: inherit !important;
      }

      /* If the above doesn't work, add a .g-img class to any image in question. */
      img.g-img + div {
        display: none !important;
      }

      /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
      /* Create one of these media queries for each additional viewport size you'd like to fix */

      /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
      @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
        u ~ div .email-container {
          min-width: 320px !important;
        }
      }
      /* iPhone 6, 6S, 7, 8, and X */
      @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
        u ~ div .email-container {
          min-width: 375px !important;
        }
      }
      /* iPhone 6+, 7+, and 8+ */
      @media only screen and (min-device-width: 414px) {
        u ~ div .email-container {
          min-width: 414px !important;
        }
      }
			.d-flex {
				display: flex;
			}
			.justify-content-center {
				justify-content: center;
			}
			.align-items-center {				
				align-items: center;				
			}
			.text-center {
				text-align: center;
			}
    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>
      .primary {
        background: #f1c638;
      }
      .bg_white {
        background: #ffffff;
      }
      .bg_light {
        background: #fafafa;
      }
      .bg_black {
        background: #000000;
      }
      .bg_dark {
        background: rgba(0, 0, 0, 0.8);
      }
      .email-section {
        padding: 2.5em;
      }

      /*BUTTON*/
      .btn {
        padding: 5px 15px;
        display: inline-block;
      }
      .btn.btn-primary {
        border-radius: 5px;
        background: #f1c638;
        color: #000;
      }
      .btn.btn-white {
        border-radius: 5px;
        background: #ffffff;
        color: #000000;
      }
      .btn.btn-white-outline {
        border-radius: 5px;
        background: transparent;
        border: 1px solid #fff;
        color: #fff;
      }
      .btn.btn-black {
        border-radius: 5px;
        background: #000;
        color: #fff;
      }

      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        font-family: "Nunito Sans", sans-serif;
        color: #000000;
        margin-top: 0;
      }

      body {
        font-family: "Nunito Sans", sans-serif;
        font-weight: 400;
        font-size: 15px;
        line-height: 1.8;
        color: rgba(0, 0, 0, 0.4);
      }

      a {
        color: #f1c638;
      }

      /*LOGO*/

      .logo h1 {
        margin: 0;
      }
      .logo h1 a {
        color: #000000;
        font-size: 20px;
        font-weight: 700;
        font-family: "Nunito Sans", sans-serif;
      }

      .navigation {
        padding: 0;
      }
      .navigation li {
        list-style: none;
        display: inline-block;
        margin-left: 5px;
        font-size: 13px;
        font-weight: 500;
      }
      .navigation li a {
        color: rgba(0, 0, 0, 0.4);
      }

      /*HERO*/
      .hero {
        position: relative;
        z-index: 0;
      }
      .hero .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        content: "";
        width: 100%;
        background: #000000;
        z-index: -1;
        opacity: 0.3;
      }
      .hero .icon a {
        display: block;
        width: 60px;
        margin: 0 auto;
      }
      .hero .text {
        color: rgba(0, 0, 0, 0.8);
      }
      .hero .text h2 {
        color: #000;
        font-size: 32px;
        margin-bottom: 0;
        font-weight: 200;
        line-height: 1.4;
      }

      /*HEADING SECTION*/
      .heading-section h3 {
        color: #000000;
        font-size: 28px;
        margin-top: 0;
        line-height: 1.4;
        font-weight: 400;
      }
      .heading-section .subheading {
        margin-bottom: 20px !important;
        display: inline-block;
        letter-spacing: 2px;
        color: rgba(0, 0, 0, 0.4);
        position: relative;
      }
      .heading-section .subheading::after {
        position: absolute;
        left: 0;
        right: 0;
        bottom: -10px;
        content: "";
        width: 100%;
        height: 2px;
        background: #f1c638;
        margin: 0 auto;
      }

      .heading-section-white {
        color: rgba(255, 255, 255, 0.8);
      }
      .heading-section-white h2 {
        font-family: "Nunito Sans", sans-serif;
        line-height: 1;
        padding-bottom: 0;
      }
      .heading-section-white h2 {
        color: #ffffff;
      }
      .heading-section-white .subheading {
        margin-bottom: 0;
        display: inline-block;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255, 255, 255, 0.4);
      }

      .icon {
        text-align: center;
      }

      /*SERVICES*/
      .text-services {
        padding: 10px 10px 0;
        text-align: center;
      }
      .text-services h3 {
        font-size: 18px;
        font-weight: 400;
      }

      .services-list {
        padding: 0;
        margin: 0 0 20px 0;
        width: 100%;
        float: left;
      }

      .services-list img {
        float: left;
      }
      .services-list .text {
        width: calc(100% - 60px);
        float: right;
      }
      .services-list h3 {
        margin-top: 0;
        margin-bottom: 0;
      }
      .services-list p {
        margin: 0;
      }

      /*PROJECT*/
      .project-entry {
        position: relative;
      }
      .text-project {
        padding-top: 10px;
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
      }
      .text-project h3 {
        margin-bottom: 0;
        font-size: 16px;
        font-weight: 600;
      }
      .text-project h3 a {
        color: #fff;
      }
      .text-project span {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.8);
      }

      /*PRICING*/
      .pricing {
        position: relative;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border: 1px solid #f1c638;
        padding: 2em 1em;
        /*rgba(0,0,0,.05;)*/
      }
      .pricing h3 {
        font-weight: 400;
        margin-bottom: 10px;
      }
      .pricing h2 {
        font-size: 50px;
        font-weight: 400;
        margin-bottom: 0;
        margin-top: 0;
        line-height: 1.4;
      }
      .pricing .start {
        padding: 0;
        font-weight: 600;
        margin-bottom: 0;
      }
      .pricing h2 small {
        font-size: 18px;
      }
      .pricing ul {
        padding: 0;
        margin: 20px 0 0 0;
      }
      .pricing ul li {
        list-style: none;
        margin-bottom: 10px;
      }

      /*BLOG*/
      .text-services {
        padding: 10px;
      }
      .text-services .meta {
        text-transform: uppercase;
        font-size: 14px;
        margin-top: 0;
      }
      .text-services h3 {
        margin-top: 0;
        margin-bottom: 0;
        line-height: 1.2;
        font-size: 20px;
      }
      .text-services p {
        margin-top: 0;
      }

      /*TESTIMONY*/
      .text-testimony .name {
        margin: 0;
      }
      .text-testimony .position {
        color: rgba(0, 0, 0, 0.3);
      }

      /*VIDEO*/
      .img {
        width: 100%;
        height: auto;
        position: relative;
      }
      .img .icon {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        bottom: 0;
        margin-top: -25px;
      }
      .img .icon a {
        display: block;
        width: 60px;
        position: absolute;
        top: 0;
        left: 50%;
        margin-left: -25px;
      }

      /*COUNTER*/
      .counter {
        width: 100%;
        position: relative;
        z-index: 0;
      }
      .counter .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        content: "";
        width: 100%;
        background: #000000;
        z-index: -1;
        opacity: 0.3;
      }
      .counter-text {
        text-align: center;
      }
      .counter-text .num {
        display: block;
        color: #000;
        font-size: 34px;
        font-weight: 400;
      }
      .counter-text .name {
        display: block;
        color: rgba(0, 0, 0, 0.9);
        font-size: 14px;
      }

      ul.social {
        padding: 20px 0 0 0;
      }
      ul.social li {
        display: inline-block;
        margin-right: 10px;
      }
      /*FOOTER*/

      .footer {
        color: rgba(255, 255, 255, 0.5);
      }
      .footer .heading {
        color: #ffffff;
        font-size: 20px;
      }
      .footer ul {
        margin: 0;
        padding: 0;
      }
      .footer ul li {
        list-style: none;
        margin-bottom: 10px;
      }
      .footer ul li a {
        color: rgba(255, 255, 255, 1);
      }
			.footer .company td {
				padding-bottom: 10px;
			}
			.footer .info p {
				font-size: 14px; margin: 0;
			}

      @media screen and (max-width: 500px) {
        .icon {
          text-align: left;
        }

        .text-services {
          padding-left: 0;
          padding-right: 20px;
          text-align: left;
        }
      }
    </style>
  </head>

  <body
    width="100%"
    style="margin: 0; padding: 0 !important; background-color: #222222;"
  >
    <center style="width: 100%; background-color: #f1f1f1;">
      <div
        style="
          display: none;
          font-size: 1px;
          max-height: 0px;
          max-width: 0px;
          opacity: 0;
          overflow: hidden;
          font-family: sans-serif;
        "
      >
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
      </div>
      <div style="max-width: 600px; margin: 0 auto;" class="email-container">
        <!-- BEGIN BODY -->
        <table
          align="center"
          role="presentation"
          cellspacing="0"
          cellpadding="0"
          border="0"
          width="100%"
          style="margin: auto;"
        >
          <tr>
            <td valign="top" class="bg_white" style="padding: .75em 2.5em;">
              <table
                role="presentation"
                border="0"
                cellpadding="0"
                cellspacing="0"
                width="100%"
              >
                <tr>
									<td width="12%" class="logo" style="text-align: left;">
										<img src="{{ $message->embed('http://admin.teccharm.com/images/logo-icon.png')}}"  alt="Company Logo" />
                  </td>
									<td width="40%" class="logo" style="text-align: left;">										
                    <h1 class="d-flex align-items-center">
											<a href="#">Company Name</a>
										</h1>
                  </td>
                  <td width="40%" class="logo" style="text-align: right;"></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td class="primary email-section" style="width: 100%;">
              <table
                role="presentation"
                border="0"
                cellpadding="0"
                cellspacing="0"
                width="100%"
              >
                <tr>
                  <td valign="middle" width="50%">
										<img
											src="{{ $message->embed($data['code']) }}"
											alt="code"
											style="
												width: 100%;
												width: auto;
												height: auto;
												margin: auto;
												display: block;
											"
										/>
                  </td>
                  <td valign="middle" width="50%">
                    <table
                      role="presentation"
                      cellspacing="0"
                      cellpadding="0"
                      width="100%"
                    >
                      <tr>
                        <td
                          class="text-services"
                          style="text-align: left; padding-left: 25px;"
                        >
                          <div class="heading-section">
                            <h3>Site Name</h3>
                            <p class="subheading">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Site Address</p>
                          </div>
                          <div class="heading-section">
                            <h3>Sent Datetime</h3>
                            <p class="subheading">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['sent_time'] }}</p>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table
          align="center"
          role="presentation"
          cellspacing="0"
          cellpadding="0"
          border="0"
          width="100%"
          style="margin: auto;"
				>
          <tr>
            <td valign="middle" class="bg_black footer email-section">
              <table
                role="presentation"
                cellspacing="0"
                cellpadding="0"
                border="0"
                width="100%"
                style="margin: auto;"
              >
								<tr class="company">
									<td class="text-center" colspan="2">
										&copy;2020 <a href="https://teccharm.com" class="font-bold text-info">"Company"</a> | company address
									</td>
								</tr>
                <tr class="info">
                  <td width="50%" class="text-center">
                    <p>
											<strong>Phone number</strong> | <small>123456789012</small>
                    </p>
                  </td>
                  <td width="50%" class="text-center" rowspan="3">
                    <ul class="social">
                      <li>
												<a class="javascript:;">
													<img
                          	src="{{ $message->embed('http://admin.teccharm.com/images/000-twitter-logo.png') }}"
														alt="twitter"
														style="
															width: 24px;
															max-width: 600px;
															height: auto;
															display: block;
														"
													/>
												</a>
                      </li>
                      <li>
												<a class="javascript:;">
													<img
                          	src="{{ $message->embed('http://admin.teccharm.com/images/000-facebook-logo.png') }}"
														alt="facebook"
														style="
															width: 24px;
															max-width: 600px;
															height: auto;
															display: block;
														"
													/>
												</a>
                      </li>
                      </li>
                      <li>
												<a class="javascript:;">
													<img
                          	src="{{ $message->embed('http://admin.teccharm.com/images/000-instagram-logo.png') }}"
														alt="instagram"
														style="
															width: 24px;
															max-width: 600px;
															height: auto;
															display: block;
														"
													/>
												</a>
                      </li>
                      <li>
												<a class="javascript:;">
													<img
                          	src="{{ $message->embed('http://admin.teccharm.com/images/000-linkedin-logo.png') }}"
														alt="linkedin"
														style="
															width: 24px;
															max-width: 600px;
															height: auto;
															display: block;
														"
													/>
												</a>
                      </li>
                    </ul>										
                  </td>
                </tr>
                <tr class="info">
                  <td width="50%" class="text-center">
                    <p>
											<strong>Tax number</strong> | <small>123456789012</small>
                    </p>
                  </td>
                </tr>
                <tr class="info">
                  <td width="50%" class="text-center">
                    <p>
											<strong>Fax number</strong> | <small>123456789012</small>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </center>
  </body>
</html>
