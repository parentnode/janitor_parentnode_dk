<div class="scene docpage i:docpage">
	<h1>Mailer</h1>
	<p>Send out mails</p>	

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Mailer::send">
				<div class="header">
					<h3>Mailer::send</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Mailer::send</dd>
							<dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">mailer()->send()</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Object|false</span> = 
								Mailer::send(
									[<span class="type">Array|false</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Sends an email.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options </span></dt>
							
								<div class="summary">
									<span class="type">Array|False</span>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">subject (String)</span></dt>
										<dd>Email subject. If not passed, the subject will be derived from the html template or text template, if available. Falls back to 'Mail from #site URL#'.</dd>
										<dt><span class="value">message (String)</span></dt>
										<dd>Email content. This string will be merged into any <span class="var">{message}</span> placeholders of the html/text template. If no html or text template exists, the string will be used as the email's simple text message.</dd> 
										<dt><span class="value">template (String)</span></dt>
										<dd>Name of template to be used.</dd>
										<dt><span class="value">from_name (String)</span></dt>
										<dd>Name of sender. Falls back to #site name#.</dd>
										<dt><span class="value">from_email (String)</span></dt>
										<dd>Email of sender. Falls back to, first, #site email#, and, then, #admin email#.</dd>
										<dt><span class="value">from_current_user (Boolean)</span></dt>
										<dd>Will use current user's name and email as Sender information. If from_name and/or from_email is also send, they will take precedence.</dd>
										<dt><span class="value">reply_to (String)</span></dt>
										<dd>Custom reply-to email.</dd>
										<dt><span class="value">values (Array)</span></dt>
										<dd>Values that will be merged into the mail template.</dd>
										<dt><span class="value">recipients (Array|String)</span></dt>
										<dd>Array or comma-separated string of recipient email adresses.</dd>
										<dt><span class="value">Bcc_recipients (Array|String)</span></dt>
										<dd>Array or comma-separated string of CC email adresses.</dd>
										<dt><span class="value">bcc_recipients (Array|String)</span></dt>
										<dd>Array or comma-separated string of BCC email adresses.</dd>
										<dt><span class="value">attachments (String|Array)</span></dt>
										<dd>Path to attachment file, or array of paths to multiple attachments.</dd>
										<dt><span class="value">html (String)</span></dt>
										<dd>Specify a HTML template directly. If the <span class="var">template</span> option is also passed, it will take precedence.</dd>
										<dt><span class="value">text (String)</span></dt>
										<dd>Specify a text template directly. If the <span class="var">template</span> option is also passed, it will take precedence.</dd>
										<dt><span class="value">tracking (Boolean)</span></dt>
										<dd>Switch tracking on/off, if supported by mail service (currently only Mailgun).</dd>
										<dt><span class="value">track_clicks (Boolean)</span></dt>
										<dd>Switch clicks tracking on/off, if supported by mail service (currently only Mailgun).</dd>
										<dt><span class="value">track_opened (Boolean)</span></dt>
										<dd>Switch opens tracking on/off, if supported by mail service (currently only Mailgun).</dd>

									</dl>
								</div>
							
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Object|False</span> Object with id and message. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">

						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Mailer::init_adapter</li>
								<li>Mailer::getRecipients</li>
								<li>Mailer::getTemplate</li>
								<li>Mailer::getSender</li>
								<li>DOM::createDom</li>
								<li>DOM::getFormattedTextFromDOM</li>
							</ul>
						</div>

					</div>

				</div>
			</div>
			
			<div class="function" id="Mailer::sendBulk">
				<div class="header">
					<h3>Mailer::sendBulk</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Mailer::sendBulk</dd>
							<dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">mailer()->sendBulk()</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Object|false</span> = 
								Mailer::sendBulk(
									[<span class="type">Array|false</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Sends an email to several recipients, with custom values for each.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options </span></dt>
							
								<div class="summary">
									<span class="type">Array|False</span>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">subject (String)</span></dt>
										<dd>Email subject. If not passed, the subject will be derived from the html template or text template, if available. Falls back to 'Mail from #site URL#'.</dd>
										<dt><span class="value">message (String)</span></dt>
										<dd>Email content. This string will be merged into any <span class="var">{message}</span> placeholders of the html/text template. If no html or text template exists, the string will be used as the email's simple text message.</dd> 
										<dt><span class="value">template (String)</span></dt>
										<dd>Name of template to be used.</dd>
										<dt><span class="value">from_name (String)</span></dt>
										<dd>Name of sender. Falls back to #site name#.</dd>
										<dt><span class="value">from_email (String)</span></dt>
										<dd>Email of sender. Falls back to, first, #site email#, and, then, #admin email#.</dd>
										<dt><span class="value">from_current_user (Boolean)</span></dt>
										<dd>Will use current user's name and email as Sender information. If from_name and/or from_email is also send, they will take precedence.</dd>
										<dt><span class="value">reply_to (String)</span></dt>
										<dd>Custom reply-to email.</dd>
										<dt><span class="value">values (Array)</span></dt>
										<dd>Values that will be merged into the mail template. Each set of values is a subarray with the recipient email as key.</dd>
										<dt><span class="value">recipients (Array|String)</span></dt>
										<dd>Array or comma-separated string of recipient email adresses.</dd>
										<dt><span class="value">cc_recipients (Array|String)</span></dt>
										<dd>Array or comma-separated string of CC email adresses. The CC reicpient(s) will receive a copy of each email that was send to a recipient. Note: Currently disabled for Mailgun.</dd>
										<dt><span class="value">bcc_recipients (Array|String)</span></dt>
										<dd>Array or comma-separated string of BCC email adresses. The BCC reicpient(s) will receive a copy of each email that was send to a recipient. Note: Currently disabled for Mailgun.</dd>
										<dt><span class="value">attachments (String|Array)</span></dt>
										<dd>Path to attachment file, or array of paths to multiple attachments.</dd>
										<dt><span class="value">html (String)</span></dt>
										<dd>Specify a HTML template directly. If the <span class="var">template</span> option is also passed, it will take precedence.</dd>
										<dt><span class="value">text (String)</span></dt>
										<dd>Specify a text template directly. If the <span class="var">template</span> option is also passed, it will take precedence.</dd>
										<dt><span class="value">tracking (Boolean)</span></dt>
										<dd>Switch tracking on/off, if supported by mail service (currently only Mailgun).</dd>
										<dt><span class="value">track_clicks (Boolean)</span></dt>
										<dd>Switch clicks tracking on/off, if supported by mail service (currently only Mailgun).</dd>
										<dt><span class="value">track_opened (Boolean)</span></dt>
										<dd>Switch opens tracking on/off, if supported by mail service (currently only Mailgun).</dd>

									</dl>
								</div>
							
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Object|False</span> Object with id and message. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">

						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Mailer::init_adapter</li>
								<li>Mailer::getRecipients</li>
								<li>Mailer::getTemplate</li>
								<li>Mailer::getSender</li>
								<li>DOM::createDom</li>
								<li>DOM::getFormattedTextFromDOM</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
