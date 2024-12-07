package cl.inacap.neighborhoodcrimewatch;

import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class Registro extends AppCompatActivity {
    EditText usuario, password, confirmarPassword, nombres, apellidos, telefono; // Eliminamos estado
    Button btnRegistro;
    RequestQueue datos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro);

        // Inicializar los campos y el botón
        usuario = findViewById(R.id.etCorreo);
        password = findViewById(R.id.etPass);
        confirmarPassword = findViewById(R.id.etRepass);
        nombres = findViewById(R.id.etNombre);
        apellidos = findViewById(R.id.etApellido);
        telefono = findViewById(R.id.etNum);
        btnRegistro = findViewById(R.id.btnRegistro);

        // Inicializar RequestQueue
        datos = Volley.newRequestQueue(this);

        // Configurar el botón de registro
        btnRegistro.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                registrarUsuario();
            }
        });
    }

    @RequiresApi(api = Build.VERSION_CODES.GINGERBREAD)
    private void registrarUsuario() {
        String userInput = usuario.getText().toString().trim();
        String passwordInput = password.getText().toString().trim();
        String confirmarInput = confirmarPassword.getText().toString().trim();
        String nombresInput = nombres.getText().toString().trim();
        String apellidosInput = apellidos.getText().toString().trim();
        String telefonoInput = telefono.getText().toString().trim();

        // Validar que los campos no estén vacíos
        if (userInput.isEmpty() || passwordInput.isEmpty() || confirmarInput.isEmpty() || nombresInput.isEmpty() ||
                apellidosInput.isEmpty() || telefonoInput.isEmpty()) {
            Toast.makeText(Registro.this, "Por favor, complete todos los campos", Toast.LENGTH_SHORT).show();
            return;
        }

        // Validar que las contraseñas coincidan
        if (!passwordInput.equals(confirmarInput)) {
            Toast.makeText(Registro.this, "Las contraseñas no coinciden", Toast.LENGTH_SHORT).show();
            return;
        }

        // Aquí puedes agregar la lógica para enviar los datos al servidor
        String url = "http://54.173.43.72/registrarUsuario.php?usu=" + userInput +
                "&pass=" + passwordInput +
                "&nombres=" + nombresInput +
                "&apellidos=" + apellidosInput +
                "&telefono=" + telefonoInput;

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.GET, url, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            String estado = response.getString("estado");
                            if (estado.equals("1")) {
                                Toast.makeText(Registro.this, "Registro exitoso", Toast.LENGTH_SHORT).show();
                            } else {
                                Toast.makeText(Registro.this, "Error en el registro", Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(Registro.this, "Error de conexión", Toast.LENGTH_SHORT).show();
                    }
                });

        // Agregar la solicitud a la cola
        datos.add(jsonObjectRequest);
    }
}