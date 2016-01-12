<div class="scene docpage i:docpage">
	<h1>Zipper</h1>
	<p>
		The Zipper class simplifies file compression with Zip.
		This class can be included using:
	</p>
	<code>@include_once("classes/system/zipper.class.php");</code>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Zipper::zip">
				<div class="header">
					<h3>Zipper::zip</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">zip</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Zipper::zip(
									<span class="type">Array</span> <span class="var">$files</span>
									, <span class="type">String</span> <span class="var">$dest</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Add all files in <span class="var">$files</span> array to zip-archive at 
							<span class="var">$dest</span>. Can automatically delete <span class="var">$files</span>
							when successfully added to archive.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$files</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of files to add to archive
								</div>
							</dd>
							<dt><span class="var">$dest</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path where zip-archive should be created (or already exists)
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional options for zip procedure
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">delete</span></dt>
										<dd>Delete files after successfully adding them to archive. Default <span class="value">false</span>.</dd>
										<dt><span class="value">paths</span></dt>
										<dd>
											Remove filepaths (or parts of it) when adding files to archive. Set to 
											<span class="value">true</span> to remove entire path, or specify fragment 
											which should be removed. Default <span class="value">true</span>.
										</dd>
										<dt><span class="value">flag</span></dt>
										<dd>Flag for PHP ZipArchive</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> on success, <span class="value">false</span> on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$Zipper = new Zipper();
$files = array("/path/file-1.txt", "/path/file-2.txt", "/path/file-3.txt");
$Zipper->zip($files, "/path/file-1-3.zip");</code>
							<p>Creates Zip-archive <span class="value">/path/file-1-3.zip</span> containing the three listed files.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>ZipArchive</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>FileSystem</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
