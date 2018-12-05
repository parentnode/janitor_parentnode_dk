<div class="scene docpage i:docpage i:scene">
	<h1>FileSystem</h1>
	<p>
		The FileSystem class provides general file system helper functions.
	</p>
	<p>
		This class is included as default.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="FileSystem::files">
				<div class="header">
					<h3>FileSystem::files</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">files</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								FileSystem::files(
									<span class="type">String</span> <span class="var">$path</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Returns array of files matching the optional criteria specified in <span class="var">$_options</span>
							located at <span class="var">$path</span> or subfolder of <span class="var">$path</span>.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$path</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path to look for files
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional options for file matching
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">deny_folders</span></dt>
										<dd>Exclude files in comma separated list of folders.</dd>
										<dt><span class="value">allow_folders</span></dt>
										<dd>Only include files in comma separated list of folders.</dd>
										<dt><span class="value">deny_extensions</span></dt>
										<dd>Exclude file extensions in comma separated list of extensions.</dd>
										<dt><span class="value">allow_extensions</span></dt>
										<dd>Only include file extensions in comma separated list of extensions.</dd>
										<dt><span class="value">include_tempfiles</span></dt>
										<dd>Include tempfiles. Default <span class="value">false</span>.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> array of matching files</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$fs = new FileSystem();
$files = $fs->files("/");</code>
							<p>Returns array of all files on system (excluding temp and system files).</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>file_exists</li>
								<li>opendir</li>
								<li>readdir</li>
								<li>closedir</li>
								<li>is_dir</li>
								<li>array_merge</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="FileSystem::valid">
				<div class="header">
					<h3>FileSystem::valid</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">files</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								FileSystem::valid(
									<span class="type">String</span> <span class="var">$file</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Checks if a given file is valid based on the given criteria. Tempfiles and folder references are not valid as default.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$file</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path of file to check validity of
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional options for file matching
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">deny_folders</span></dt>
										<dd>Exclude files in comma separated list of folders.</dd>
										<dt><span class="value">allow_folders</span></dt>
										<dd>Only allow files in comma separated list of folders.</dd>
										<dt><span class="value">deny_extensions</span></dt>
										<dd>Exclude file extensions in comma separated list of extensions.</dd>
										<dt><span class="value">allow_extensions</span></dt>
										<dd>Only allow file extensions in comma separated list of extensions.</dd>
										<dt><span class="value">include_tempfiles</span></dt>
										<dd>Allow tempfiles. Default <span class="value">false</span>.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> if file is valid, <span class="value">false</span> if not.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$fs = new FileSystem();
$files = $fs->valid("/file.txt", array("allow_extensions" => "txt"));</code>
							<p>Returns true, because file matches the allowed extensions.</p>
						</div>

						<div class="example">
							<code>$fs = new FileSystem();
$files = $fs->valid("/._tempfile");</code>
							<p>Returns false, because file is temp file (starting with ._).</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>basename</li>
								<li>preg_match</li>
								<li>array_intersect</li>
								<li>array_search</li>
								<li>explode</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="FileSystem::removeDirRecursively">
				<div class="header">
					<h3>FileSystem::removeDirRecursively</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">files</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								FileSystem::removeDirRecursively(
									<span class="type">String</span> <span class="var">$path</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Remove directory/folder and nested structure (and delete all files within it).
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$path</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path of directory to delete
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
							<code>$fs = new FileSystem();
$files = $fs->removeDirRecursively("/");</code>
							<p>Deletes your entire disk (don't do this).</p>
						</div>

					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>basename</li>
								<li>file_exists</li>
								<li>opendir</li>
								<li>is_file</li>
								<li>unlink</li>
								<li>is_dir</li>
								<li>closedir</li>
								<li>rmdir</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="FileSystem::removeEmptyDirRecursively">
				<div class="header">
					<h3>FileSystem::removeEmptyDirRecursively</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">files</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								FileSystem::removeEmptyDirRecursively(
									<span class="type">String</span> <span class="var">$path</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Remove directory/folder and nested structure only if it is empty. Can optionally ignore temp-files.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$path</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path of directory to delete
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional options for file matching
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">delete_tempfiles</span></dt>
										<dd>Delete tempfiles to empty directories. Default <span class="value">false</span>.</dd>
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
							<code>$fs = new FileSystem();
$files = $fs->removeEmptyDirRecursively("/");</code>
							<p>Returns false, because the path is not empty (no it isn't).</p>
						</div>

					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>basename</li>
								<li>file_exists</li>
								<li>opendir</li>
								<li>is_file</li>
								<li>unlink</li>
								<li>is_dir</li>
								<li>closedir</li>
								<li>rmdir</li>
								<li>preg_match</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="FileSystem::makeDirRecursively">
				<div class="header">
					<h3>FileSystem::makeDirRecursively</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">files</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								FileSystem::makeDirRecursively(
									<span class="type">String</span> <span class="var">$path</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Create full directory/folder path (creating any missing subfolders if needed).
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$path</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path to create in filesystem
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
							<code>$fs = new FileSystem();
$files = $fs->makeDirRecursively("/monkeys/fly");</code>
							<p>Creates <span class="value">/monkeys/fly</span> structure.</p>
						</div>

					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>file_exists</li>
								<li>explode</li>
								<li>count</li>
								<li>mkdir</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="FileSystem::copy">
				<div class="header">
					<h3>FileSystem::copy</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">files</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								FileSystem::copy(
									<span class="type">String</span> <span class="var">$path</span> 
									, <span class="type">String</span> <span class="var">$dest</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Copies directory/folder and all content to new destination. Creates destination path if needed.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$path</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path to copy
								</div>
							</dd>
							<dt><span class="var">$dest</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Destination to copy to
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
							<code>$fs = new FileSystem();
$files = $fs->copy("/hello", "/goodbye");</code>
							<p>Creates <span class="value">/goodbye</span> and copies content from <span class="value">/hello</span> into <span class="value">/goodbye</span>.</p>
						</div>

					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>is_dir</li>
								<li>scandir</li>
								<li>copy</li>
								<li>is_file</li>
								<li>dirname</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>


		</div>
	</div>

</div>
