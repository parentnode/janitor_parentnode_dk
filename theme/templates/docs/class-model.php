<div class="scene docpage i:docpage">
	<h1>Model</h1>
	<p>The Core Janitor Model is inherited by all itemtypes and classes with an associated model.</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Model::getPostedEntities">
				<div class="header">
					<h3>Model::getPostedEntities</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::getPostedEntities</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Model::getPostedEntities();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Get posted values for all entities in the model of the class the method is invoked on.
						</p>
						<p>
							This method will look in the $_POST array for any entities of it's model, and map values
							to the model entity value property.
						</p>
						<p>
							When getting posted values with this method, you are sure to get any value posted, in
							a sanitized format. The values will also be available for built in validation.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>
						<p>None</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Void</span> The method populates the model entities but does not return anything.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$model->addToModel("name", ["type" => "string"]);
$_POST["name"] = "Test name";
$model->getPostedEntities();
print $model->getProperty("name", "value");</code>
							<p>Outputs <span class="value">Test Name</span></p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>if...else</li>
								<li>foreach</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>getPostPassword</li>
								<li>getPost</li>
								<li>Model::getProperty</li>
								<li>Model::setProperty</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
