<p>Example of text from the view file</p>

<h3>Installation:</h3>

<p>If you install this on a root level domain it shouldn't be any problems, and <em>it should work out the box...</em></p>

<p>If you want install on a subfolder, there are some things you should do:</p>

<ul>
  <li>
    <p>Modify the .htaccess file on the root folder, the <code>RewriteBase</code> line, it should be:</p>
    <pre><code>
RewriteBase /path/of/installation/
    </code></pre>
  </li>
  <li>
    <p>On the <code>application/conf/development_config.php</code> file, write the path on the <code>$config['install_route']</code> variable:</p>
    <pre><code>
$config['install_route'] = '/path/of/installation';
    </code></pre>
  </li>
</ul>
